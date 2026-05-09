# Reward & Preorder API — Design / Integration Doc

**Date:** 2026-05-02
**Scope:** Backend API only. No web (blade/admin) changes. No Flutter changes.
**Repo:** `G:/asmi_shop/asmi_shop_backend` (Laravel)

---

## Goal

1. Mirror website's reward/point system on API side, plus add forward-only earning history.
2. Expose product `preordered` flag through API so Flutter can render preorder UI.

Flutter dev consumes new endpoints — no backend changes needed beyond what's listed here.

---

## Part 1 — Reward / Point System

### 1.1 Existing (kept unchanged)

| Method | Path | Purpose |
|--------|------|---------|
| GET    | `/api/user/reword/get`   | Convert-only history (used by current Flutter) |
| POST   | `/api/user/reword/store` | Convert points → wallet balance (used by current Flutter) |
| GET    | `/api/front/settings?name=generalsettings` | Returns `is_reward`, `reward_point`, `reward_dolar` |
| —      | `UserResource.reword`    | User's current point balance |

Earning already happens on order placement in `Api/Front/CheckoutController` (line 226-241): closest `Reward.order_amount` row matched, `user.reward` incremented.

### 1.2 New endpoints

#### `GET /api/front/reward/ladder` — public

Returns `Reward` table for "spend X get Y points" UI.

Response:
```json
{
  "status": true,
  "data": [
    {"order_amount": 1000, "reward": 50},
    {"order_amount": 2000, "reward": 120}
  ],
  "error": []
}
```

#### `GET /api/user/reward/transactions?page=N` — auth (`auth:api`)

Paginated combined history (earnings + conversions). 12 per page.

Query params:
- `page` (optional, default 1)

Response:
```json
{
  "status": true,
  "data": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 12,
    "total": 36,
    "items": [
      {
        "id": 12,
        "type": "reward_earn",
        "reward_point": 50,
        "reward_dolar": 0,
        "order_number": "ORD-123",
        "details": "Reward earned for order #ORD-123",
        "created_at": "2026-05-02T10:00:00.000000Z"
      },
      {
        "id": 11,
        "type": "reward",
        "reward_point": 100,
        "reward_dolar": 2,
        "order_number": null,
        "details": "Reward Point Convert",
        "created_at": "2026-05-01T09:00:00.000000Z"
      }
    ]
  },
  "error": []
}
```

`type` values:
- `reward_earn` — points awarded on order
- `reward` — points converted to wallet balance

`order_number` — extracted from `details` (regex `#(\S+)`) for `reward_earn` rows; `null` otherwise.

### 1.3 Earning history mechanism

`Api/Front/CheckoutController` modified at line 226-241. On reward earn:

```php
$earnPoints = $final_reword->reward;
$user->update(['reward' => $user->reward + $earnPoints]);

\App\Models\Transaction::create([
    'user_id'      => $user->id,
    'txn_number'   => \Illuminate\Support\Str::random(3) . substr(time(), 6, 8) . \Illuminate\Support\Str::random(3),
    'reward_point' => $earnPoints,
    'reward_dolar' => 0,
    'type'         => 'reward_earn',
    'details'      => 'Reward earned for order #' . $order->order_number,
]);
```

Forward-only: existing orders won't appear. No backfill.

No DB schema change — `Transaction` table already has `reward_point`, `reward_dolar`, `type`, `details`.

### 1.4 File changes

| File | Action |
|------|--------|
| `app/Http/Controllers/Api/Front/CheckoutController.php` | Add `Transaction::create([...])` after line 238 |
| `app/Http/Controllers/Api/User/WithdrawController.php` | Add `rewardTransactions()` method |
| `app/Http/Controllers/Api/Front/RewardController.php` | NEW file — `ladder()` method |
| `routes/api.php` | Add 2 routes (see 1.5) |

### 1.5 Routes added

```php
// routes/api.php — inside existing front prefix group:
Route::get('/reward/ladder', 'Api\Front\RewardController@ladder');

// routes/api.php — inside existing user/auth:api group:
Route::get('/reward/transactions', 'Api\User\WithdrawController@rewardTransactions');
```

Old `/reword/get` and `/reword/store` routes kept untouched.

### 1.6 Flutter migration notes (for app dev — no backend work here)

- Old `/reword/get` still works (returns conversions only). To show earnings, app must call new `/reward/transactions`.
- New `/reward/ladder` is optional — for "earn rate" widget.
- `user.reword` balance already updates after order — keep refetching dashboard.

---

## Part 2 — Preorder Support

### 2.1 What's missing on API

Web product schema column `preordered` (`1=Sale`, `2=Preordered`) NOT exposed via API. Flutter has no field to read.

### 2.2 Changes

#### `app/Http/Resources/ProductDetailsResource.php`

Add to `toArray()`:

```php
'preordered' => (int) $this->preordered,
```

#### `app/Http/Resources/ProductlistResource.php`

Add to `toArray()`:

```php
'preordered' => (int) $this->preordered,
```

### 2.3 Behavior contract for Flutter

- `preordered == 2` AND `stock <= 0` → product is preorderable. App shows "Make a Pre Order" CTA, allows add-to-cart.
- `preordered == 1` (or `0`) AND `stock <= 0` → out of stock. Block add-to-cart.
- `stock > 0` → normal sale regardless of `preordered`.

### 2.4 Checkout

API checkout (`Api/Front/CheckoutController`) does NOT hard-block on `stock <= 0` (only `OrderHelper::stock_check` decrements stock). So preorder placement works without checkout modification.

Stock will go negative for preorder — matches current website behavior.

### 2.5 Out of scope

- Order-level preorder flag (admin can't distinguish preorder vs normal). Add later if needed.
- Legacy `pre_order` column on products (separate field, unused in product UI flow).

---

## Part 3 — Testing Checklist

Manual smoke tests after deploy:

- [ ] `GET /api/front/reward/ladder` → 200, returns Reward table rows
- [ ] `POST` order via API checkout (auth) → DB has new `transactions` row with `type='reward_earn'`, correct `reward_point`, `details` containing order_number
- [ ] `GET /api/user/reward/transactions?page=1` → 200, paginated, includes both `reward_earn` and `reward` rows
- [ ] `GET /api/user/reword/get` → unchanged (conversions only) — Flutter regression check
- [ ] `POST /api/user/reword/store` → unchanged — Flutter regression check
- [ ] `GET /api/front/product/{id}/details` → response includes `"preordered": <int>`
- [ ] Product list endpoints → response items include `preordered`
- [ ] Place order on preorder product (stock=0, preordered=2) via API → succeeds, stock goes negative

---

## Part 4 — Web side untouched (verification)

NOT modified:
- `app/Http/Controllers/Payment/Checkout/*` (web payment gateways)
- `app/Http/Controllers/User/RewardController.php` (web reward UI)
- `app/Http/Controllers/Admin/RewardController.php`
- `app/Http/Controllers/Front/*` (web frontend)
- `routes/web.php`, `routes/customer.php`, `routes/admin.php`
- `resources/views/**`
- Models (`Reward`, `Transaction`, `Product`, `Order`)
- DB schema

Web reward earning still bumps `user.reward` without txn row (existing behavior preserved). Web reward UI still shows convert-only history.

---

## Part 5 — Backward compatibility

- All new endpoints are additive
- Old reward routes keep current behavior
- New `Transaction.type='reward_earn'` rows ignored by old `getReword()` filter (`type='reward'`)
- Flutter app keeps working without code change (just won't see earnings until app updates to new endpoint)
