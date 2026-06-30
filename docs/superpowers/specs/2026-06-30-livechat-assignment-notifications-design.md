# Live Chat — Agent Assignment + WhatsApp-web Notifications

**Date:** 2026-06-30
**Status:** Approved, implementing

## Goal

Admin live-chat console gains:
1. **Agent assignment** — claim/assign a conversation to a specific admin, with a visible tag and a "My chats / All" filter (label + filter only; no hard ownership lock).
2. **WhatsApp-web style notifications** — sound + desktop notification + tab-title unread badge when a new customer message arrives, while the console tab is open (backgrounded fine).

Non-goal (later phases): closed-tab push (FCM/service worker), hard ownership lock, auto round-robin.

## System context

Self-hosted chat is isolated: Node + Socket.IO at `127.0.0.1:3001` behind nginx `/chat/`, own DB `asmi_chat`. Local source `G:\asmi_shop\chat-service\server.js` (NOT in git). Admin console = Laravel `Admin\LiveChatController` + `resources/views/admin/livechat/index.blade.php`, session-auth, mints HS256 admin JWT that Node verifies. Realtime today: `message:new`, `inbox:update`. Per-conv `unread_admin` already shown.

## Data — `asmi_chat.chat_conversations` (manual ALTER on live; Node-owned, not Laravel migration)

- `assigned_admin_id` — already exists, currently unused → reuse.
- ADD `assigned_admin_name VARCHAR(120) NULL` — denormalized so Node/inbox renders the tag without reaching into Laravel's user table.

```sql
ALTER TABLE chat_conversations ADD COLUMN assigned_admin_name VARCHAR(120) NULL AFTER assigned_admin_id;
```

## Backend — Laravel (`Admin\LiveChatController`)

- `index()` — also pass `adminId` to the view (already passes `adminName`) → powers "Assign to me".
- New `admins()` → `GET /admin/chat/admins`, admin-gated → `{status, admins:[{id,name}]}` of admin users for the assign dropdown. (Admins live in the Laravel DB, not `asmi_chat`, so Laravel must serve this list.)
- Route registered in `routes/admin.php` next to existing `admin.chat.context`.

## Backend — Node (`chat-service/server.js`)

- New REST `POST /admin/conversations/:id/assign` (admin auth via existing `restAuth`), body `{assigned_admin_id, assigned_admin_name}`:
  - `assigned_admin_id` null/absent → unassign (both cols NULL).
  - UPDATE both cols; emit `io.to('admins').emit('inbox:update', { conversation_id, assigned_admin_id, assigned_admin_name })`.
  - Returns `{ok:true}`.
- `GET /admin/conversations` already `SELECT *` → assignment cols flow through once the column exists. No change needed there beyond confirming.

## Front-end — admin console (`index.blade.php`)

State: `myId` (from `$adminId`), `myName` (`$adminName`), `admins[]` (loaded once), `filterMine` (bool), `unreadTotal`.

- **Admin list:** on load, `GET /admin/chat/admins` → cache for dropdown.
- **Assign UI** (thread header): `Assign ▾` dropdown = *Me* + every admin + *Unassign*. Pick → `POST /chat/admin/conversations/:id/assign` → update local row, re-render tag + inbox. `Assigned: <name>` tag shown in header and as a small line in each inbox row.
- **Filter:** inbox header toggle `All | My chats`. `My chats` = rows where `assigned_admin_id === myId`. Pure client-side filter over the already-loaded list.
- **Notifications** (tab open required; backgrounded OK):
  1. **Sound** — short WebAudio beep (oscillator, no asset file) on `message:new` where `sender_type === 'user'`.
  2. **Desktop** — `Notification.requestPermission()` on load; on customer `message:new`, show `New message — <name>`; click → `window.focus()` + open that conversation.
  3. **Tab title** — maintain `unreadTotal` (sum of `unread_admin`, or increment on customer message); set `document.title = '(' + n + ') Live Chat'`; clear to plain title on `window.focus` / `visibilitychange` visible.
  - Suppress sound/desktop when the message is for the currently-open conversation AND the tab is focused (already reading it).

## Live-safety

All additive; chat stays isolated (own process/port/DB). Deploy: manual ALTER on `asmi_chat`, `pscp` updated `server.js` → supervisor restart `asmi-chat`, `pscp` updated blade + push controller/route via repo mirror. Laravel site untouched apart from the additive controller method + route. Repo files mirrored; commits local only (no push without explicit permission).

## Test

- ALTER applies; Node restarts clean (`/health` 200).
- `GET /admin/chat/admins` returns admin list (403 unauth).
- Assign to me / to another admin / unassign → tag updates both header + inbox, persists across reload, `inbox:update` refreshes other open consoles.
- `My chats` filter shows only my-assigned convs.
- New customer message while tab backgrounded → beep + desktop popup + `(n) Live Chat` title; opening that conv clears its unread; focusing tab clears title badge.
