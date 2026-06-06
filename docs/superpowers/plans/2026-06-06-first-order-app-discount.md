# First-Order App Discount — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: superpowers:executing-plans (inline) — implemented in one context because backend, Flutter, and admin share one contract (column names + JSON keys) that must stay identical across all three.

**Goal:** Auto-apply a one-time 5% discount on a phone number's first order placed via the mobile app, decided server-side, shown in the app and admin.

**Architecture:** Eligibility keyed on a normalized `customer_phone` (guests included, no login). Server computes/persists the discount at checkout; an endpoint reports eligibility for the app's pre-pay display; admin shows a per-order line + an order-list badge/filter; a `generalsettings` percent column is the on/off master switch (0 = off).

**Tech Stack:** Laravel (root `project/`), MySQL, Yajra DataTables, Blade; Flutter (`asmi_shop/lib`), flutter_bloc.

**Repos:** `asmi_shop_backend` (`G:\asmi_shop\asmi_shop_backend`, Laravel under `project/`), `asmi_shop` (`G:\asmi_shop\asmi_shop`).

**Branch:** `feat/first-order-app-discount` (do not commit to `main`).

---

## Contract (shared across all layers — keep identical)

- DB columns: `orders.first_order_discount` DECIMAL(10,2) default 0; `orders.customer_phone_normalized` VARCHAR(20) indexed; `generalsettings.first_order_discount_percent` DECIMAL(5,2) default 0.
- Eligibility: `percent>0 AND normPhone!=null AND NOT EXISTS(order with order_source='Mobile Apps' AND status!='cancelled' AND customer_phone_normalized=normPhone)`.
- Discount base: `total_amount_of_product` (product subtotal pre-coupon). `amount = round(subtotal*percent/100, 2)`.
- Endpoint: `GET /api/front/first-order-eligibility?phone=...` → `{status, data:{eligible:bool, percent:number}, error:[]}`.
- Normalizer: digits-only → drop leading `880` → if 10 digits starting `1` prefix `0` → else return digits; empty → null.

---

## File structure

**Backend (create):**
- `project/app/Helpers/PhoneHelper.php` — phone canonicalizer.
- `project/database/migrations/2026_06_06_000000_add_first_order_discount_to_orders.php`
- `project/database/migrations/2026_06_06_000001_add_first_order_discount_percent_to_generalsettings.php`
- `project/app/Console/Commands/BackfillCustomerPhoneNormalized.php` — chunked backfill.
- `project/tests/Feature/FirstOrderDiscountTest.php`

**Backend (modify):**
- `project/app/Http/Controllers/Api/Front/CheckoutController.php` — `checkout()` hook + `firstOrderEligibility()`.
- `project/routes/api.php` — eligibility route.
- `project/app/Http/Resources/OrderDetailsResource.php` — expose `first_order_discount`.
- `project/app/Models/Generalsetting.php` — `$fillable`.
- `project/app/Http/Controllers/Admin/OrderController.php` — list badge + filter.
- `project/resources/views/admin/order/index.blade.php` — filter control + ajax param.
- `project/resources/views/admin/order/details.blade.php` (+ `invoice.blade.php`, `print.blade.php`) — per-order line.
- general-settings form blade (located at impl) — percent input.

**Flutter (modify):**
- `lib/utils/url.dart`, `lib/repositories/checkout_repository.dart`
- `lib/module/checkout/bloc/checkout_state.dart`, `checkout_event.dart`, `checkout_bloc.dart`
- `lib/module/checkout/view/payment_details.dart`

---

## Task 1: Phone normalizer (`PhoneHelper`)

**Create** `project/app/Helpers/PhoneHelper.php`:

```php
<?php

namespace App\Helpers;

class PhoneHelper
{
    /**
     * Canonicalize a BD phone to 01XXXXXXXXX. Returns null if empty.
     * digits-only -> drop 880 country code -> ensure leading 0.
     */
    public static function normalize($raw): ?string
    {
        $d = preg_replace('/\D+/', '', (string) $raw);
        if ($d === '') return null;
        if (strpos($d, '880') === 0) $d = substr($d, 3);
        if (strlen($d) === 10 && $d[0] === '1') $d = '0' . $d;
        return $d !== '' ? $d : null;
    }
}
```

Verify: `php -r "require 'project/vendor/autoload.php'; ..."` not needed — covered by Task 8 test `test_normalizer_variants`.

---

## Task 2: Migrations

**Create** `project/database/migrations/2026_06_06_000000_add_first_order_discount_to_orders.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'first_order_discount')) {
                $table->decimal('first_order_discount', 10, 2)->default(0)->after('coupon_discount');
            }
            if (!Schema::hasColumn('orders', 'customer_phone_normalized')) {
                $table->string('customer_phone_normalized', 20)->nullable()->index()->after('customer_phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'first_order_discount')) $table->dropColumn('first_order_discount');
            if (Schema::hasColumn('orders', 'customer_phone_normalized')) {
                $table->dropIndex(['customer_phone_normalized']);
                $table->dropColumn('customer_phone_normalized');
            }
        });
    }
};
```

> If `orders` has no `coupon_discount`/`customer_phone` column to anchor `after()`, drop the `->after(...)`. Confirm with `Schema::hasColumn` already guards creation.

**Create** `project/database/migrations/2026_06_06_000001_add_first_order_discount_percent_to_generalsettings.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            if (!Schema::hasColumn('generalsettings', 'first_order_discount_percent')) {
                $table->decimal('first_order_discount_percent', 5, 2)->default(0); // 0 = feature OFF
            }
        });
    }

    public function down(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            if (Schema::hasColumn('generalsettings', 'first_order_discount_percent')) {
                $table->dropColumn('first_order_discount_percent');
            }
        });
    }
};
```

Verify: `php artisan migrate` (locally / staging). ADD COLUMN is instant on MySQL 8.

---

## Task 3: Chunked backfill command

**Create** `project/app/Console/Commands/BackfillCustomerPhoneNormalized.php`:

```php
<?php

namespace App\Console\Commands;

use App\Helpers\PhoneHelper;
use App\Models\Order;
use Illuminate\Console\Command;

class BackfillCustomerPhoneNormalized extends Command
{
    protected $signature = 'orders:backfill-normalized-phone {--chunk=1000}';
    protected $description = 'Backfill orders.customer_phone_normalized from customer_phone (chunked, idempotent).';

    public function handle(): int
    {
        $chunk = (int) $this->option('chunk');
        $count = 0;

        Order::select('id', 'customer_phone')->orderBy('id')->chunkById($chunk, function ($orders) use (&$count) {
            foreach ($orders as $order) {
                $norm = PhoneHelper::normalize($order->customer_phone);
                // write directly; no model events / timestamps churn
                Order::where('id', $order->id)->update(['customer_phone_normalized' => $norm]);
                $count++;
            }
            $this->info("Processed {$count}...");
        });

        $this->info("Done. Backfilled {$count} orders.");
        return self::SUCCESS;
    }
}
```

Verify: `php artisan orders:backfill-normalized-phone` — re-runnable (idempotent).

---

## Task 4: Generalsetting fillable + admin field

**Modify** `project/app/Models/Generalsetting.php` — append `'first_order_discount_percent'` to `$fillable`.

**Modify** the general-settings form blade that posts to `generalupdate` (locate via `route admin-general-update` / `generalupdate`). Add inside the form:

```blade
<div class="form-group row">
    <label class="col-md-4 col-form-label">{{ __('First Order Discount (%) — App') }}</label>
    <div class="col-md-8">
        <input type="number" step="0.01" min="0" max="100" class="form-control"
               name="first_order_discount_percent"
               value="{{ $general->first_order_discount_percent ?? 0 }}">
        <small class="text-muted">{{ __('0 = off. Set to 5 to give 5% on the first app order per phone.') }}</small>
    </div>
</div>
```

> Match the blade's existing variable name for the settings model (commonly `$general` or `$gs`). `generalupdate()` saves `$request->all()` into fillable, so no controller change needed.

Verify: load the settings page, change value, save, confirm `generalsettings.first_order_discount_percent` updates.

---

## Task 5: Checkout hook (`checkout()`)

**Modify** `project/app/Http/Controllers/Api/Front/CheckoutController.php`. Insert AFTER the `getOrderTotal` success guard (after line ~155) and BEFORE `$order = new Order();` (line 157):

```php
            // ---- First-order app discount (server-authoritative) ----
            // Keyed on normalized customer phone (guests included). The
            // generalsettings percent is the master switch (0 = off).
            $firstOrderDiscount = 0;
            $normPhone = \App\Helpers\PhoneHelper::normalize($input['customer_phone'] ?? null);
            $foPercent = (float) optional(Generalsetting::find(1))->first_order_discount_percent;
            if ($foPercent > 0 && $normPhone) {
                $foUsed = Order::where('order_source', 'Mobile Apps')
                    ->where('status', '!=', 'cancelled')
                    ->where('customer_phone_normalized', $normPhone)
                    ->exists();
                if (!$foUsed) {
                    $foSubtotal = (float) ($orderCalculate['total_amount_of_product'] ?? 0);
                    $firstOrderDiscount = round($foSubtotal * $foPercent / 100, 2);
                    $orderCalculate['total_amount'] -= $firstOrderDiscount;
                }
            }
            $input['customer_phone_normalized'] = $normPhone;
            $input['first_order_discount'] = $firstOrderDiscount;
            // ---- end first-order app discount ----
```

`pay_amount` (line 167) reads the reduced `$orderCalculate['total_amount']`; `$order->fill($input)` (line 174) persists both new columns (`$guarded=['id']`). `Generalsetting` + `Order` already imported.

Verify: Task 8 tests.

---

## Task 6: Eligibility endpoint + route

**Modify** `CheckoutController.php` — add method (near `getCoupon`):

```php
    public function firstOrderEligibility(Request $request)
    {
        $percent = (float) optional(Generalsetting::find(1))->first_order_discount_percent;
        $normPhone = \App\Helpers\PhoneHelper::normalize($request->phone);
        $eligible = false;
        if ($percent > 0 && $normPhone) {
            $eligible = ! Order::where('order_source', 'Mobile Apps')
                ->where('status', '!=', 'cancelled')
                ->where('customer_phone_normalized', $normPhone)
                ->exists();
        }
        return response()->json([
            'status' => true,
            'data'   => ['eligible' => $eligible, 'percent' => $percent],
            'error'  => [],
        ]);
    }
```

**Modify** `project/routes/api.php` — in the `front` group (after line 240 `get/coupon-code`):

```php
    Route::get('/first-order-eligibility','Api\Front\CheckoutController@firstOrderEligibility');
```

Verify: `curl ".../api/front/first-order-eligibility?phone=01XXXXXXXXX"`.

---

## Task 7: Expose discount in OrderDetailsResource

**Modify** `project/app/Http/Resources/OrderDetailsResource.php` — add before `'created_at'`:

```php
        'first_order_discount' => round(($this->first_order_discount ?? 0) * $this->currency_value, 2),
```

---

## Task 8: Backend feature tests

**Create** `project/tests/Feature/FirstOrderDiscountTest.php` covering: normalizer variants; eligible first app order applies 5% + sets columns; second same-phone (with `+880` variant) no discount; website-only history then app order discounted; cancelled first order → re-eligible; percent=0 → off; garbage phone → no crash. (Use `RefreshDatabase`; seed a `generalsettings` row with the percent; hit the route / call `PhoneHelper`.)

Run: `php artisan test --filter=FirstOrderDiscountTest`. Expected: PASS.

> Note: full `checkout()` has many dependencies (Cart, Currency, products). Where a full HTTP checkout test is impractical in this repo's harness, at minimum unit-test `PhoneHelper::normalize` and the `firstOrderEligibility` endpoint (DB-only), and verify the discount math via a focused test that inserts a prior order and asserts the eligibility flips.

---

## Task 9: Admin per-order line

**Modify** `project/resources/views/admin/order/details.blade.php` — insert BEFORE the `Total Cost` row (line ~129):

```blade
                                    @if (($order->first_order_discount ?? 0) > 0)
                                        <tr>
                                            <th width="45%">{{ __('First Order Discount') }}</th>
                                            <td width="10%">:</td>
                                            <td width="45%">
                                                − {{ \PriceHelper::showOrderCurrencyPrice($order->first_order_discount * $order->currency_value, $order->currency_sign) }}
                                            </td>
                                        </tr>
                                    @endif
```

Repeat the analogous line in `invoice.blade.php` and `print.blade.php` near their totals (locate at impl).

---

## Task 10: Admin order-list badge + filter

**Modify** `project/app/Http/Controllers/Admin/OrderController.php`:

(a) In `datatables()`, after the date-range filter block (~line 100), add:

```php
        if ($request->get('first_order') == '1') {
            $query->where('first_order_discount', '>', 0);
        }
```

(b) Replace the `order_source` `editColumn` (lines 161-169) body to append a badge:

```php
            ->editColumn('order_source', function (Order $data) {
                $map = [
                    'Website'     => ['primary', 'Web'],
                    'Mobile Apps' => ['success', 'App'],
                    'POS'         => ['info',    'POS'],
                ];
                [$badge, $source] = $map[$data->order_source] ?? ['dark', 'Unknown'];
                $html = '<span class="badge badge-' . $badge . '">' . __($source) . '</span>';
                if (($data->first_order_discount ?? 0) > 0) {
                    $html .= ' <span class="badge badge-warning" title="First order discount">1st</span>';
                }
                return $html;
            })
```

**Modify** `project/resources/views/admin/order/index.blade.php`:

(c) Near the status filter (line ~168), add a control:

```blade
                                <div class="col-md-3">
                                    <label for="firstOrderFilter">{{ __('First Order') }}</label>
                                    <select name="first_order" id="firstOrderFilter" class="form-control">
                                        <option value="">{{ __('All') }}</option>
                                        <option value="1">{{ __('First-order only') }}</option>
                                    </select>
                                </div>
```

(d) In the DataTables `ajax.data` fn (line ~485), add:

```js
                        d.first_order = $('#firstOrderFilter').val();
```

(e) In the reset handler (line ~563), add: `$('#firstOrderFilter').val('');`

Verify: open the all-orders page, pick "First-order only", Filter → only rows with the `1st` badge.

---

## Task 11: Flutter URL + repository

**Modify** `lib/utils/url.dart` — add:

```dart
  static String firstOrderEligibility(String phone) =>
      '${baseUrl}api/front/first-order-eligibility?phone=${Uri.encodeQueryComponent(phone)}';
```

**Modify** `lib/repositories/checkout_repository.dart` — add method:

```dart
  Future checkFirstOrderEligibility({
    required String phone,
    required Function(bool eligible, double percent) onSuccess,
    required Function(Map<String, dynamic>) onError,
  }) async {
    await apiClient.Request(
      url: URL.firstOrderEligibility(phone),
      withAuth: false,
      enableShowError: false,
      onSuccess: (Map<String, dynamic> data) {
        final d = data['data'] is Map ? Map<String, dynamic>.from(data['data']) : {};
        final eligible = d['eligible'] == true;
        final percent = double.tryParse('${d['percent'] ?? 0}') ?? 0.0;
        onSuccess(eligible, percent);
      },
      onError: onError,
    );
  }
```

---

## Task 12: Flutter state + event

**Modify** `lib/module/checkout/bloc/checkout_state.dart` — add field, constructor param, clone param/assignment:

- Field: `bool firstOrderEligible = false;` and `double firstOrderPercent = 0;`
- Constructor: `this.firstOrderEligible = false, this.firstOrderPercent = 0,`
- clone signature: `bool? firstOrderEligible, double? firstOrderPercent,`
- clone return: `firstOrderEligible: firstOrderEligible ?? this.firstOrderEligible, firstOrderPercent: firstOrderPercent ?? this.firstOrderPercent,`

**Modify** `lib/module/checkout/bloc/checkout_event.dart` — add:

```dart
class CheckFirstOrderEligibilityEvent extends CheckoutEvent {
  final String phone;
  const CheckFirstOrderEligibilityEvent(this.phone) : super();
}
```

---

## Task 13: Flutter bloc wiring

**Modify** `lib/module/checkout/bloc/checkout_bloc.dart`:

(a) Field near other fields: `Timer? _eligibilityDebounce;`

(b) Register in constructor: `on<CheckFirstOrderEligibilityEvent>(_checkFirstOrderEligibility);`

(c) In `_init`, after prefill block, add listener + initial check:

```dart
    phone.addListener(_onPhoneChangedForEligibility);
    if (phone.text.trim().isNotEmpty) add(CheckFirstOrderEligibilityEvent(phone.text));
```

(d) In `close()`: `_eligibilityDebounce?.cancel(); phone.removeListener(_onPhoneChangedForEligibility);`

(e) Add methods:

```dart
  void _onPhoneChangedForEligibility() {
    _eligibilityDebounce?.cancel();
    _eligibilityDebounce = Timer(const Duration(milliseconds: 600), () {
      if (!isClosed) add(CheckFirstOrderEligibilityEvent(phone.text));
    });
  }

  FutureOr<void> _checkFirstOrderEligibility(
    CheckFirstOrderEligibilityEvent event,
    Emitter<CheckoutState> emit,
  ) async {
    final digits = event.phone.replaceAll(RegExp(r'\D'), '');
    if (digits.length < 10) {
      emit(state.clone(firstOrderEligible: false, firstOrderPercent: 0));
      return;
    }
    bool eligible = false;
    double percent = 0;
    await repository.checkFirstOrderEligibility(
      phone: event.phone,
      onSuccess: (e, p) { eligible = e; percent = p; },
      onError: (_) {},
    );
    emit(state.clone(firstOrderEligible: eligible, firstOrderPercent: percent));
  }

  double getFirstOrderDiscount() {
    if (!state.firstOrderEligible || state.firstOrderPercent <= 0) return 0.0;
    double subtotal = 0.0;
    final groups = cartBloc?.state.groupWiseProduct;
    if (groups != null) {
      for (int k = 0; k < groups.length; k++) {
        for (int l = 0; l < groups[k].length; l++) {
          subtotal += _asDouble(cartBloc!.getSubtotalPrice(k, l)[AppConstant.total]);
        }
      }
    }
    return subtotal * (state.firstOrderPercent / 100.0);
  }
```

(f) In `getFinalPrice()`, before `return total.toStringAsFixed(1);` (line ~361):

```dart
    if (state.firstOrderEligible && state.firstOrderPercent > 0) {
      total -= getFirstOrderDiscount();
      if (total < 0) total = 0;
    }
```

---

## Task 14: Flutter UI line

**Modify** `lib/module/checkout/view/payment_details.dart` — after the MRP row (line 116-117):

```dart
              if (state.firstOrderEligible && state.firstOrderPercent > 0) ...[
                singleRow(
                  'First order discount (${state.firstOrderPercent.toStringAsFixed(0)}%)',
                  '- ${bloc!.getFirstOrderDiscount().toStringAsFixed(1).price}',
                ),
                8.verticalSpace,
              ],
```

Verify: `flutter analyze` (no new errors). Manual: enter an eligible phone at checkout → discount line appears, Total drops.

---

## Task 15: Deploy / backfill runbook (LIVE 144.79.133.74) — zero-downtime

**Two ordering rules make this safe:**
- **Migrate BEFORE the new code is live.** The new `checkout()` writes `customer_phone_normalized` + `first_order_discount` on every order; if the controller goes live before the columns exist, checkout 500s with `Unknown column`. (OPcache is OFF, so uploaded code is live instantly — the gap is real.)
- **Percent stays 0 until backfill is verified**, so no discount can fire early.

MySQL 8 builds the secondary index **online** (`ALGORITHM=INPLACE, LOCK=NONE`) → reads/writes keep working during the migration → no maintenance window needed.

0. Backup `orders`: phpMyAdmin/CloudPanel → export.
1. **Migrate first (columns before code).** Put only the migrations on the server ahead of the controller change, then run migrate. On a single-server git deploy, do:
   ```
   git fetch origin
   git checkout <branch> -- project/database/migrations
   php artisan migrate          # 3 columns instant + phone index built online
   ```
   Verify: `SHOW COLUMNS FROM orders LIKE 'customer_phone_normalized';` (feature still OFF, percent 0).
2. **Deploy the rest of the code:** `git pull` (or full checkout). Columns already exist → checkout safe. No downtime.
3. **Backfill** (off-peak, chunked): `php artisan orders:backfill-normalized-phone`
4. Spot-check: `SELECT customer_phone, customer_phone_normalized FROM orders LIMIT 20;` — existing app customers' normalized phone populated.
5. **Turn ON:** General Settings → "First Order Discount (%)" = `5`, or `UPDATE generalsettings SET first_order_discount_percent=5 WHERE id=1;`
6. Smoke: `GET /api/front/first-order-eligibility?phone=<brand-new#>` → `eligible:true`; a known prior app phone → `eligible:false`.
7. Ship the Flutter build.
8. Rollback: set percent = 0 (instant off). Columns are additive + reversible (`down()` drops them).

**Fallback (if you can't split step 1/2):** a 5–10s maintenance window —
`php artisan down && git pull && php artisan migrate && php artisan up`. Downtime ≈ index build time, which scales with `orders` row count (seconds for typical volumes; check `SELECT COUNT(*) FROM orders;`).

---

## Self-review

- Spec coverage: eligibility (T5/T6), normalization (T1), backfill (T2/T3), config switch (T2/T4), checkout discount (T5), app display (T11-14), admin line (T9), admin badge+filter (T10), tests (T8), runbook (T15). ✓
- Contract consistency: column names, JSON keys (`eligible`/`percent`), discount base (`total_amount_of_product`) identical across backend/flutter. ✓
- Placeholders: blade variable name for settings model (`$general`/`$gs`) and invoice/print insertion points resolved at impl (flagged inline). ✓
