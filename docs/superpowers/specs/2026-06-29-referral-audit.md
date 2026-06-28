# Referral System — Security & Correctness Audit (2026-06-29)

Feature LIVE (`generalsettings.is_refer = 1`) from 2026-06-29. Two independent
adversarial reviews (points-integrity + security/abuse) of the deployed code,
plus DB verification. **No fixes applied — user chose report-only.** Findings
recorded here for later action.

## Verified environment facts
- `users.wallet_points` = `decimal(10,2)` **signed** (can go negative; no DB exception on underflow).
- `orders`, `referrals`, `users` = **InnoDB** (so `lockForUpdate` works).
- `referrals.referee_phone_normalized` **UNIQUE index present** (`referrals_referee_phone_normalized_unique`).
- `customer_phone_normalized` NULL/empty on **222 of 9219** orders.

## Solid (no action)
- No SQL injection — `resolveReferrer` uses bound `whereRaw('UPPER(referral_code)=?',[...])`; code is `varchar(16)`, trimmed, only bound/stored via Eloquent.
- `GET /api/user/referral` is `auth:api`, derives user only from `Auth::guard('api')->user()`, no id param → no IDOR; exposes only caller's own data.
- Reward is admin-only: only `Admin/OrderController@update` (auth:admin) calls `rewardForOrder`; no customer-reachable path sets status=completed. `admin-order-status` route does NOT reward.
- Reward idempotent + atomic: `DB::transaction` + `lockForUpdate()` on `status='pending'` row, terminal `void`. Concurrent double-complete cannot double-pay.
- Self-referral normalization strong: `PhoneHelper::normalize` collapses all `01/+88/880/spacing` variants → equality guard catches same-number dodges.
- `referred_by` only set when empty → no attribution theft.
- UNIQUE(referee_phone_normalized) makes a second referral row per phone impossible; capture is fail-safe (try/catch) so a unique violation never 500s checkout.

## Findings (open)

### H2 — reverse can drive wallet_points negative (HIGH, ours)
`ReferralHelper::reverseForOrder` does `decrement('wallet_points', points)` with
no floor. If the user already spent the rewarded points, balance goes negative
(signed column → silent, no exception). **Fix:** clamp `max(0, balance - points)`.

### M2 — findOrCreateReferee email collision rolls back reward (MED, ours)
Referee lookup is by phone (`phone` / `+88`.phone). If `<phone>@asmi.local`
already exists under a different phone format, `save()` throws **inside the
reward `DB::transaction`** → whole reward rolls back (referrer increment undone),
row stays `pending`, error swallowed. **Fix:** `firstOrCreate` by email, or look
up by email too; tolerate the collision.

### M3 — 222 orders missing customer_phone_normalized (MED, data)
First-order guard counts `orders` by `customer_phone_normalized`. A returning
customer whose past orders are among the 222 nulls can pass the "first order"
gate once (capped at 1 referral by UNIQUE). **Fix:** backfill
`customer_phone_normalized` for those rows.

### A1 — self-referral / point farming via cheap second SIMs (HIGH, design)
One-time both-sided payout per phone + zero-cost COD orders + no device/IP/
address correlation. A farmer with N cheap BD SIMs places N first-orders with
their own code; once an admin completes each, they mint N× payouts of spendable
`wallet_points`. The phone-equality self-referral guard does NOT stop a
*different* phone the same person controls. **Mitigations (need product call):**
velocity cap per `referrer_id`; correlate referrer↔referee shared
`customer_address` / `order_lat,order_lng` (geo columns already exist) and
hold/flag; cap lifetime referral points; require delivered+paid not just
admin-completed.

### C1 — pre-existing loyalty double-credit (HIGH, NOT introduced by referral)
`Admin/OrderController@update` (the loyalty block above the referral hook)
increments `wallet_points` by `loyalty_point` every time the form is saved with
`status=completed`, with no "status actually changed" guard. Re-save / cancel→
complete cycles re-credit. Same currency the referral feature pays into.
**Pre-existing**; flagged because it shares the trigger and the currency.
**Fix (if desired):** capture `$old=$data->status` before assignment and gate all
point side-effects on `$old !== $input['status']`.

## Status
Live with these open. Revisit H2/M2/M3 (low-risk, ours) first; A1 + C1 need
product decisions. See [[asmishop-referral-system]].
