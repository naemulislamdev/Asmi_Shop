# Refer & Earn (Referral System) — Design

**Date:** 2026-06-28
**Backend:** Laravel, LIVE server is source of truth (`/home/asmishop/htdocs/asmishop.com`, root@144.79.133.74) — local repo is STALE, do not read/deploy from it blindly. See repo-drift rule below.
**App:** Flutter `asmi_shop` (`G:\asmi_shop\asmi_shop`) — local repo IS source of truth.

## Goal

Customer referral ("Refer & Earn"): an existing user shares a short code; a new
user enters it on their first order; when that order completes, BOTH users get
loyalty points. Grows the user base using the existing loyalty-points economy.

## Decisions (locked with user)

- **Reward currency:** `users.wallet_points` (the live loyalty-points balance —
  NOT the older `reward`/`reward_point` fields, which are inactive). Same balance
  users already earn per order and spend at checkout.
- **Who earns:** both — referrer gets `refer_referrer_points`, referee gets
  `refer_referee_points`.
- **Trigger:** on the referee's **first** order reaching status `completed`.
- **Capture point:** a "Have a referral code?" field on the checkout screen
  (parallels the coupon field). App login is OTP-only with no signup form, so
  checkout is the natural capture point.
- **Code style:** short, system-generated, e.g. `ASMI3K7` (prefix `ASMI` +
  base36 of user id, uppercased). No user-chosen vanity codes.
- **Admin:** toggle + amounts in `generalsettings`, gated OFF until tested.

## Live system facts (verified on server 2026-06-28)

- Loyalty balance column: `users.wallet_points`. Per-order earned points:
  `orders.loyalty_point`.
- Completion hook EXISTS: `app/Http/Controllers/Admin/OrderController.php`
  `update(Request,$id)` — when `$input['status']=='completed'` it does
  `$data->user->increment('wallet_points', $loyaltyPoint)`; on `'cancelled'`
  it decrements. This is where referral reward crediting hooks in.
- COD path computes/earns/spends points:
  `app/Http/Controllers/Payment/Checkout/CashOnDeliveryController.php`
  (`$user->wallet_points += $earnedPoints`, `$input['loyalty_point']=...`).
- First-order detection: `Api/Front/CheckoutController` uses
  `App\Helpers\PhoneHelper::normalize($phone)` and counts orders where
  `customer_phone_normalized == $normPhone` (0 == first order). `orders` has
  `customer_phone_normalized`.
- Order statuses in use: `pending`, `processing`, `on delivery`, `completed`,
  `cancelled`, `return`.
- `generalsettings` fillable already has the loyalty/first-order toggles
  (`is_reward`, `reward_point`, `reward_dolar`, `point_of_amount`,
  `amount_of_point`, `first_order_discount_percent`).
- App-placed orders frequently have `orders.user_id = NULL` (guest/COD).
  Therefore reward crediting MUST resolve users by normalized phone, not by
  `order.user_id`.
- Existing product-affiliate system (`affilate_code` md5, `affilate_income`,
  `AffliateBonus`, `OrderHelper::affilate_check`) is SEPARATE and untouched.

## Data model (all additive, nullable; live DB)

### users (new columns)
- `referral_code` VARCHAR(16) UNIQUE NULL — short share code (`ASMI`+base36(id)).
  Generated lazily on first read of the referral endpoint and backfilled by a
  one-off script. Uppercase, no ambiguous chars beyond base36.
- `referred_by` BIGINT UNSIGNED NULL — referrer's user id. Set once at capture,
  never overwritten.

### referrals (new table) — the ledger / idempotency anchor
```
id                         BIGINT PK
referrer_id                BIGINT  (users.id, the code owner)         INDEX
referee_phone_normalized   VARCHAR(20)                               INDEX
referee_user_id            BIGINT NULL (resolved/created at reward)
code                       VARCHAR(16)  (code used, denormalized)
order_id                   BIGINT  (the first order that carried it) INDEX
status                     ENUM('pending','rewarded','void') default 'pending' INDEX
referrer_points            INT default 0  (snapshot at reward time)
referee_points             INT default 0
created_at, rewarded_at    TIMESTAMP NULL
UNIQUE(referee_phone_normalized)   -- one referral per referee, ever
```
Idempotency: reward crediting only acts on a row that is `pending`; flips it to
`rewarded` in the same transaction. Re-completion / repeated webhook → no-op.

### generalsettings (new fillable keys)
- `is_refer` TINYINT default 0 — master toggle.
- `refer_referrer_points` INT default 0 — points to referrer.
- `refer_referee_points` INT default 0 — points to referee.

## Components

### 1. `ReferralHelper` (new) — `app/Helpers/ReferralHelper.php`
Single home for referral logic, keeping controllers thin.
- `codeForUser(User $u): string` — returns existing `referral_code` or generates
  `strtoupper('ASMI'.base_convert($u->id,10,36))`, persists, returns it. Unique
  by construction since user id is unique, so no collision handling needed.
- `resolveReferrer(string $code): ?User` — find user by `referral_code` (case-
  insensitive), else null.
- `captureAtCheckout(array $input, Order $order): void` — called after an order
  is saved in `Api/Front/CheckoutController`. Guards (ALL must hold):
  - `is_refer` on,
  - `referral_code` present + resolves to a referrer,
  - this is the referee's first order (`customer_phone_normalized` count == 1,
    i.e. only this just-saved order),
  - referrer's normalized phone != referee's normalized phone (no self-referral),
  - no existing `referrals` row for this `referee_phone_normalized`.
  On pass: insert `referrals`(pending, order_id, code, referrer_id,
  referee_phone_normalized) and set referee user's `referred_by` if that user
  exists.
- `rewardForOrder(Order $order): void` — called when an order becomes
  `completed`. In a DB transaction:
  - find `referrals` row by `order_id` with status `pending`; return if none,
  - load amounts from `generalsettings` (`refer_referrer_points`,
    `refer_referee_points`),
  - referrer = `User::find(referrer_id)`,
  - referee = find user by normalized phone == `referee_phone_normalized`;
    if none, create one (mirror existing auto-create-from-order pattern) so the
    points have a home; store `referee_user_id`,
  - `increment('wallet_points', ...)` for each, snapshot points into the row,
    set `status='rewarded'`, `rewarded_at=now()`.
- `reverseForOrder(Order $order): void` — called when a previously completed
  order becomes `cancelled`/`return`. If row is `rewarded`: decrement both
  users' `wallet_points` by the snapshot amounts, set `status='void'`.

### 2. Capture — `Api/Front/CheckoutController@checkout`
After `$order->fill($input)->save()` (and after the existing first-order /
coupon blocks), call `ReferralHelper::captureAtCheckout($input, $order)`. The
app adds `referral_code` to the checkout body (empty string when unused).

### 3. Reward — `Admin/OrderController@update`
Inside the existing `if ($input['status']=='completed')` branch, after the
loyalty increment, call `ReferralHelper::rewardForOrder($data)`. Inside the
`'cancelled'` branch (and add `'return'`), call
`ReferralHelper::reverseForOrder($data)`. Mirror the same calls in any other
path that sets an order to completed (COD controller if it auto-completes —
verify on server; if COD orders are completed only via admin `update`, that one
hook suffices).

### 4. Read API — `GET /api/user/referral` (auth)
`Api\User\ProfileController@referral` returns:
```json
{ "status": true, "data": {
  "code": "ASMI3K7",
  "share_text": "Use my code ASMI3K7 on ASMI SuperShop...",
  "referrer_points": 50, "referee_points": 30,
  "total_invited": 4, "pending": 1, "rewarded": 3,
  "points_earned": 150,
  "wallet_points": 320
}}`
```
Computes/persists code via `ReferralHelper::codeForUser`. Stats from `referrals`
where `referrer_id == auth id`.

### 5. Admin settings
New blade `resources/views/admin/generalsetting/refer.blade.php` mirroring
`affilate.blade.php`: toggle `is_refer`, inputs `refer_referrer_points`,
`refer_referee_points`. Route + sidebar link under settings. Add the three keys
to `Generalsetting` `$fillable`.

### 6. Flutter app
- **Checkout:** add a "Have a referral code?" field in the checkout form
  (near the coupon UI). Store in the checkout bloc; add `referral_code` to the
  order body map. Only meaningful on a first order; backend enforces.
- **Account → Refer & Earn:** wire the currently-dead "Affiliate Balance"
  menu item (`my_account_view.dart`) — or add a new "Refer & Earn" item — to a
  new screen that calls `GET /api/user/referral`, shows the code, a copy button,
  a `share_plus` share sheet, and the stats (invited / pending / earned /
  current points).

## Data flow

```
Referrer opens Refer&Earn -> GET /api/user/referral -> code ASMI3K7 + stats
Referrer shares code (share_plus)
Referee (new user) checkout -> body.referral_code = ASMI3K7
  -> CheckoutController saves order
  -> ReferralHelper::captureAtCheckout (first-order + valid + not-self + unused)
     -> referrals row (pending), referee.referred_by set
Admin marks that order 'completed'
  -> OrderController@update completed branch
     -> ReferralHelper::rewardForOrder
        -> referrer.wallet_points += R ; referee.wallet_points += F
        -> row -> rewarded
(If later cancelled/returned -> reverseForOrder -> points reversed, row void)
```

## Error handling / edge cases

- `is_refer` off → capture + reward are no-ops.
- Invalid / unknown code → ignored silently (order still places).
- Self-referral (same normalized phone) → ignored.
- Referee already has a `referrals` row → ignored (one referral per phone).
- Not first order → ignored.
- Order completed but no pending referral row → no-op.
- Re-completion / duplicate status writes → idempotent via row status.
- Referee has no user account → created by phone at reward time so points persist.
- Cancel/return after reward → points reversed, row void; re-complete after that
  stays void (no double credit).
- All referral logic is wrapped so a failure never blocks order placement or
  status update (catch + log, fail-safe), matching the first-order/coupon style.

## Testing

- Unit (where pure/php-testable on server or local mirror): code generation
  (`ASMI`+base36 deterministic), guard logic of `captureAtCheckout`
  (first-order/self/duplicate), idempotency of `rewardForOrder`.
- Manual end-to-end on a staging phone pair (or two app installs / two phones):
  1. User A reads code. 2. New phone B places first order with A's code →
  `referrals` row pending. 3. Admin completes B's order → A and B
  `wallet_points` increase by configured amounts, row `rewarded`. 4. Cancel →
  reversed. 5. B's second order with any code → ignored.
- Verify via SQL on `referrals` + `users.wallet_points` deltas.

## Deployment (server = source of truth)

Per repo-drift rule: for EACH backend file to change, pull the LIVE copy, diff
against intended edit, re-apply onto the live version, keep a `*.refer.bak`
backup, `pscp` up. Run the migration with
`php artisan migrate --path=database/migrations/<file> --force` (never bare
`migrate`). Backfill `referral_code` for existing users with a one-off guarded
script. Ship gated OFF (`is_refer=0`); enable after manual test. App ships in a
later release; backend is backward-compatible (ignores absent `referral_code`).

## Out of scope

- Vanity/custom codes.
- Deep-link auto-apply of codes (could be a later enhancement).
- Multi-level / tiered referral.
- Touching the separate product-affiliate (`affilate_*`) system.
