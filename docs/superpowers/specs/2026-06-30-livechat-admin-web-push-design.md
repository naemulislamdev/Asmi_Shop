# Live Chat — Admin Web Push (FCM)

**Date:** 2026-06-30
**Status:** Approved, implementing

## Goal

Extend the live-chat admin console so an agent is notified of a new customer
message **even when the console tab is closed** — via FCM Web Push. Complements
today's in-tab beep/desktop/title-badge (which only work while the tab is open).

## Decisions (brainstorm)

- **Trigger:** push fires only when **no admin console is connected** (Node
  `admins` socket room empty). If someone's in the console, today's in-tab
  notifications already cover it.
- **Recipients:** all admins with a registered token. Per-token payload is
  recipient-aware — if the recipient is the conversation's `assigned_admin_id`,
  the title reads `🔔 Assigned to you — <customer>`; otherwise
  `New message — <customer>`.
- **Send location:** Node chat-service (the `admins`-room emptiness check and
  the `assigned_admin_id` both live there), via `firebase-admin` SDK.

## System context

Self-hosted chat: Node + Socket.IO `127.0.0.1:3001` behind nginx `/chat/`, own
DB `asmi_chat`. Admin console = Laravel `Admin\LiveChatController` +
`resources/views/admin/livechat/index.blade.php`, mints HS256 admin JWT Node
verifies. Firebase project **asmi-shop** (#401152501376) already used for App
Check (Android). Site served HTTPS at asmishop.com (web push requires HTTPS).

## Firebase assets (fetched 2026-06-30)

- **Web app config** (client-public): apiKey `AIzaSyBGUw7ijdogjwlBpCgnJSVE2_hcmmalSX4`,
  authDomain `asmi-shop.firebaseapp.com`, projectId `asmi-shop`,
  storageBucket `asmi-shop.firebasestorage.app`, messagingSenderId `401152501376`,
  appId `1:401152501376:web:146de2d90b8d1286eaa865`.
- **VAPID** (client-public): `BFGJdbi4OLfLbKp8fQzdiu4Pbeg29r60p-21bg2SBAd9UoY8htJLWoet54plfI_PTOiMU4rguGRcUFlIJEG7Nkw`.
- **Service account JSON** (SECRET): `asmi-shop-firebase-adminsdk-fbsvc-bad36ea084.json`.
  Lives ONLY on the live box at `/home/asmishop/chat/firebase-admin.json`
  (chmod600, owner asmishop). NEVER committed to git.

## Data — `asmi_chat` (manual DDL on live; Node-owned)

```sql
CREATE TABLE admin_push_tokens (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  admin_id BIGINT UNSIGNED NOT NULL,
  token VARCHAR(512) NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  UNIQUE KEY uq_token (token(191)),
  KEY idx_admin (admin_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## Components

### 1. Service worker — `public/firebase-messaging-sw.js`
Static, served at site root (scope `/`, covers `/admin/live-chat`). `importScripts`
the Firebase compat CDN (`firebase-app-compat` + `firebase-messaging-compat`),
init with the inline (client-public) firebaseConfig, `messaging.onBackgroundMessage`
→ `showNotification(title, {body, icon, data})`. `notificationclick` → focus an
existing `/admin/live-chat` tab or `clients.openWindow('/admin/live-chat')`.

### 2. Console JS — `index.blade.php`
On load (after today's permission prompt): load Firebase compat CDN, register
`/firebase-messaging-sw.js`, `getMessaging`, `getToken({ vapidKey, serviceWorkerRegistration })`.
On token → `POST {BASE}/admin/push/register` with `{ token }` and admin auth
header. Foreground messages stay handled by today's beep/desktop (no double-fire).
Wrapped in try/catch; unsupported browser / denied permission → silently skip.

### 3. Node — `chat-service/server.js`
- `POST /admin/push/register` (admin auth via `restAuth`): upsert
  `{admin_id: req.user.id, token}` into `admin_push_tokens` (INSERT … ON
  DUPLICATE KEY UPDATE admin_id, updated_at).
- Firebase init: if `FIREBASE_SA_PATH` set and file readable →
  `admin.initializeApp({credential: admin.credential.cert(require(path))})`,
  set `pushReady=true`. Else log once, `pushReady=false` (push disabled, chat fine).
- `maybePushAdmins(conv, msg)`: called from `message:send` (sender=user) AFTER the
  socket emit. Guard: `pushReady` AND `admins` room empty
  (`!io.sockets.adapter.rooms.get('admins')?.size`). Load all tokens; for each,
  build recipient-aware payload (assigned vs not); `sendEachForMulticast` (or
  per-token `send`). On error code `messaging/registration-token-not-registered`
  → delete that token row.
- All push code wrapped so any failure never breaks message delivery.

### 4. Config wiring
- firebaseConfig + VAPID: inline in SW + blade (client-public, OK in git).
- Service account: chat `.env` gets `FIREBASE_SA_PATH=/home/asmishop/chat/firebase-admin.json`.
  File pscp'd to box, chmod600. `firebase-admin` added to chat `package.json`
  (`npm install firebase-admin` on box).

## Error handling / safety

- Missing/invalid SA file or init failure → `pushReady=false`, send is a no-op.
  Chat unaffected.
- Push send wrapped in try/catch; never throws into `message:send`.
- Dead tokens auto-pruned on `registration-token-not-registered`.
- Browser opt-in; denied permission → no token registered → silent.
- Isolated process/port/DB, as the rest of chat. Live site untouched.

## Deploy

1. `CREATE TABLE admin_push_tokens` on `asmi_chat`.
2. pscp service account JSON → `/home/asmishop/chat/firebase-admin.json`, chmod600.
3. Add `FIREBASE_SA_PATH` to chat `.env`; `npm install firebase-admin` in
   `/home/asmishop/chat`.
4. pscp updated `server.js`; `supervisorctl restart asmi-chat`; verify `/health`.
5. pscp `public/firebase-messaging-sw.js` + updated `index.blade.php` to live.
6. Mirror code to repo (NOT the JSON, NOT .env). Commit local.

## Test

- `/health` 200 after restart; logs show `push ready` (SA loaded).
- Open console → browser asks notification permission → Allow → token row appears
  in `admin_push_tokens`.
- Close ALL console tabs. Send a customer message (app/web widget). → OS push
  notification arrives; assigned admin's reads "Assigned to you"; click opens
  `/admin/live-chat`.
- With a console tab OPEN, send customer message → NO push (in-tab beep/desktop
  only). Confirms the empty-room guard.
- Unregister/clear token (or revoke permission) → no push, no error.
