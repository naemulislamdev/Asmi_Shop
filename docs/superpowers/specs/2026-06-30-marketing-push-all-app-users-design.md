# Marketing Push to All App Users (FCM topic broadcast)

**Date:** 2026-06-30
**Status:** Approved, implementing (Phase 1)

## Goal

From the admin panel, send a marketing push notification (title + body) to **all
installed copies of the customer Flutter app**, via an FCM **topic broadcast**.

## Decisions (brainstorm)

- **Targeting:** always all users → single FCM topic `all`. App subscribes on
  launch; admin sends one message to the topic; FCM fans out. No per-device
  token storage.
- **Content:** title + body only. No image, no deep-link, no scheduling.
- **Send engine:** the Node chat-service (already has `firebase-admin` +
  service-account loaded). Laravel admin calls an internal endpoint. No Firebase
  creds duplicated into Laravel.
- **Platform:** Android only this phase (the live app). iOS needs APNs + the iOS
  port isn't released yet → later.

## System context

- Admin panel = Laravel at `/home/asmishop/htdocs/asmishop.com` (live). Session
  auth, admin guard (`App\Models\Admin`). Existing live-chat console shows the
  Laravel↔Node JWT bridge pattern (`Admin\LiveChatController` mints HS256 admin
  JWT from `env('JWT_SECRET')`).
- Node chat-service `127.0.0.1:3001` behind nginx `/chat/`. Already initialises
  `firebase-admin` (project asmi-shop) from `FIREBASE_SA_PATH`. `pushReady` flag.
- Flutter app `G:\asmi_shop\asmi_shop`: has `firebase_core` + `firebase_app_check`
  + `google-services.json`. NO `firebase_messaging` yet.

## Phasing

- **Phase 1 (now, no app release):** Node `/admin/broadcast` + Laravel admin UI +
  `push_campaigns` table. Usable immediately; reaches only devices subscribed to
  `all` (test devices for now).
- **Phase 2 (next app release):** app adds `firebase_messaging`, subscribes to
  `all` → blasts reach real users.

## Phase 1 — Node chat-service (`server.js`)

New `POST /admin/broadcast` (admin auth via `restAuth`):
- Body `{ title, body }`; both required, trimmed; reject empty (400).
- Guard `pushReady` (503 if FCM not configured).
- `messaging().send({ topic: 'all', notification: { title, body } })`.
- Return `{ ok:true, messageId }`. On FCM error → `{ ok:false, error }` 502.

## Phase 1 — Laravel admin

- **Route** (`routes/admin.php`, admin group): `GET /marketing-push` →
  `PushCampaignController@index`; `POST /marketing-push/send` → `@send`
  (names `admin.marketing-push`, `admin.marketing-push.send`).
- **Controller** `Admin\PushCampaignController`:
  - `index()` — `abort_unless` admin; show form + last 20 campaigns.
  - `send(Request)` — validate `title` (required, ≤120), `body` (required, ≤500);
    insert `push_campaigns` row (status `pending`); mint admin JWT (same helper
    pattern as LiveChatController); `Http::post('http://127.0.0.1:3001/admin/broadcast', …)`
    with `Authorization: Bearer <jwt>`; on success store `message_id`, status
    `sent`; on failure status `failed` + error. Redirect back with flash.
- **View** `admin/marketing-push/index.blade.php`: title input, body textarea,
  "Send to ALL users" button with a JS confirm dialog ("This sends to every app
  user. Continue?"). Table of recent campaigns (title, status, sent_by, time).
- **Sidebar:** link in `partials/admin-role/super.blade.php` near Live Chat.
- **Table** `push_campaigns` (main Laravel DB). Applied on live carefully (NOT a
  bare `php artisan migrate` — per first-order lesson the migrations table state
  is fragile; use targeted `migrate --path` or direct DDL):

```sql
CREATE TABLE push_campaigns (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  body VARCHAR(600) NOT NULL,
  topic VARCHAR(60) NOT NULL DEFAULT 'all',
  sent_by BIGINT UNSIGNED NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'pending',
  message_id VARCHAR(255) NULL,
  response TEXT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

A matching Laravel migration is committed for repo correctness; on live the table
is created directly to avoid touching the fragile migrations ledger.

## Phase 2 — Flutter app (`G:\asmi_shop\asmi_shop`) — next release

- `pubspec.yaml`: add `firebase_messaging` (+ `flutter_local_notifications` for
  foreground display).
- Startup (after `Firebase.initializeApp`): request notification permission
  (Android 13+ `POST_NOTIFICATIONS`), `FirebaseMessaging.instance.subscribeToTopic('all')`.
- Foreground `onMessage` → show via `flutter_local_notifications`. Background /
  terminated → system tray auto-shows (notification payload). Tap → open app.
- Android `google-services.json` already present; ensure the gms plugin applied
  (firebase_core already works → present).
- Committed uncommitted; ships on next store release.

## Error handling / safety

- Admin-only (controller `abort_unless`), confirm dialog before blast.
- Node `/admin/broadcast` JWT-gated; `pushReady` guard.
- Send wrapped; a Node/FCM failure marks the campaign `failed`, never 500s the
  panel. Campaign row always recorded for audit.
- Isolated: reuses the existing isolated Node process + secret. Live site
  untouched beyond the additive controller/route/view/table.

## Test

- Node `/admin/broadcast`: 401 unauth; with admin JWT + `{title,body}` → returns
  `messageId` (topic send succeeds even with zero subscribers — FCM accepts it).
- Admin page renders; submit → `push_campaigns` row `sent` + message_id stored.
- Subscribe a test device to `all` (or after Phase 2 app build) → device receives
  the push.
- Empty title/body → validation error, no send.
