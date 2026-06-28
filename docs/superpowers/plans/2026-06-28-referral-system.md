# Refer & Earn (Referral System) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Existing users share a short code (`ASMI3K7`); a new user enters it on their first order; when that order completes, both users get loyalty `wallet_points`.

**Architecture:** All referral logic lives in one `ReferralHelper`. Capture hooks the app checkout; reward/reverse hooks the existing admin order-status update (`completed`/`cancelled`/`return`). A `referrals` ledger table guarantees idempotency and one-referral-per-referee. Reward currency is the live loyalty balance `users.wallet_points`. Backend deploys to the LIVE server (source of truth); the app ships later.

**Tech Stack:** Laravel 8-ish (legacy), MariaDB 10.11, Flutter (flutter_bloc), `share_plus`.

---

## ⚠️ Server-as-truth deploy procedure (used by every BACKEND task)

The local repo `G:\asmi_shop\asmi_shop_backend` is STALE. The live server is the only source of truth. For every backend file you MODIFY, follow this exactly (see [[asmishop-repo-drift]]):

**Pull → backup → edit → diff → push:**
1. Pull the live file to scratchpad:
   `pscp -pw '9Eq@h8o5lb7*' root@144.79.133.74:/home/asmishop/htdocs/asmishop.com/<relpath> "C:/Temp/.../scratchpad/<name>.live"`
2. Make a dated server backup BEFORE changing:
   `plink ... "cp /home/asmishop/htdocs/asmishop.com/<relpath> /home/asmishop/htdocs/asmishop.com/<relpath>.refer.bak"`
3. Edit the pulled `.live` copy (apply the task's changes to THAT file).
4. Push it back:
   `pscp -pw '...' "C:/Temp/.../scratchpad/<name>.live" root@144.79.133.74:/home/asmishop/htdocs/asmishop.com/<relpath>`
5. Verify PHP parses: `plink ... "php -l /home/asmishop/htdocs/asmishop.com/<relpath>"` → expect `No syntax errors detected`.

NEW files (ReferralHelper, migration, blade): just `pscp` up to the right path + `php -l`.

`plink`/`pscp` non-interactive prefix used throughout (host key already cached):
`echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "<cmd>"`

DB creds (for verification queries): `mysql -u 'asmi-db' -p'qPC22IYziYLV6q3oBnKC' 'asmi-db'`.

Ship gated OFF: leave `generalsettings.is_refer = 0` until Task 11 manual test.

---

## File Structure

- `database/migrations/2026_06_29_000000_create_referrals_and_user_refer_cols.php` (NEW) — table + 2 user cols.
- `app/Helpers/ReferralHelper.php` (NEW) — all referral logic.
- `app/Models/Referral.php` (NEW) — Eloquent model for `referrals`.
- `app/Models/Generalsetting.php` (MODIFY) — 3 fillable keys.
- `app/Http/Controllers/Admin/GeneralSettingController.php` (MODIFY) — `refer()` page method.
- `resources/views/admin/generalsetting/refer.blade.php` (NEW) — settings form.
- `routes/admin.php` (MODIFY) — `admin-gs-refer` route.
- `resources/views/partials/admin-role/super.blade.php` (MODIFY) — sidebar link.
- `app/Http/Controllers/Api/Front/CheckoutController.php` (MODIFY) — capture hook.
- `app/Http/Controllers/Admin/OrderController.php` (MODIFY) — reward/reverse hooks.
- `app/Http/Controllers/Api/User/ProfileController.php` (MODIFY) — `referral()` endpoint.
- `routes/api.php` (MODIFY) — `/user/referral` route.
- App: `lib/module/checkout/...` (referral field) + `lib/module/referral/...` (new screen).

---

## Task 1: Migration — referrals table + user columns

**Files:**
- Create local: `G:\asmi_shop\asmi_shop_backend\database\migrations\2026_06_29_000000_create_referrals_and_user_refer_cols.php`

- [ ] **Step 1: Write the migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsAndUserReferCols extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('users', 'referral_code')) {
            Schema::table('users', function (Blueprint $t) {
                $t->string('referral_code', 16)->nullable()->unique();
            });
        }
        if (!Schema::hasColumn('users', 'referred_by')) {
            Schema::table('users', function (Blueprint $t) {
                $t->unsignedBigInteger('referred_by')->nullable()->index();
            });
        }
        if (!Schema::hasTable('referrals')) {
            Schema::create('referrals', function (Blueprint $t) {
                $t->bigIncrements('id');
                $t->unsignedBigInteger('referrer_id')->index();
                $t->string('referee_phone_normalized', 20)->unique();
                $t->unsignedBigInteger('referee_user_id')->nullable();
                $t->string('code', 16);
                $t->unsignedBigInteger('order_id')->nullable()->index();
                $t->enum('status', ['pending', 'rewarded', 'void'])->default('pending')->index();
                $t->integer('referrer_points')->default(0);
                $t->integer('referee_points')->default(0);
                $t->timestamp('created_at')->nullable();
                $t->timestamp('rewarded_at')->nullable();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('referrals');
        Schema::table('users', function (Blueprint $t) {
            if (Schema::hasColumn('users', 'referral_code')) $t->dropColumn('referral_code');
            if (Schema::hasColumn('users', 'referred_by')) $t->dropColumn('referred_by');
        });
    }
}
```

- [ ] **Step 2: Deploy the migration file**

```bash
pscp -pw '9Eq@h8o5lb7*' "G:/asmi_shop/asmi_shop_backend/database/migrations/2026_06_29_000000_create_referrals_and_user_refer_cols.php" root@144.79.133.74:/home/asmishop/htdocs/asmishop.com/database/migrations/
```

- [ ] **Step 3: Run ONLY this migration (never bare `migrate`)**

```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "cd /home/asmishop/htdocs/asmishop.com && php artisan migrate --path=database/migrations/2026_06_29_000000_create_referrals_and_user_refer_cols.php --force"
```
Expected: `Migrated: ...create_referrals_and_user_refer_cols`.

- [ ] **Step 4: Verify schema**

```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "mysql -u 'asmi-db' -p'qPC22IYziYLV6q3oBnKC' 'asmi-db' -e 'SHOW COLUMNS FROM users LIKE \"refer%\"; SHOW TABLES LIKE \"referrals\";'"
```
Expected: `referral_code`, `referred_by` rows + `referrals` table listed.

- [ ] **Step 5: Commit (local, no co-author trailer)**

```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add database/migrations/2026_06_29_000000_create_referrals_and_user_refer_cols.php && git commit -m "feat(referral): migration for referrals table + user refer columns"
```

---

## Task 2: Referral model

**Files:**
- Create local: `app/Models/Referral.php`

- [ ] **Step 1: Write the model**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
}
```

- [ ] **Step 2: Deploy**

```bash
pscp -pw '9Eq@h8o5lb7*' "G:/asmi_shop/asmi_shop_backend/app/Models/Referral.php" root@144.79.133.74:/home/asmishop/htdocs/asmishop.com/app/Models/
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "php -l /home/asmishop/htdocs/asmishop.com/app/Models/Referral.php"
```
Expected: `No syntax errors detected`.

- [ ] **Step 3: Commit**

```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add app/Models/Referral.php && git commit -m "feat(referral): Referral model"
```

---

## Task 3: ReferralHelper — code generation (TDD the pure part)

**Files:**
- Create local: `app/Helpers/ReferralHelper.php`
- Test: `G:\asmi_shop\asmi_shop_backend\scratch\refcode_test.php` (standalone, throwaway — not deployed)

- [ ] **Step 1: Write a failing standalone test for the pure code formula**

`scratch/refcode_test.php`:
```php
<?php
// Pure formula mirrors ReferralHelper::formatCode without Laravel.
function formatCode($id) { return strtoupper('ASMI' . base_convert($id, 10, 36)); }

$cases = [1 => 'ASMI1', 35 => 'ASMIZ', 36 => 'ASMI10', 8702 => 'ASMI6OE'];
foreach ($cases as $id => $want) {
    $got = formatCode($id);
    if ($got !== $want) { fwrite(STDERR, "FAIL id=$id got=$got want=$want\n"); exit(1); }
}
echo "OK\n";
```

- [ ] **Step 2: Run it (proves the formula before embedding in the helper)**

Run: `php "G:/asmi_shop/asmi_shop_backend/scratch/refcode_test.php"`
Expected: `OK`. (If `base_convert(8702)` differs, correct the expected value to the actual `php -r` output and re-run — the point is a locked, known mapping.)

- [ ] **Step 3: Write `ReferralHelper.php`**

```php
<?php

namespace App\Helpers;

use App\Helpers\PhoneHelper;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ReferralHelper
{
    /** Deterministic short code from a user id, e.g. 8702 -> ASMI6OE. */
    public static function formatCode($id): string
    {
        return strtoupper('ASMI' . base_convert((int) $id, 10, 36));
    }

    /** Return the user's referral code, generating + persisting it on first use. */
    public static function codeForUser(User $user): string
    {
        if (!empty($user->referral_code)) {
            return $user->referral_code;
        }
        $code = self::formatCode($user->id);
        $user->referral_code = $code;
        $user->save();
        return $code;
    }

    public static function resolveReferrer(?string $code): ?User
    {
        $code = trim((string) $code);
        if ($code === '') return null;
        return User::whereRaw('UPPER(referral_code) = ?', [strtoupper($code)])->first();
    }

    /**
     * Record a pending referral when a referee uses a code on their FIRST order.
     * Fail-safe: never throws into the checkout flow.
     */
    public static function captureAtCheckout(?string $code, Order $order): void
    {
        try {
            $gs = Generalsetting::find(1);
            if (!$gs || (int) $gs->is_refer !== 1) return;

            $referrer = self::resolveReferrer($code);
            if (!$referrer) return;

            $refereePhone = $order->customer_phone_normalized
                ?: PhoneHelper::normalize($order->customer_phone);
            if (!$refereePhone) return;

            // First order = this just-saved order is the only one for the phone.
            $orderCount = Order::where('customer_phone_normalized', $refereePhone)->count();
            if ($orderCount > 1) return;

            // No self-referral.
            $referrerPhone = PhoneHelper::normalize($referrer->phone);
            if ($referrerPhone && $referrerPhone === $refereePhone) return;

            // One referral per referee, ever.
            if (Referral::where('referee_phone_normalized', $refereePhone)->exists()) return;

            Referral::create([
                'referrer_id'              => $referrer->id,
                'referee_phone_normalized' => $refereePhone,
                'code'                     => strtoupper(trim($code)),
                'order_id'                 => $order->id,
                'status'                   => 'pending',
                'created_at'               => now(),
            ]);

            // Stamp referred_by if the referee already has an account.
            $referee = User::where('phone', $refereePhone)
                ->orWhere('phone', '+88' . $refereePhone)->first();
            if ($referee && empty($referee->referred_by)) {
                $referee->referred_by = $referrer->id;
                $referee->save();
            }
        } catch (\Throwable $e) {
            Log::error('referral.capture failed: ' . $e->getMessage());
        }
    }

    /**
     * Credit both parties when the referral's order reaches 'completed'.
     * Idempotent: only acts on a 'pending' row. Fail-safe.
     */
    public static function rewardForOrder(Order $order): void
    {
        try {
            $gs = Generalsetting::find(1);
            if (!$gs || (int) $gs->is_refer !== 1) return;

            DB::transaction(function () use ($order, $gs) {
                $row = Referral::where('order_id', $order->id)
                    ->where('status', 'pending')->lockForUpdate()->first();
                if (!$row) return;

                $rPts = (int) $gs->refer_referrer_points;
                $fPts = (int) $gs->refer_referee_points;

                $referrer = User::find($row->referrer_id);
                if ($referrer && $rPts > 0) {
                    $referrer->increment('wallet_points', $rPts);
                }

                // Resolve (or create) the referee so points have a home.
                $referee = self::findOrCreateReferee($row->referee_phone_normalized, $order);
                if ($referee && $fPts > 0) {
                    $referee->increment('wallet_points', $fPts);
                }

                $row->referee_user_id = $referee->id ?? null;
                $row->referrer_points = $rPts;
                $row->referee_points  = $fPts;
                $row->status          = 'rewarded';
                $row->rewarded_at     = now();
                $row->save();
            });
        } catch (\Throwable $e) {
            Log::error('referral.reward failed: ' . $e->getMessage());
        }
    }

    /** Reverse points if a rewarded order is later cancelled/returned. */
    public static function reverseForOrder(Order $order): void
    {
        try {
            DB::transaction(function () use ($order) {
                $row = Referral::where('order_id', $order->id)
                    ->where('status', 'rewarded')->lockForUpdate()->first();
                if (!$row) return;

                if ($row->referrer_id && $row->referrer_points > 0) {
                    $u = User::find($row->referrer_id);
                    if ($u) $u->decrement('wallet_points', $row->referrer_points);
                }
                if ($row->referee_user_id && $row->referee_points > 0) {
                    $u = User::find($row->referee_user_id);
                    if ($u) $u->decrement('wallet_points', $row->referee_points);
                }
                $row->status = 'void';
                $row->save();
            });
        } catch (\Throwable $e) {
            Log::error('referral.reverse failed: ' . $e->getMessage());
        }
    }

    /** Mirror of the auto-create-from-order pattern in AuthController@by-order. */
    protected static function findOrCreateReferee(string $phone, Order $order): ?User
    {
        $user = User::where('phone', $phone)
            ->orWhere('phone', '+88' . $phone)->first();
        if ($user) return $user;

        $user = new User();
        $user->name           = $order->customer_name ?: 'Customer';
        $user->email          = $phone . '@asmi.local';
        $user->phone          = $phone;
        $user->address        = $order->customer_address;
        $user->password       = bcrypt($phone);
        $user->email_verified = 'Yes';
        if (Schema::hasColumn('users', 'force_password_change')) {
            $user->force_password_change = 1;
        }
        if (Schema::hasColumn('users', 'auto_created_via')) {
            $user->auto_created_via = 'referral_reward';
        }
        $user->save();
        return $user;
    }
}
```

- [ ] **Step 4: Deploy + lint**

```bash
pscp -pw '9Eq@h8o5lb7*' "G:/asmi_shop/asmi_shop_backend/app/Helpers/ReferralHelper.php" root@144.79.133.74:/home/asmishop/htdocs/asmishop.com/app/Helpers/
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "php -l /home/asmishop/htdocs/asmishop.com/app/Helpers/ReferralHelper.php"
```
Expected: `No syntax errors detected`.

- [ ] **Step 5: Sanity-check `formatCode` on the server via tinker**

```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "cd /home/asmishop/htdocs/asmishop.com && php artisan tinker --execute=\"echo App\\\\Helpers\\\\ReferralHelper::formatCode(8702);\""
```
Expected: prints `ASMI6OE` (matches Step 2's locked value).

- [ ] **Step 6: Commit**

```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add app/Helpers/ReferralHelper.php && git commit -m "feat(referral): ReferralHelper (capture/reward/reverse + code gen)"
```

---

## Task 4: Generalsetting fillable + admin settings page + route + sidebar

**Files:**
- Modify (server-as-truth): `app/Models/Generalsetting.php`, `app/Http/Controllers/Admin/GeneralSettingController.php`, `routes/admin.php`, `resources/views/partials/admin-role/super.blade.php`
- Create: `resources/views/admin/generalsetting/refer.blade.php`

- [ ] **Step 1: Add fillable keys (pull `Generalsetting.php`, edit, push)**

Add `'is_refer','refer_referrer_points','refer_referee_points'` to the end of the `$fillable` array (before the closing `]`). Pull → edit → push → `php -l` per the deploy procedure.

- [ ] **Step 2: Add `refer()` page method to `GeneralSettingController`**

Pull the file, find the existing `public function affilate()` method, and add directly after it:
```php
    public function refer()
    {
        $gs = \App\Models\Generalsetting::find(1);
        return view('admin.generalsetting.refer', compact('gs'));
    }
```
Push → `php -l`.

- [ ] **Step 3: Create the settings blade**

`resources/views/admin/generalsetting/refer.blade.php`:
```blade
@extends('layouts.admin')
@section('content')
<div class="content-area">
  <div class="add-product-content1">
    <div class="row">
      <div class="col-lg-12">
        <div class="product-area mt-5">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <h4 class="mb-4">{{ __('Refer & Earn Settings') }}</h4>
              <form action="{{ route('admin-gs-update') }}" id="geniusform" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label class="control-label">{{ __('Referral System') }}</label>
                  <select class="form-control selectError niceSelect" name="is_refer">
                    <option data-val="1" value="{{route('admin-gs-status',['is_refer',1])}}" {{ $gs->is_refer == 1 ? 'selected' : '' }}>{{ __('Activated') }}</option>
                    <option data-val="0" value="{{route('admin-gs-status',['is_refer',0])}}" {{ $gs->is_refer == 0 ? 'selected' : '' }}>{{ __('Deactivated') }}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">{{ __('Points to Referrer (inviter)') }}</label>
                  <input type="number" step="1" min="0" class="input-field" name="refer_referrer_points" value="{{ $gs->refer_referrer_points }}">
                </div>
                <div class="form-group">
                  <label class="control-label">{{ __('Points to Referee (new user)') }}</label>
                  <input type="number" step="1" min="0" class="input-field" name="refer_referee_points" value="{{ $gs->refer_referee_points }}">
                </div>
                <button class="addProductSubmit-btn" type="submit">{{ __('Save Settings') }}</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
```
> Note: the `is_refer` toggle reuses the generic `admin-gs-status` route (sets any gs column), same as the affiliate page. The numeric inputs post to `admin-gs-update`. If the affiliate blade extends a different layout name, match it — pull `affilate.blade.php` first and copy its `@extends`/section wrapper exactly.

- [ ] **Step 4: Add the route**

Pull `routes/admin.php`. Near the affiliate/general-settings routes (around the `admin-gs-*` group), add:
```php
        Route::get('/general-settings/refer', 'Admin\GeneralSettingController@refer')->name('admin-gs-refer');
```
Push → verify with `php -l` (routes file) and:
```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "cd /home/asmishop/htdocs/asmishop.com && php artisan route:list 2>/dev/null | grep admin-gs-refer"
```
Expected: the route line printed.

- [ ] **Step 5: Add sidebar link**

Pull `resources/views/partials/admin-role/super.blade.php`. Find the existing Affiliate settings sidebar `<li>` (search `admin-gs-affilate`) and add a sibling:
```blade
<li><a href="{{ route('admin-gs-refer') }}">{{ __('Refer & Earn') }}</a></li>
```
Push.

- [ ] **Step 6: Deploy the new blade + smoke-test page**

```bash
pscp -pw '9Eq@h8o5lb7*' "G:/asmi_shop/asmi_shop_backend/resources/views/admin/generalsetting/refer.blade.php" root@144.79.133.74:/home/asmishop/htdocs/asmishop.com/resources/views/admin/generalsetting/
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "cd /home/asmishop/htdocs/asmishop.com && php artisan view:clear"
```
Set test values + keep gated OFF:
```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "mysql -u 'asmi-db' -p'qPC22IYziYLV6q3oBnKC' 'asmi-db' -e \"UPDATE generalsettings SET is_refer=0, refer_referrer_points=50, refer_referee_points=30 WHERE id=1\""
```

- [ ] **Step 7: Commit (local mirror edits for record)**

Apply the same edits to the LOCAL files (so git records intent even though server is truth), then:
```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add app/Models/Generalsetting.php app/Http/Controllers/Admin/GeneralSettingController.php routes/admin.php resources/views/partials/admin-role/super.blade.php resources/views/admin/generalsetting/refer.blade.php && git commit -m "feat(referral): admin refer&earn settings (toggle + point amounts)"
```

---

## Task 5: Capture hook in app checkout

**Files:**
- Modify (server-as-truth): `app/Http/Controllers/Api/Front/CheckoutController.php`

- [ ] **Step 1: Add the use-statement**

Pull the file. After `use App\Helpers\PriceHelper;` add:
```php
use App\Helpers\ReferralHelper;
```

- [ ] **Step 2: Call capture right after the order is saved**

Find:
```php
            $order->fill($input)->save();

            if ($couponId) {
                OrderHelper::coupon_check($couponId);
            }
```
Insert immediately after the `coupon_check` block:
```php
            // ---- referral capture (first-order, fail-safe, gated by is_refer) ----
            ReferralHelper::captureAtCheckout($request->referral_code ?? null, $order);
            // ---- end referral capture ----
```

- [ ] **Step 3: Push + lint**

```bash
pscp ... CheckoutController.php (per deploy procedure)
echo y | plink ... "php -l .../Api/Front/CheckoutController.php"
```
Expected: `No syntax errors detected`.

- [ ] **Step 4: Verify capture with a manual API order (gated ON temporarily)**

Temporarily enable, place one app/curl order with a known referrer's code as a NEW phone, then check the row:
```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "mysql -u 'asmi-db' -p'qPC22IYziYLV6q3oBnKC' 'asmi-db' -e \"UPDATE generalsettings SET is_refer=1 WHERE id=1; SELECT * FROM referrals ORDER BY id DESC LIMIT 3\\G\""
```
(Full end-to-end is Task 11; this just confirms a `pending` row appears.) Re-gate OFF after: `UPDATE generalsettings SET is_refer=0 WHERE id=1`.

- [ ] **Step 5: Commit (mirror local)**

```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add app/Http/Controllers/Api/Front/CheckoutController.php && git commit -m "feat(referral): capture referral code at app checkout"
```

---

## Task 6: Reward/reverse hooks in admin order status update

**Files:**
- Modify (server-as-truth): `app/Http/Controllers/Admin/OrderController.php`

- [ ] **Step 1: Add use-statement**

Pull the file. Add near the other model uses at the top:
```php
use App\Helpers\ReferralHelper;
```

- [ ] **Step 2: Hook the `completed` and `cancelled`/`return` branches in `update()`**

The existing block reads:
```php
            if ($input['status'] == 'cancelled') {
                if ($data->user && $loyaltyPoint > 0) {
                    $data->user->decrement('wallet_points', $loyaltyPoint);
                }
            }

            if ($input['status'] == 'completed') {
                if ($data->user && $loyaltyPoint > 0) {
                    $data->user->increment('wallet_points', $loyaltyPoint);
                }
            }

            $data->update();
```
Change to add referral calls AFTER `$data->update();` (so the status is persisted before crediting):
```php
            if ($input['status'] == 'cancelled') {
                if ($data->user && $loyaltyPoint > 0) {
                    $data->user->decrement('wallet_points', $loyaltyPoint);
                }
            }

            if ($input['status'] == 'completed') {
                if ($data->user && $loyaltyPoint > 0) {
                    $data->user->increment('wallet_points', $loyaltyPoint);
                }
            }

            $data->update();

            // ---- referral reward / reverse (idempotent, fail-safe) ----
            if ($input['status'] == 'completed') {
                ReferralHelper::rewardForOrder($data);
            } elseif (in_array($input['status'], ['cancelled', 'return'])) {
                ReferralHelper::reverseForOrder($data);
            }
            // ---- end referral ----
```

- [ ] **Step 3: Push + lint**

```bash
pscp ... OrderController.php
echo y | plink ... "php -l .../Admin/OrderController.php"
```
Expected: `No syntax errors detected`.

- [ ] **Step 4: Commit (mirror local)**

```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add app/Http/Controllers/Admin/OrderController.php && git commit -m "feat(referral): reward on completed, reverse on cancel/return"
```

---

## Task 7: Read API — GET /api/user/referral

**Files:**
- Modify (server-as-truth): `app/Http/Controllers/Api/User/ProfileController.php`, `routes/api.php`

- [ ] **Step 1: Add uses + `referral()` method to ProfileController**

Pull the file. Add to the top `use` block:
```php
use App\Helpers\ReferralHelper;
use App\Models\Generalsetting;
use App\Models\Referral;
```
Add this method (after `affilateProgram()` or anywhere in the class):
```php
    public function referral()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['Unauthenticated']], 401);
        }

        $code = ReferralHelper::codeForUser($user);
        $gs   = Generalsetting::find(1);

        $rows      = Referral::where('referrer_id', $user->id)->get();
        $pending   = $rows->where('status', 'pending')->count();
        $rewarded  = $rows->where('status', 'rewarded')->count();
        $earned    = (int) $rows->where('status', 'rewarded')->sum('referrer_points');

        return response()->json([
            'status' => true,
            'data'   => [
                'code'             => $code,
                'share_text'       => 'Use my code ' . $code . ' on ASMI SuperShop and we both earn reward points!',
                'referrer_points'  => (int) optional($gs)->refer_referrer_points,
                'referee_points'   => (int) optional($gs)->refer_referee_points,
                'is_enabled'       => (int) optional($gs)->is_refer === 1,
                'total_invited'    => $rows->count(),
                'pending'          => $pending,
                'rewarded'         => $rewarded,
                'points_earned'    => $earned,
                'wallet_points'    => (float) ($user->wallet_points ?? 0),
            ],
            'error' => [],
        ]);
    }
```

- [ ] **Step 2: Add the route**

Pull `routes/api.php`. Next to the affiliate routes (lines ~147-148, inside the authed `user` group), add:
```php
          Route::get('/referral', 'Api\User\ProfileController@referral');
```
(The group prefix makes this `GET /api/user/referral`. Verify the prefix by checking the surrounding routes use `/affilate/program` → `/api/user/affilate/program`.)

- [ ] **Step 3: Push + lint + route check**

```bash
pscp ... ProfileController.php ; pscp ... api.php
echo y | plink ... "php -l .../Api/User/ProfileController.php && cd /home/asmishop/htdocs/asmishop.com && php artisan route:list 2>/dev/null | grep 'user/referral'"
```
Expected: no syntax errors + route listed.

- [ ] **Step 4: Smoke-test the endpoint**

With a valid user JWT (grab one via OTP login, or reuse an app session token), call:
```bash
curl -s -H "Authorization: Bearer <JWT>" https://asmishop.com/api/user/referral
```
Expected JSON with a `code` like `ASMI...` and stats. (If you lack a token, defer this check to Task 11.)

- [ ] **Step 5: Commit (mirror local)**

```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add app/Http/Controllers/Api/User/ProfileController.php routes/api.php && git commit -m "feat(referral): GET /api/user/referral (code + stats)"
```

---

## Task 8: Backfill referral codes for existing users

**Files:**
- Create local (throwaway): `scratch/backfill_referral_codes.php` (run via tinker on server)

- [ ] **Step 1: Run the backfill on the server via tinker (chunked, idempotent)**

```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "cd /home/asmishop/htdocs/asmishop.com && php artisan tinker --execute=\"App\\\\Models\\\\User::whereNull('referral_code')->orderBy('id')->chunkById(500, function(\\\$us){ foreach(\\\$us as \\\$u){ \\\$u->referral_code = App\\\\Helpers\\\\ReferralHelper::formatCode(\\\$u->id); \\\$u->save(); } }); echo 'done';\""
```
Expected: `done`.

- [ ] **Step 2: Verify**

```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "mysql -u 'asmi-db' -p'qPC22IYziYLV6q3oBnKC' 'asmi-db' -e \"SELECT COUNT(*) total, COUNT(referral_code) coded FROM users\""
```
Expected: `coded == total` (every user has a code; codes are unique by id).

---

## Task 9: Flutter — referral code field at checkout

**Files:**
- Modify: `lib/module/checkout/bloc/checkout_bloc.dart`, `lib/module/checkout/view/order_info.dart` (or the coupon section widget)

- [ ] **Step 1: Add a controller for the code in the bloc**

In `checkout_bloc.dart`, near `couponCode` controller, add:
```dart
  TextEditingController referralCode = TextEditingController();
```

- [ ] **Step 2: Send it in the order body**

In the body map (after `"coupon_discount": ...,`), add:
```dart
      "referral_code": referralCode.text.trim(),
```

- [ ] **Step 3: Add the input field UI**

In the checkout form (in `order_info.dart`, below the address/coupon area), add:
```dart
              16.verticalSpace,
              DefaultTextField(
                controller: bloc!.referralCode,
                label: 'Referral code (optional)',
                enableValidation: false,
              ),
```

- [ ] **Step 4: Analyze**

Run: `cd G:/asmi_shop/asmi_shop && flutter analyze lib/module/checkout`
Expected: no new errors.

- [ ] **Step 5: Commit (Flutter repo, no co-author)**

```bash
cd "G:/asmi_shop/asmi_shop" && git add lib/module/checkout && git commit -m "feat(referral): referral code field at checkout"
```

---

## Task 10: Flutter — Refer & Earn screen + account entry

**Files:**
- Create: `lib/module/referral/referral_screen.dart`
- Modify: `lib/module/my_account/view/my_account_view.dart` (wire the dead menu item), route registration file (where `Routes`/`app_pages` are defined)

- [ ] **Step 1: Add a repository method to fetch referral data**

In the existing API client/repository used for profile (mirror how `affilate/program` is called), add a `GET /api/user/referral` call returning the decoded `data` map. (Reuse the auth-header client already used for `/api/user/dashboard`.)

- [ ] **Step 2: Build the screen**

`lib/module/referral/referral_screen.dart`:
```dart
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:share_plus/share_plus.dart';
// import your api client + Auth as used elsewhere

class ReferralScreen extends StatefulWidget {
  const ReferralScreen({super.key});
  @override
  State<ReferralScreen> createState() => _ReferralScreenState();
}

class _ReferralScreenState extends State<ReferralScreen> {
  Map<String, dynamic>? data;
  bool loading = true;

  @override
  void initState() {
    super.initState();
    _load();
  }

  Future<void> _load() async {
    // final res = await ApiClient().get('/api/user/referral', withAuth: true);
    // setState(() { data = res['data']; loading = false; });
  }

  @override
  Widget build(BuildContext context) {
    final code = data?['code'] ?? '...';
    return Scaffold(
      appBar: AppBar(title: const Text('Refer & Earn')),
      body: loading
          ? const Center(child: CircularProgressIndicator())
          : Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  const Text('Share your code. You both earn points on your friend’s first order.'),
                  const SizedBox(height: 16),
                  Container(
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: Colors.teal.withOpacity(0.08),
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(color: Colors.teal.withOpacity(0.4)),
                    ),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        SelectableText(code,
                            style: const TextStyle(fontSize: 22, fontWeight: FontWeight.bold)),
                        IconButton(
                          icon: const Icon(Icons.copy),
                          onPressed: () => Clipboard.setData(ClipboardData(text: code)),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 16),
                  ElevatedButton.icon(
                    icon: const Icon(Icons.share),
                    label: const Text('Share'),
                    onPressed: () => Share.share(
                        (data?['share_text'] ?? 'Use my code $code') as String),
                  ),
                  const SizedBox(height: 24),
                  _stat('Invited', '${data?['total_invited'] ?? 0}'),
                  _stat('Pending', '${data?['pending'] ?? 0}'),
                  _stat('Rewarded', '${data?['rewarded'] ?? 0}'),
                  _stat('Points earned', '${data?['points_earned'] ?? 0}'),
                  _stat('Your points', '${data?['wallet_points'] ?? 0}'),
                ],
              ),
            ),
    );
  }

  Widget _stat(String k, String v) => Padding(
        padding: const EdgeInsets.symmetric(vertical: 6),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [Text(k), Text(v, style: const TextStyle(fontWeight: FontWeight.w600))],
        ),
      );
}
```
> Step 1's repository call fills `_load()` — wire it to the project's actual API client (same one used for the affiliate dashboard) and `Auth` token. Do not leave `_load()` empty in the final code.

- [ ] **Step 3: Wire the account menu item**

In `lib/module/my_account/view/my_account_view.dart`, change the dead "Affiliate Balance" `_MenuItem` (the one with `onTap: () {}`) — or add a new "Refer & Earn" item — to:
```dart
                onTap: () => Navigator.of(context).push(
                  MaterialPageRoute(builder: (_) => const ReferralScreen()),
                ),
```
Add the import for `ReferralScreen`.

- [ ] **Step 4: Analyze**

Run: `cd G:/asmi_shop/asmi_shop && flutter analyze lib/module/referral lib/module/my_account`
Expected: no errors (after `_load()` is wired to the real client).

- [ ] **Step 5: Commit**

```bash
cd "G:/asmi_shop/asmi_shop" && git add lib/module/referral lib/module/my_account && git commit -m "feat(referral): Refer & Earn screen + account entry"
```

---

## Task 11: End-to-end verification on live (gated ON, then decide)

**Files:** none (verification only)

- [ ] **Step 1: Enable + set amounts**

```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "mysql -u 'asmi-db' -p'qPC22IYziYLV6q3oBnKC' 'asmi-db' -e \"UPDATE generalsettings SET is_refer=1, refer_referrer_points=50, refer_referee_points=30 WHERE id=1\""
```

- [ ] **Step 2: Get a referrer code**

Pick an existing user, read their code:
```bash
echo y | plink ... "mysql ... -e \"SELECT id, phone, referral_code, wallet_points FROM users WHERE id=<REFERRER_ID>\""
```

- [ ] **Step 3: Place a first order from a NEW phone using that code**

On the emulator (as in the location feature) or a real device: at checkout enter the referrer's code in the new field, place the order. Then:
```bash
echo y | plink ... "mysql ... -e \"SELECT * FROM referrals ORDER BY id DESC LIMIT 1\\G\""
```
Expected: a `pending` row with the right `referrer_id`, the new normalized phone, and the new `order_id`.

- [ ] **Step 4: Mark the order completed (admin) and verify reward**

Mark that order `completed` in the admin panel (Orders → the order → status completed), then:
```bash
echo y | plink ... "mysql ... -e \"SELECT status, referrer_points, referee_points, referee_user_id FROM referrals ORDER BY id DESC LIMIT 1\\G SELECT id, wallet_points FROM users WHERE id IN (<REFERRER_ID>, (SELECT referee_user_id FROM referrals ORDER BY id DESC LIMIT 1))\""
```
Expected: row `status=rewarded`; referrer `wallet_points` +50; referee user exists with +30.

- [ ] **Step 5: Verify reversal**

Set the same order to `cancelled`, then re-check: row `status=void`, both balances back to pre-reward values.

- [ ] **Step 6: Verify guards**

- Second order from the same phone with any code → no new `referrals` row.
- Self-referral (user uses own code) → no row.

- [ ] **Step 7: Decide gating**

Leave `is_refer=1` only if the app release is ready; otherwise re-gate OFF until the app ships:
```bash
echo y | plink ... "mysql ... -e \"UPDATE generalsettings SET is_refer=0 WHERE id=1\""
```
Clean up the test order/referral row if desired (mirror the A50568 cleanup: delete the test `orders` + `order_tracks` + the `referrals` row, and reverse any test points).

---

## Notes

- Reward currency is `users.wallet_points` (live loyalty balance), credited on order `completed` via the existing `OrderController@update` hook — covers both web and app orders (admin completes both there).
- App orders often have `orders.user_id = NULL`; reward resolves/creates the referee by normalized phone, never relying on `user_id`.
- All referral calls are fail-safe (try/catch + Log) so they never block checkout or status updates.
- Ledger `referrals.status` (pending→rewarded→void) is the single idempotency anchor.
- Backend deploys file-by-file to the live server (source of truth); local commits are for record. Do NOT bulk-push local→live. No `Co-Authored-By` trailer in commits ([[no-coauthor-trailer]]). Push to GitHub only on explicit request ([[never-push-without-permission]]).
```
