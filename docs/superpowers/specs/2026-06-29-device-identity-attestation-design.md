# Device Identity & Attestation — Design

**Date:** 2026-06-29
**Backend:** Laravel, LIVE server is source of truth (`/home/asmishop/htdocs/asmishop.com`, root@144.79.133.74). Local backend repo is STALE — read/deploy via server. See [[asmishop-repo-drift]].
**App:** Flutter `asmi_shop` (`G:\asmi_shop\asmi_shop`) — local repo IS source of truth. Currently has NO Firebase / no device packages.

## Goal

A hard-to-forge, shared device identity for the app: a stable per-install
`device_id` proven genuine by a Firebase **App Check** token (Play Integrity on
Android now; App Attest on iOS when that app ships). Consumed by:
- **Referral anti-farming** — cap referrals per physical device.
- **Login-alerts** — unify `user_login_sessions` on `device_id`.
- **Future fraud checks** — shared `devices` table + verify-once service.

## Decisions (locked with user)
- Strongest path: **Play Integrity / App Attest via Firebase App Check** (not FCM token / FID, which are not stable identities).
- **Android now; iOS-ready abstraction** (iOS app not released — wire App Attest provider but it stays dormant/untested until iOS ships).
- **Shared device-identity layer** (referral + login + fraud), not referral-only.
- Accepted limitation: multiple genuine physical devices still defeat dedup —
  acceptable because each costs a real Play-certified device. Goal is raise
  cost + detect, NOT absolute prevention. **No device id is foolproof.**

## Identity model — two parts
1. **device_id** — UUID generated once by the app, persisted in secure storage
   (`flutter_secure_storage`; iOS Keychain survives reinstall, Android
   Keystore/encrypted-prefs best-effort). Purpose: dedup / per-device cap.
2. **App Check token** — short-lived RS256 JWT from Firebase App Check.
   Purpose: prove a genuine app on a genuine device produced the request.

**Server trusts a `device_id` ONLY when it arrives with a valid App Check
token.** A device_id from a script/emulator/curl has no valid token → untrusted →
no referral credit. This is what forces a farmer onto genuine devices.

## Why App Check (not raw Play Integrity / not Firebase Admin SDK)
- App Check wraps Play Integrity (Android) + App Attest/DeviceCheck (iOS) behind
  ONE SDK and ONE token type → single server verification path for both platforms.
- App Check tokens are standard RS256 JWTs. Server verifies them directly against
  Google's public JWKS — no Firebase Admin SDK, no service-account, no Google
  Play Integrity API server call needed. `firebase/php-jwt` (likely already
  vendored for the app's JWT auth) suffices.

## Components

### Backend (Laravel — server-as-truth deploy)

**`app/Services/AppCheckVerifier.php` (new)**
- `verify(string $token): ?array` — decode + validate the App Check JWT:
  - fetch + cache Google App Check JWKS (`https://firebaseappcheck.googleapis.com/v1/jwks`), RS256.
  - check `iss` = `https://firebaseappcheck.googleapis.com/<PROJECT_NUMBER>`,
    `aud` contains `projects/<PROJECT_NUMBER>`, `exp` not past, `sub` = app id.
  - return `['app_id'=>sub]` on success, `null` on any failure. Never throws.
- Config: `PROJECT_NUMBER`, allowed app ids in `.env` (`APPCHECK_PROJECT_NUMBER`,
  `APPCHECK_APP_IDS`). JWKS cached (Cache::remember, ~6h).

**`devices` table (new migration)**
```
id, device_id (varchar UNIQUE), platform (android|ios|unknown),
attested (tinyint default 0), attest_fail_count (int default 0),
referrals_count (int default 0), first_seen_at, last_seen_at, notes (nullable),
created_at, updated_at
```

**`device_user` table (new) — device↔identity over time**
```
id, device_id (index), user_id (nullable, index), phone_normalized (index),
first_seen_at
UNIQUE(device_id, phone_normalized)
```

**`app/Services/DeviceService.php` (new)**
- `register(?string $deviceId, ?string $token, Request $r, ?string $phone=null, ?int $userId=null): array`
  - verify token via AppCheckVerifier; `$attested = (bool) result`.
  - upsert `devices` (set platform from request/app, bump last_seen, set attested,
    inc attest_fail_count when token present but invalid).
  - link `device_user` (deviceId ↔ phone/user) when known.
  - return `['device_id'=>..., 'attested'=>bool]`.
- `isTrusted(string $deviceId): bool` — devices row exists AND attested.

**Endpoints / routes**
- `POST /api/device/register` (no auth required — guests have devices too): body
  `{device_id, app_check_token, platform}`. Calls DeviceService::register. App
  calls on launch + after login.
- Checkout (`Api/Front/CheckoutController@checkout`): read `device_id` +
  `app_check_token` from body; `DeviceService::register(...)` (attaches phone);
  pass attested device_id into referral capture.

**Generalsetting**
- `refer_max_per_device` (int, default 1, admin-editable on the Refer & Earn
  settings page). 0 = unlimited.

### Referral enforcement (extends existing ReferralHelper)
`captureAtCheckout(?code, Order, ?string $deviceId, bool $deviceTrusted)`:
- if `is_refer` on AND (a NEW guard) **device required**: when `$deviceId` is
  empty or `!$deviceTrusted` → skip capture (order still places). Gated by a
  setting `refer_require_attested_device` (default 1) so it can be relaxed.
- per-device cap: count referrals where `referee_device_id = $deviceId`
  (add `device_id` column to `referrals`); if `>= refer_max_per_device` → skip.
- existing guards (per-code cap, same-phone, first-order, one-per-phone) unchanged.

`referrals` gains `device_id` (nullable, index) — the referee's attested device.

### Login-alerts unification
- Add `device_id` (nullable, index) to `user_login_sessions`.
- OTP-verify / login records `device_id` (from body); new-device alert keyed on
  `device_id` when present (fallback to user_agent). Backward compatible.

### App (Flutter)
- pubspec: `firebase_core`, `firebase_app_check`, `flutter_secure_storage`, `uuid`.
- `lib/services/device_identity.dart`:
  - `getDeviceId()` — read from secure storage; if absent, generate `uuid.v4()`,
    store, return.
  - `getAppCheckToken()` — `FirebaseAppCheck.instance.getToken()`.
  - `platform()` — 'android' / 'ios'.
- init in `main()`: `Firebase.initializeApp()`, `FirebaseAppCheck.activate(
  androidProvider: playIntegrity, appleProvider: appAttest)` (debug provider in
  debug builds).
- On launch + after OTP login: call `POST /api/device/register`.
- Checkout body: add `device_id` + `app_check_token`.
- Android only for now; iOS providers wired but exercised when iOS ships.

## Data flow
```
app launch -> getDeviceId() (secure storage) + getAppCheckToken()
           -> POST /api/device/register {device_id, app_check_token, platform}
           -> AppCheckVerifier.verify -> devices upsert (attested=1/0)
checkout   -> body {..., device_id, app_check_token}
           -> CheckoutController: DeviceService::register(attach phone)
           -> ReferralHelper::captureAtCheckout(code, order, deviceId, trusted)
              -> require trusted device + per-device cap, then existing guards
login(OTP) -> record device_id on user_login_sessions, new-device alert
```

## Failure policy
- **Orders never blocked.** Missing/invalid token or old app → order completes
  normally; device marked unattested; referral simply not captured.
- Old app versions (no App Check) → unattested → no referral reward, orders fine.
  Referral fully works only on app builds with App Check (rolls out with release).
- Verifier errors / JWKS fetch failure → treat as unattested (fail-closed for
  rewards), logged. Never 500 checkout.

## Infra — OWNER (user) actions, not code
These require the user's Google/Firebase/Play accounts (cannot be done by code):
1. Create (or reuse) a Firebase project; add the Android app (package
   `com.asmishop.android`); download `google-services.json` into `android/app/`.
2. Enable the Play Integrity API (Google Cloud) and link the Play Console app.
3. In Firebase Console → App Check: register the Android app with the
   **Play Integrity** provider. Generate a **debug token** for dev/testing.
4. Note the **project number** + **app id** → backend `.env`
   (`APPCHECK_PROJECT_NUMBER`, `APPCHECK_APP_IDS`).
5. (iOS later: add iOS app, App Attest provider, APNs config.)
Code + exact click-by-click steps will be provided; the user performs the console
steps and supplies `google-services.json` + project number/app id.

## Testing
- App: App Check **debug provider** + registered debug token → real getToken() in dev.
- Backend unit: `AppCheckVerifier` against mocked JWKS — valid, expired, wrong
  `aud`, wrong `iss`, tampered signature, malformed → only valid returns app id.
- Backend e2e (tinker/curl): attested register → devices.attested=1; checkout
  with valid token → referral captured + per-device cap enforced; checkout with
  no/invalid token → no referral, order still placed.

## Rollout order
1. Backend inert: migrations (`devices`, `device_user`, `referrals.device_id`,
   `user_login_sessions.device_id`, gs `refer_max_per_device` +
   `refer_require_attested_device`), `AppCheckVerifier`, `DeviceService`,
   `/api/device/register`. Deployed but referral device-gate OFF
   (`refer_require_attested_device=0`) until app ships.
2. App: Firebase App Check + device_id + payload wiring (needs user's Firebase
   setup first). Release.
3. Flip `refer_require_attested_device=1` after the attested app build is live.

## Out of scope
- iOS App Attest activation (until iOS app released).
- FCM push (separate pending work).
- Web/browser device fingerprinting (referral is app-only).
- IP-based velocity (could layer later; not in this spec).
