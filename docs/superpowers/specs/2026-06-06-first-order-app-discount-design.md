# First-Order App Discount — Design

**Date:** 2026-06-06
**Status:** Draft for review
**Repos touched:** `asmi_shop_backend` (Laravel, root `project/`) and `asmi_shop` (Flutter app)

## Overview

Give a one-time **5% discount** on a **phone number's first order placed through the mobile app**.
Applied automatically (no code to type), computed on the product subtotal, no minimum, no cap.
Eligibility is keyed on the **customer phone** entered at checkout — so **guests qualify too, no login
required**. Eligibility and the discount amount are decided **server-side**; the client display is
cosmetic only.

## Locked decisions

| # | Decision | Choice |
|---|----------|--------|
| 1 | Identity / "first order" key | **Normalized customer phone.** First non-cancelled app order for that phone. Account (`user_id`) is intentionally NOT used. |
| 2 | Channel | `order_source = 'Mobile Apps'` only. Prior **website** orders are ignored. |
| 3 | 5% base | Product subtotal only (before tax, shipping, packaging). |
| 4 | Min / cap | None — flat 5%. |
| 5 | Application | Auto-applied, no promo code. Separate from the existing coupon UI. |
| 6 | Cancelled first order | Re-eligible — only **non-cancelled** prior app orders consume the offer. |
| 7 | Audience | **Guests included, no login required.** Identity is the phone, available on every order. |
| 8 | Rate control | Config value `first_order_discount_percent` (default `5`, `0` = feature off). |
| 9 | Abuse stance | Accept fake-phone re-claim risk (bounded by needing real, deliverable phone/address for COD). No OTP gate added. |
| 10 | Admin per-order display | New "First Order Discount −X" line in order details / invoice / print. |
| 11 | Admin list | "First order" badge + filter in the orders list, keyed on `first_order_discount > 0`. |
| 12 | Admin setting | On/off + percent editable in **General Settings** (`generalsettings.first_order_discount_percent`). |
| 13 | Discount-total report | Out of scope. |

## Phone normalization (mandatory prerequisite)

No phone canonicalization exists in the codebase today, and phones are stored exactly as typed
(`01805020340`, `+8801805020340`, `8801805020340`, spaced variants all differ as strings). The
phone-based check is only correct on a canonical form. Add one BD-targeted helper:

```php
// digits only → drop 880 country code → ensure leading 0 → 11-digit 01XXXXXXXXX
function normalizePhone(?string $raw): ?string {
    $d = preg_replace('/\D+/', '', (string) $raw);
    if (str_starts_with($d, '880')) $d = substr($d, 3);     // +8801805020340 → 1805020340
    if (strlen($d) === 10 && $d[0] === '1') $d = '0' . $d;   // 1805020340 → 01805020340
    return $d !== '' ? $d : null;
}
```

Examples → `01805020340`: `01805020340`, `+8801805020340`, `8801805020340`, `0 1805 020340`,
`+88001805020340` all canonicalize to `01805020340`.

## Eligibility (server is the source of truth)

Evaluated inside `CheckoutController::checkout()` before saving:

```php
$percent   = (float) setting('first_order_discount_percent', 5);
$normPhone = normalizePhone($input['customer_phone'] ?? null);

$eligible = $percent > 0
    && $normPhone !== null
    && Order::where('order_source', 'Mobile Apps')
        ->where('status', '!=', 'cancelled')
        ->where('customer_phone_normalized', $normPhone)
        ->doesntExist();
```

No `user_id` / `Auth` check — the phone is the identity (covers guests). The order history **is** the
one-time ledger; no separate "redeemed" flag. A cancelled first order is excluded, so cancelling
re-opens eligibility (decision #6). Empty/unparseable phone → ineligible (cannot dedup); `customer_phone`
is required at checkout anyway.

## Calculation & persistence

- `subtotal = $orderCalculate['total_amount_of_product']` (from `PriceHelper::getOrderTotal`).
- `firstOrderDiscount = round($subtotal * $percent / 100, 2)`.
- Subtract from the payable total; tax/shipping stay as computed today (flat line off the grand total,
  not a re-based tax):

```php
$orderCalculate['total_amount'] -= $firstOrderDiscount;
$input['first_order_discount']  = $firstOrderDiscount;
```

Insertion point: **between line 148 (`$orderCalculate = PriceHelper::getOrderTotal(...)`) and line 167
(`$input['pay_amount'] = $orderCalculate['total_amount'];`)**. The order saves via `$order->fill($input)`
with `$guarded = ['id']`, so `first_order_discount` and `customer_phone_normalized` auto-persist once the
columns exist.

## Server changes (`asmi_shop_backend`)

1. **Migration**
   - `orders.first_order_discount` DECIMAL(10,2) NOT NULL DEFAULT 0.
   - `orders.customer_phone_normalized` VARCHAR(20) NULL, **indexed**.
   - **Backfill** `customer_phone_normalized` for ALL existing orders from `customer_phone` via the
     normalizer. **Critical:** without backfill, every existing customer's next app order has no prior
     normalized-phone match → looks like a "first order" → launch-day mass discount.
2. **Normalizer** — `normalizePhone()` helper (place in `app/Helpers/helper.php` or a small PhoneHelper).
3. **Config/setting** — `first_order_discount_percent` stored as a column on the `generalsettings`
   table (admin-editable via General Settings; see Admin panel changes). `0` = feature off. Checkout
   and the eligibility endpoint read it via `Generalsetting::find(1)`.
4. **`CheckoutController::checkout()`** — set `$input['customer_phone_normalized'] = $normPhone;`, run the
   eligibility check, subtract the discount.
5. **Eligibility endpoint for pre-order display** — `POST /api/front/first-order-eligibility { phone }`
   → `{ eligible: bool, percent: number }`, running the same server-side check on the normalized phone.
   (A query param/GET is fine too.) This must be phone-parameterized because the user types the phone on
   the checkout page — it isn't known at app-init time.
6. **Order resources** — add `first_order_discount` (and a `subtotal`) to `OrderDetailsResource` so the
   confirmation/details screen shows what the customer saved.

## App changes (`asmi_shop`)

1. On the checkout page, after the phone field is filled/valid (debounced), call
   `first-order-eligibility` with the entered phone. Store `eligible` + `percent` in `CheckoutBloc`.
2. When eligible, compute `firstOrderDiscount = subtotal * percent / 100` and subtract it in
   `getFinalPrice()`. **Cosmetic only** — the server recomputes authoritatively; if values diverge the
   server wins.
3. In `module/checkout/view/payment_details.dart`, add a `singleRow('First order discount (5%)', '-৳X')`
   line, shown only when eligible.
4. Not eligible → row hidden. No new input field (distinct from the existing "Have Promotion code" coupon
   flow, which keeps working unchanged).

```
Price Details
  Total MRP            ৳2,500
  First order disc 5%   −৳125   ← new, only when eligible (phone qualifies)
  Tax                   ৳…
  Shipping / Packaging  ৳…
  ────────────────────────────
  Total                 ৳…
```

## Admin panel changes (`asmi_shop_backend`, Blade)

1. **Per-order discount line** — render "First Order Discount −৳X" when `first_order_discount > 0`,
   next to the existing coupon/discount line, in `admin/order/details.blade.php` (and/or `details2`),
   `invoice.blade.php`, `print.blade.php`, and `branch_orders/single.blade.php` if used. Confirm the
   active detail view during planning. `pay_amount` is already net of it, so collectible/COD totals
   stay correct.
   - **Do NOT reuse** the generic `discount` / `discount_type` field: `Admin/OrderController` recomputes
     it on order edit (would clobber the first-order value) and web COD overloads it for loyalty points.
2. **Order-list flag + filter** — a "First order" badge on rows where `first_order_discount > 0`
   (`admin/order/index.blade.php` + status views), plus a filter
   (`Order::where('first_order_discount','>',0)`) in `Admin/OrderController`.
3. **Setting** — add `first_order_discount_percent` to `generalsettings` (migration), a field in the
   General Settings admin form + `GeneralSettingController` save handling. `0` disables the feature.

## Edge cases

- **Fake-phone re-claim** (accepted, decision #9): unverified guest phone means a new phone = new "first
  order". Bounded by needing a real, deliverable phone/address (COD). No OTP gate in scope.
- **Phone normalization collisions/misses** — handled by the canonical column + backfill above. Non-BD or
  malformed numbers normalize to digits-only; acceptable for this market.
- **Concurrent double-submit** (two orders before either is recorded): both could pass the check and get
  5%. Low risk; noted only, no lock in scope.
- **Coupon stacking**: independent — a real coupon and the first-order discount can both apply, each in
  its own field (`coupon_discount` vs `first_order_discount`).

## Testing (backend feature tests)

1. First app order for a phone → 5% applied, `first_order_discount` set, `pay_amount` reduced by exactly
   that amount, `customer_phone_normalized` stored.
2. Second app order, same phone (any format variant, e.g. `+880…`) → no discount (normalization matches).
3. Phone with only website-order history → first app order **is** discounted.
4. Guest (no token) with a fresh phone → discounted (login not required).
5. First app order cancelled, then a new app order same phone → discounted again (re-eligible).
6. Backfill: a pre-existing app order's phone → that phone is **not** treated as first-order after deploy.
7. `first_order_discount_percent = 0` → feature off.
8. Empty/garbage phone → no discount, no crash.
9. Admin: order with `first_order_discount > 0` shows the badge and matches the list filter; the
   per-order line renders the stored amount.

## Out of scope (YAGNI)

- OTP-gated discount, multi-account/fraud prevention beyond phone dedup, web-channel first-order discount,
  configurable min/cap (can be layered on the config value later), admin discount-total report.

## Open items / to confirm during planning

- Confirm `customer_phone` is always present + required on the app checkout request (drives validation).
- Which admin order detail view is active (`details.blade.php` vs `details2.blade.php`) + whether
  `branch_orders/single.blade.php` needs the line too.
- Whether `OrderResource` (list view) also needs the discount, or details-only is enough.
- Backfill strategy for very large `orders` tables (chunked update command vs inline migration).
