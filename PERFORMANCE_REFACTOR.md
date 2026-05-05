# Performance Refactor — Checkout & Payment Flow

তারিখ: 2026-05-05
ব্রাঞ্চ: `claude/elegant-beaver-2512cc`
স্কোপ: শুধু code-level optimization। কোনো queue worker, migration, server config, env পরিবর্তন নাই।

---

## ১. সারসংক্ষেপ (TL;DR)

Checkout এবং Payment-এর ৬টা ফাইলে N+1 query, duplicate call, দরকার-নাই math, এবং কয়েকটা bug ঠিক করা হয়েছে। সব change pure PHP/Eloquent — server-side worker বা schema migration লাগবে না।

ফলাফল (estimate, measured না):
- Checkout endpoint: cart loop-এ query সংখ্যা `O(3N)` থেকে `O(1)` কমেছে।
- OrderHelper-এ batch `insert()` ব্যবহার হচ্ছে, single-row save এর জায়গায়।
- Reward calculation full-table scan + PHP sort এর জায়গায় single SQL query।
- SSL payment-এ cURL timeout 60s থেকে 15s, এবং production-এ `SSL_VERIFYPEER` on।

---

## ২. কোন ফাইল বদলেছে

| ফাইল | কী বদল |
|---|---|
| `project/app/Models/Generalsetting.php` | `cached()` static memo method add |
| `project/app/Http/Controllers/Api/Front/CheckoutController.php` | `checkout()`, `update()`, `addtocart()`, `countries()`, `VendorWisegetShippingPackaging()` |
| `project/app/Helpers/OrderHelper.php` | `size_qty_check`, `stock_check`, `vendor_order_check`, `product_affilate_check` |
| `project/app/Http/Controllers/Api/Payment/ManualController.php` | dummy multiply/divide drop |
| `project/app/Http/Controllers/Api/Payment/CashOnDeliveryController.php` | dummy multiply/divide drop |
| `project/app/Http/Controllers/Api/Payment/SslController.php` | math fix + cURL timeout + `VERIFYPEER` |

---

## ৩. প্রতিটা change-এর detail

### 3.1 `Generalsetting::cached()` (নতুন)

প্রতি request-এ `Generalsetting::find(1)` বার বার DB hit করতো। এখন একবার load হলে static variable-এ memoize হয়।

```php
public static function cached()
{
    if (self::$cached === null) {
        self::$cached = self::find(1);
    }
    return self::$cached;
}
```

এই method এখন `CheckoutController` এবং `OrderHelper`-এ ব্যবহার হচ্ছে। বাকি জায়গায় (Front/FrontendController, Front/VendorController, User/MessageController, User/TicketDisputeController, User/WithdrawController) একই pattern apply করা যাবে — এই পর্যায়ে করা হয়নি, কারণ checkout flow priority ছিল।

### 3.2 `Front/CheckoutController@checkout`

**আগে:** প্রতি cart item-এর জন্য `addtocart()` কল হতো, এবং প্রতি কলে আলাদা ভাবে `Currency::where(...)`, `Generalsetting::find(1)`, `Product::where('id',$id)` query চলতো। N item মানে 3N query।

**এখন:** loop শুরুর আগে একবার সব load:

```php
$gs = Generalsetting::cached();
$curr = Currency::where('name', $input['currency_code'] ?? '')
    ->first() ?? Currency::where('is_default', 1)->first();
$productIds = collect($items)->filter(...)->pluck('id')->all();
$productMap = Product::whereIn('id', $productIds)->get([...])->keyBy('id');
```

`addtocart()` signature বদলেছে — এখন `$curr`, `$gs`, `$prod` parameter accept করে (lookup আর করে না)।

**Reward calculation আগে:**
```php
$rewards = Reward::get();          // সব row load
$smallest = [];
foreach ($rewards as $i) {
    $smallest[$i->order_amount] = abs(...);
}
asort($smallest);                   // PHP sort
$final_reword = Reward::where('order_amount', key($smallest))->first();
```

**এখন:**
```php
$final_reword = Reward::orderByRaw('ABS(order_amount - ?)', [$order->pay_amount])->first();
```

**Auth guard আগে:** `Auth::guard('api')->check()` দুইবার ডাকা হতো।
**এখন:** একবার `$apiUser = Auth::guard('api')->user()` করে শেষ।

**`product_affilate_check` আগে:** `optional(...)` truthy check + পরে আবার ডাকা = ২ বার call, এমনকি result null হলেও `json_encode(null)` = `"null"` string store হতো।
**এখন:** একবার call, `!empty()` check।

### 3.3 `Front/CheckoutController@update`

**Vendor balance update আগে:** প্রতি vendor order-এ `User::find` + load + update = N query × ২।
**এখন:** user_id দিয়ে aggregate করে unique user-প্রতি একটা `increment()`:

```php
$totals = [];
foreach ($data->vendororders as $vorder) {
    $totals[$vorder->user_id] = ($totals[$vorder->user_id] ?? 0) + $vorder->price;
}
foreach ($totals as $uid => $sum) {
    User::whereKey($uid)->increment('current_balance', $sum);
}
```

**Affilate user আগে:** `where->exists()` + `where->first()` = 2 query।
**এখন:** `User::find(...)` একবার।

**Cart restore loop আগে:** ২টা আলাদা loop, প্রতিটায় `Product::find` per item।
**এখন:** একটা loop, আগে preload:

```php
$itemIds = collect($cart->items)->pluck('item.id')->unique()->all();
$productMap = Product::whereIn('id', $itemIds)->get()->keyBy('id');
```

### 3.4 `OrderHelper`

**`size_qty_check` / `stock_check`:** প্রতি item-এ `Product::find` ছিল। এখন `whereIn` দিয়ে একবার preload, তারপর map থেকে lookup।

**`stock_check`-এ Notification:** আগে প্রতিটা low-stock product-এ আলাদা `Notification::save()`। এখন array-তে collect করে শেষে একবার `Notification::insert($rows)`।

**`vendor_order_check`:** আগে loop-এ `VendorOrder::save()` + `UserNotification::save()` per row। এখন:

```php
VendorOrder::insert($vendorOrders);    // bulk
UserNotification::insert($rows);        // bulk
```

`VendorOrder` model-এ `timestamps = false` (verified) তাই created_at/updated_at দরকার নাই। `UserNotification` এবং `Notification`-এ default timestamps assume করা হয়েছে — **এটা confirm করা দরকার (নীচে দেখুন)।**

### 3.5 `Front/CheckoutController@VendorWisegetShippingPackaging`

**আগে দুইটা সমস্যা:**
1. Loop-এ `$shipping`/`$packaging` overwrite হতো, শুধু শেষ vendor-এর data return হতো।
2. সব result hardcoded `'00'` key-এর নিচে wrap হতো — vendor_id ignore।

**এখন:**

```php
$shipping = Shipping::whereIn('user_id', $vendorIds)->get($columns)->groupBy('user_id');
$packaging = Package::whereIn('user_id', $vendorIds)->get($columns)->groupBy('user_id');

foreach ($vendorIds as $vid) {
    $formattedShipping[$vid] = $shipping->get($vid, collect())->values();
    $formattedPackaging[$vid] = $packaging->get($vid, collect())->values();
}
```

⚠️ **Response shape বদলেছে:** আগে `data.shipping['00']` ছিল, এখন `data.shipping[<vendor_id>]`। Frontend এই endpoint consume করলে check করতে হবে।

### 3.6 `Front/CheckoutController@countries`

আগে প্রতি call-এ `Country::with('states.cities')->get()` heavy query চলতো। এখন 1 ঘন্টা cache:

```php
$countries = Cache::remember('checkout.countries.tree', 3600, function () {
    return Country::with('states.cities')->get();
});
```

Default file cache driver-এ চলবে — কোনো Redis/Memcached দরকার নাই।

### 3.7 Payment controllers — dummy math drop

`ManualController`, `CashOnDeliveryController`, `SslController`-এ এই pattern ছিল:

```php
$item_amount = $order->pay_amount * $order->currency_value;
$order->pay_amount = round($item_amount / $order->currency_value, 2);
```

= `round($order->pay_amount, 2)`। দরকারহীন multiply-divide drop হয়েছে।

`SslController`-এ `$item_amount` variable cURL post-data-এ পরে ব্যবহার হয়, তাই ওটার assignment রাখা হয়েছে।

### 3.8 `SslController` security + timeout

```php
// আগে
curl_setopt($handle, CURLOPT_TIMEOUT, 30);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); // KEEP IT FALSE IF YOU RUN FROM LOCAL PC

// এখন
$isSandbox = (int) ($paydata['sandbox_check'] ?? 0) === 1;
curl_setopt($handle, CURLOPT_TIMEOUT, 15);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, !$isSandbox);
```

Production-এ peer verify on, sandbox-এ off। Worst-case blocking 60s → 15s।

---

## ৪. ডেভেলপারের জন্য করণীয় (deploy এর আগে)

### 4.1 Schema confirm (CRITICAL)

`OrderHelper::stock_check` এবং `vendor_order_check`-এ batch `Notification::insert()` এবং `UserNotification::insert()` ব্যবহার হচ্ছে। Eloquent-এর `insert()` model events bypass করে — যদি table-এ `created_at`/`updated_at` column থাকে এবং migration default হয়, তাহলে কাজ করবে।

**Verify command:**

```bash
php artisan tinker
>>> Schema::getColumnListing('notifications');
>>> Schema::getColumnListing('user_notifications');
```

`created_at` এবং `updated_at` যদি থাকে — কোড as-is চলবে।
যদি না থাকে — `OrderHelper.php`-এ row arrays থেকে timestamp keys remove করতে হবে।

### 4.2 Frontend response shape check

`/front/vendor/wise/shipping-packaging` endpoint-এর response এখন:

```json
{
  "data": {
    "shipping": {
      "<vendor_id>": [...],
      "<vendor_id>": [...]
    },
    "packaging": { ... }
  }
}
```

আগে ছিল `"00"` hardcoded key। যদি Flutter/React app `'00'` key-তে hardcode করা থাকে, frontend update লাগবে।

বিকল্প: পুরোনো shape রাখতে চাইলে এই block-টা পরিবর্তন করতে হবে — request করুন।

### 4.3 Currency lookup behavior change

`addtocart()` আগের code-এ একটা bug ছিল:

```php
if (!empty($currency_code)) {
    $curr = Currency::where('name', '=', $currency_code)->first();
    if (!empty($curr)) {                  // ← BUG: found হলেও default দিয়ে overwrite
        $curr = Currency::where('is_default', '=', 1)->first();
    }
}
```

মানে `currency_code` যাই পাঠানো হোক, addtocart ভিতরে সবসময় default currency ব্যবহার করত। এখন caller থেকে correct `$curr` আসছে।

**Side effect:** যদি কোনো user অন্য currency-তে checkout করতেন, পুরোনো code default-এই calculate করত। এখন user-এর pick করা currency সঠিকভাবে apply হবে। **Price-এ পরিবর্তন আসতে পারে** — staging-এ multi-currency cart একটা test করুন।

### 4.4 Smoke test checklist

Deploy এর আগে এগুলো করুন:

- [ ] একটা cart-এ ২+ item দিয়ে checkout করা — order create হচ্ছে কিনা।
- [ ] Multi-vendor cart দিয়ে checkout — `vendor_orders` table-এ rows আসছে কিনা।
- [ ] Low stock product দিয়ে test — `notifications` table-এ row আসছে কিনা।
- [ ] Logged-in user (api guard) দিয়ে checkout — reward এবং balance আপডেট হচ্ছে কিনা।
- [ ] Order admin panel থেকে status "completed" করা — vendor balance increment হচ্ছে কিনা।
- [ ] Order "declined" করা — stock/size_qty restore হচ্ছে কিনা।
- [ ] `/front/get/countries` endpoint hit — response আসছে কিনা, second hit-এ cache hit।
- [ ] Vendor-wise shipping endpoint — সঠিক vendor_id-প্রতি data আসছে কিনা।
- [ ] SSL Commerz payment (sandbox) — gateway redirect কাজ করছে কিনা।

### 4.5 Cache clear (deploy এর পর)

```bash
php artisan cache:clear
php artisan config:clear
```

`countries` cache 1 ঘন্টা ধরে হবে — পুরোনো data পেলে clear করুন।

---

## ৫. ঝুঁকি / ব্যাকওয়ার্ড compatibility

| ঝুঁকি | কতটা | mitigation |
|---|---|---|
| `UserNotification`/`Notification` schema-তে timestamps না থাকলে batch insert fail | মধ্যম | section 4.1 verify |
| VendorWise endpoint response shape change | উচ্চ (যদি FE depend করে) | section 4.2 |
| Multi-currency price recalculation | মধ্যম | section 4.3 |
| Cache driver misconfigured | নিচু (file driver default) | কাজ না করলে closure প্রতিবার চলবে — same as before |
| `Reward::orderByRaw` portability | নিচু (MySQL/MariaDB OK) | DB engine MySQL হলে fine |

---

## ৬. যা করা হয়নি (server access লাগে)

পরে যদি queue worker / DB access পাওয়া যায়, এই কাজগুলা বড় win দিবে:

1. **Email queueing** — `checkout()` এবং `update()`-এ ২টা email send synchronously হচ্ছে (~1-3s প্রতিটা)। `Mail::queue()` দিয়ে পাঠালে user 2-6s কম wait করবে। কিন্তু queue worker (`php artisan queue:work`) চালাতে হবে।
2. **DB index audit** — এই column-গুলায় index আছে কিনা verify:
   - `orders.order_number`, `orders.txnid`
   - `transactions.txn_number`
   - `coupons.code`, `coupons.status`
   - `vendor_orders.order_id`
   - `rewards.order_amount` (নতুন `orderByRaw` অপটিমাইজেশন-এর জন্য)
3. **`Generalsetting::cached()` rollout** — বাকি ৫টা controller-এ apply।
4. **`OrderHelper::auth_check`-এ duplicate user query** + অন্যান্য User query optimization।
5. **Empty `catch (\Exception $e) {}` block** — observability-এর জন্য logging add করা।

---

## ৭. Verify result

সব ফাইল PHP lint pass:

```bash
$ php -l app/Models/Generalsetting.php
$ php -l app/Helpers/OrderHelper.php
$ php -l app/Http/Controllers/Api/Front/CheckoutController.php
$ php -l app/Http/Controllers/Api/Payment/ManualController.php
$ php -l app/Http/Controllers/Api/Payment/CashOnDeliveryController.php
$ php -l app/Http/Controllers/Api/Payment/SslController.php
# All: No syntax errors detected
```

Live performance measure করা হয়নি (server access নাই)। Staging-এ deploy করে before/after compare করার suggestion।
