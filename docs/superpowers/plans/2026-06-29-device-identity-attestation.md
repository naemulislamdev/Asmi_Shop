# Device Identity & Attestation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** A genuine-device-attested `device_id` (App Check / Play Integrity) sent by the app, verified server-side, used to cap referrals per physical device (closing the SIM-swap farm hole) and shared with login/fraud.

**Architecture:** App generates a stable `device_id` (secure storage) + an App Check token (Play Integrity) and sends both on `device/register` and at checkout. Backend `AppCheckVerifier` validates the token against Google JWKS; `DeviceService` upserts a `devices` row + trust flag; `ReferralHelper` requires a trusted device + per-device cap. All gated OFF until the attested app build ships.

**Tech Stack:** Laravel + firebase/php-jwt (already vendored); Flutter + firebase_core + firebase_app_check + flutter_secure_storage + uuid.

**Firebase (already set up — see [[asmishop-firebase-appcheck]]):** project `asmi-shop` (#401152501376), Android app `1:401152501376:android:843815d407e387a1eaa865`, `google-services.json` in `android/app/`, Play Integrity provider + SHAs + a debug token registered.

---

## ⚠️ Backend deploy procedure (server-as-truth — every backend file)
Local `G:\asmi_shop\asmi_shop_backend` is STALE. For each MODIFIED backend file: `pscp` the LIVE copy down → edit that copy → back up on server (`cp X X.devid.bak`) → `pscp` up → `php -l`. NEW files: just `pscp` up + `php -l`. Migrations: `php artisan migrate --path=... --force` (never bare migrate). Non-interactive SSH prefix: `echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "<cmd>"`. DB: `mysql -u 'asmi-db' -p'qPC22IYziYLV6q3oBnKC' 'asmi-db'`. Commit local mirror (under `project/`) after each task, NO co-author trailer.

---

## File Structure
- Create: `app/Services/AppCheckVerifier.php` — verify App Check JWT vs Google JWKS.
- Create: `app/Services/DeviceService.php` — register/upsert device + trust.
- Create: `app/Models/Device.php`, `app/Models/DeviceUser.php`.
- Create: `app/Http/Controllers/Api/Front/DeviceController.php` — `POST /api/device/register`.
- Create migration: `devices`, `device_user`, `referrals.device_id`, `user_login_sessions.device_id`, gs `refer_max_per_device` + `refer_require_attested_device`.
- Modify: `app/Helpers/ReferralHelper.php` — device params + per-device cap + require-attested gate.
- Modify: `app/Http/Controllers/Api/Front/CheckoutController.php` — register device + pass to capture.
- Modify: `routes/api.php` — device route.
- Modify: `config/services.php` + server `.env` — App Check config.
- App: `pubspec.yaml`, `android/settings.gradle.kts`, `android/app/build.gradle.kts`, `lib/main.dart`, `lib/services/device_identity.dart`, `lib/module/checkout/bloc/checkout_bloc.dart`.

---

## Task 1: Migration — device tables + columns + settings

**Files:** Create local `project/database/migrations/2026_06_30_000000_create_devices_and_attestation.php`

- [ ] **Step 1: Write the migration**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesAndAttestation extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('devices')) {
            Schema::create('devices', function (Blueprint $t) {
                $t->bigIncrements('id');
                $t->string('device_id', 80)->unique();
                $t->string('platform', 16)->default('unknown');
                $t->tinyInteger('attested')->default(0);
                $t->integer('attest_fail_count')->default(0);
                $t->integer('referrals_count')->default(0);
                $t->string('notes', 191)->nullable();
                $t->timestamp('first_seen_at')->nullable();
                $t->timestamp('last_seen_at')->nullable();
                $t->timestamps();
            });
        }
        if (!Schema::hasTable('device_user')) {
            Schema::create('device_user', function (Blueprint $t) {
                $t->bigIncrements('id');
                $t->string('device_id', 80)->index();
                $t->unsignedBigInteger('user_id')->nullable()->index();
                $t->string('phone_normalized', 20)->nullable()->index();
                $t->timestamp('first_seen_at')->nullable();
                $t->unique(['device_id', 'phone_normalized']);
            });
        }
        if (!Schema::hasColumn('referrals', 'device_id')) {
            Schema::table('referrals', function (Blueprint $t) {
                $t->string('device_id', 80)->nullable()->index();
            });
        }
        if (!Schema::hasColumn('user_login_sessions', 'device_id')) {
            Schema::table('user_login_sessions', function (Blueprint $t) {
                $t->string('device_id', 80)->nullable()->index();
            });
        }
        Schema::table('generalsettings', function (Blueprint $t) {
            if (!Schema::hasColumn('generalsettings', 'refer_max_per_device')) {
                $t->integer('refer_max_per_device')->default(0); // 0 = unlimited
            }
            if (!Schema::hasColumn('generalsettings', 'refer_require_attested_device')) {
                $t->tinyInteger('refer_require_attested_device')->default(0); // gate OFF
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('device_user');
        Schema::dropIfExists('devices');
        Schema::table('referrals', function (Blueprint $t) {
            if (Schema::hasColumn('referrals', 'device_id')) $t->dropColumn('device_id');
        });
        Schema::table('user_login_sessions', function (Blueprint $t) {
            if (Schema::hasColumn('user_login_sessions', 'device_id')) $t->dropColumn('device_id');
        });
        Schema::table('generalsettings', function (Blueprint $t) {
            foreach (['refer_max_per_device', 'refer_require_attested_device'] as $c) {
                if (Schema::hasColumn('generalsettings', $c)) $t->dropColumn($c);
            }
        });
    }
}
```

- [ ] **Step 2: Deploy + run**
```bash
pscp -pw '9Eq@h8o5lb7*' "G:/asmi_shop/asmi_shop_backend/project/database/migrations/2026_06_30_000000_create_devices_and_attestation.php" root@144.79.133.74:/home/asmishop/htdocs/asmishop.com/database/migrations/
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "cd /home/asmishop/htdocs/asmishop.com && php artisan migrate --path=database/migrations/2026_06_30_000000_create_devices_and_attestation.php --force"
```
Expected: `Migrated: ...create_devices_and_attestation`.

- [ ] **Step 3: Verify + seed gs defaults**
```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "mysql -u 'asmi-db' -p'qPC22IYziYLV6q3oBnKC' 'asmi-db' -e \"SHOW TABLES LIKE 'devices'; SHOW TABLES LIKE 'device_user'; UPDATE generalsettings SET refer_max_per_device=1, refer_require_attested_device=0 WHERE id=1; SELECT refer_max_per_device, refer_require_attested_device FROM generalsettings WHERE id=1\""
```
Expected: both tables listed; `1` / `0`.

- [ ] **Step 4: Commit**
```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add project/database/migrations/2026_06_30_000000_create_devices_and_attestation.php && git commit -m "feat(device): migration for devices, device_user, referral+session device_id, gs gates"
```

---

## Task 2: Device + DeviceUser models

**Files:** Create local `project/app/Models/Device.php`, `project/app/Models/DeviceUser.php`

- [ ] **Step 1: Write models**
`Device.php`:
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Device extends Model
{
    protected $guarded = ['id'];
}
```
`DeviceUser.php`:
```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DeviceUser extends Model
{
    protected $table = 'device_user';
    public $timestamps = false;
    protected $guarded = ['id'];
}
```

- [ ] **Step 2: Deploy + lint**
```bash
pscp -pw '9Eq@h8o5lb7*' "G:/asmi_shop/asmi_shop_backend/project/app/Models/Device.php" root@144.79.133.74:/home/asmishop/htdocs/asmishop.com/app/Models/
pscp -pw '9Eq@h8o5lb7*' "G:/asmi_shop/asmi_shop_backend/project/app/Models/DeviceUser.php" root@144.79.133.74:/home/asmishop/htdocs/asmishop.com/app/Models/
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "php -l /home/asmishop/htdocs/asmishop.com/app/Models/Device.php; php -l /home/asmishop/htdocs/asmishop.com/app/Models/DeviceUser.php"
```
Expected: `No syntax errors detected` x2.

- [ ] **Step 3: Commit**
```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add project/app/Models/Device.php project/app/Models/DeviceUser.php && git commit -m "feat(device): Device + DeviceUser models"
```

---

## Task 3: AppCheckVerifier service (+ config + .env)

**Files:** Create local `project/app/Services/AppCheckVerifier.php`; modify `config/services.php` + server `.env`.

- [ ] **Step 1: Add `.env` values on the server**
```bash
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "cd /home/asmishop/htdocs/asmishop.com && cp .env .env.devid.bak && printf '\nAPPCHECK_PROJECT_NUMBER=401152501376\nAPPCHECK_APP_IDS=1:401152501376:android:843815d407e387a1eaa865\n' >> .env && grep APPCHECK .env"
```
Expected: the two APPCHECK lines echoed.

- [ ] **Step 2: Add config block to `config/services.php`** (pull → edit → push). Inside the returned array add:
```php
    'appcheck' => [
        'project_number' => env('APPCHECK_PROJECT_NUMBER'),
        'app_ids' => env('APPCHECK_APP_IDS'),
    ],
```

- [ ] **Step 3: Write `AppCheckVerifier.php`**
```php
<?php

namespace App\Services;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AppCheckVerifier
{
    /**
     * Verify a Firebase App Check token (RS256) against Google JWKS.
     * Returns ['app_id' => sub] when genuine, else null. Never throws.
     */
    public static function verify(?string $token): ?array
    {
        $token = trim((string) $token);
        if ($token === '') return null;

        try {
            $pnum = (string) config('services.appcheck.project_number');
            $appIds = array_filter(array_map('trim', explode(',', (string) config('services.appcheck.app_ids'))));
            if ($pnum === '') return null;

            $jwks = Cache::remember('appcheck_jwks', now()->addHours(6), function () {
                $raw = @file_get_contents('https://firebaseappcheck.googleapis.com/v1/jwks');
                return $raw ? json_decode($raw, true) : null;
            });
            if (!$jwks || empty($jwks['keys'])) {
                Cache::forget('appcheck_jwks');
                return null;
            }

            $keys = JWK::parseKeySet($jwks);          // RS256 keys by kid
            $decoded = JWT::decode($token, $keys);    // verifies signature + exp

            $iss = 'https://firebaseappcheck.googleapis.com/' . $pnum;
            if (($decoded->iss ?? '') !== $iss) return null;

            $aud = (array) ($decoded->aud ?? []);
            if (!in_array('projects/' . $pnum, $aud, true)) return null;

            $sub = (string) ($decoded->sub ?? '');
            if ($appIds && !in_array($sub, $appIds, true)) return null;

            return ['app_id' => $sub];
        } catch (\Throwable $e) {
            Log::info('appcheck.verify failed: ' . $e->getMessage());
            return null;
        }
    }
}
```

- [ ] **Step 4: Deploy + lint + config clear**
```bash
pscp -pw '9Eq@h8o5lb7*' "G:/asmi_shop/asmi_shop_backend/project/app/Services/AppCheckVerifier.php" root@144.79.133.74:/home/asmishop/htdocs/asmishop.com/app/Services/
echo y | plink -ssh root@144.79.133.74 -pw '9Eq@h8o5lb7*' -batch "php -l /home/asmishop/htdocs/asmishop.com/app/Services/AppCheckVerifier.php; cd /home/asmishop/htdocs/asmishop.com && php artisan config:clear >/dev/null 2>&1 && echo cfg-cleared"
```
Expected: no syntax errors + `cfg-cleared`.

- [ ] **Step 5: Commit**
```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add project/app/Services/AppCheckVerifier.php project/config/services.php && git commit -m "feat(device): AppCheckVerifier (verify App Check JWT vs Google JWKS)"
```

---

## Task 4: DeviceService + register endpoint

**Files:** Create local `project/app/Services/DeviceService.php`, `project/app/Http/Controllers/Api/Front/DeviceController.php`; modify `routes/api.php`.

- [ ] **Step 1: Write `DeviceService.php`**
```php
<?php

namespace App\Services;

use App\Models\Device;
use App\Models\DeviceUser;

class DeviceService
{
    /** Upsert a device row; mark attested when the App Check token verifies. */
    public static function register(?string $deviceId, ?string $token, ?string $platform = null, ?string $phoneNorm = null, ?int $userId = null): array
    {
        $deviceId = trim((string) $deviceId);
        if ($deviceId === '' || strlen($deviceId) > 80) {
            return ['device_id' => null, 'attested' => false];
        }

        $attested = AppCheckVerifier::verify($token) !== null;

        $device = Device::firstOrNew(['device_id' => $deviceId]);
        if (!$device->exists) $device->first_seen_at = now();
        $device->platform = $platform ?: ($device->platform ?: 'unknown');
        $device->last_seen_at = now();
        if ($attested) {
            $device->attested = 1;
        } elseif (!empty($token)) {
            $device->attest_fail_count = (int) $device->attest_fail_count + 1;
        }
        $device->save();

        if ($phoneNorm || $userId) {
            DeviceUser::firstOrCreate(
                ['device_id' => $deviceId, 'phone_normalized' => $phoneNorm ?: ''],
                ['user_id' => $userId, 'first_seen_at' => now()]
            );
        }

        return ['device_id' => $deviceId, 'attested' => $attested];
    }

    public static function isTrusted(?string $deviceId): bool
    {
        $deviceId = trim((string) $deviceId);
        if ($deviceId === '') return false;
        return Device::where('device_id', $deviceId)->where('attested', 1)->exists();
    }
}
```

- [ ] **Step 2: Write `DeviceController.php`**
```php
<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Services\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function register(Request $request)
    {
        $res = DeviceService::register(
            $request->device_id,
            $request->app_check_token,
            $request->platform
        );
        return response()->json(['status' => true, 'data' => $res, 'error' => []]);
    }
}
```

- [ ] **Step 3: Add the route** (pull `routes/api.php` → add near `login/otp/verify`, in the public/front group — NO auth):
```php
    Route::post('device/register', 'Api\Front\DeviceController@register');
```

- [ ] **Step 4: Deploy + lint + smoke**
```bash
pscp ... DeviceService.php ; pscp ... DeviceController.php ; pscp ... routes/api.php
echo y | plink ... "php -l .../Services/DeviceService.php; php -l .../Api/Front/DeviceController.php; php -l .../routes/api.php; cd /home/asmishop/htdocs/asmishop.com && php artisan route:clear >/dev/null 2>&1 && echo ok"
curl -s -X POST https://asmishop.com/api/device/register -H "Content-Type: application/json" -d '{"device_id":"smoke-test-1","platform":"android"}'
```
Expected: no syntax errors; smoke returns `{"status":true,"data":{"device_id":"smoke-test-1","attested":false},...}` (no token → attested false). Then clean the smoke row:
```bash
echo y | plink ... "mysql ... -e \"DELETE FROM devices WHERE device_id='smoke-test-1'\""
```

- [ ] **Step 5: Commit**
```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add project/app/Services/DeviceService.php project/app/Http/Controllers/Api/Front/DeviceController.php project/routes/api.php && git commit -m "feat(device): DeviceService + POST /api/device/register"
```

---

## Task 5: Wire device into referral capture (gated)

**Files:** Modify `app/Helpers/ReferralHelper.php`, `app/Http/Controllers/Api/Front/CheckoutController.php`, admin `refer.blade.php`, `Generalsetting.php` fillable.

- [ ] **Step 1: Extend `captureAtCheckout` signature + add device guards** (pull ReferralHelper). Change the method signature and add the device gate + per-device cap. Replace the signature line:
```php
    public static function captureAtCheckout(?string $code, Order $order): void
```
with:
```php
    public static function captureAtCheckout(?string $code, Order $order, ?string $deviceId = null, bool $deviceTrusted = false): void
```
Then, immediately AFTER the existing self-referral phone check (the line `if ($referrerPhone && $referrerPhone === $refereePhone) return;`), insert:
```php
            // Device attestation gate (optional, admin-controlled).
            if ((int) ($gs->refer_require_attested_device ?? 0) === 1) {
                if (!$deviceId || !$deviceTrusted) {
                    \Illuminate\Support\Facades\Log::info('referral.capture skipped: no attested device');
                    return;
                }
            }
            // Per-device referral cap (0 = unlimited).
            $devCap = (int) ($gs->refer_max_per_device ?? 0);
            if ($deviceId && $devCap > 0) {
                $devUsed = Referral::where('device_id', $deviceId)
                    ->whereIn('status', ['pending', 'rewarded'])->count();
                if ($devUsed >= $devCap) {
                    \Illuminate\Support\Facades\Log::info('referral.capture skipped: device cap');
                    return;
                }
            }
```
Then in the `Referral::create([...])` array add the device id:
```php
                'device_id'                => $deviceId,
```

- [ ] **Step 2: Pass device into capture from checkout** (pull CheckoutController). Add use:
```php
use App\Services\DeviceService;
```
Replace the existing capture call:
```php
            ReferralHelper::captureAtCheckout($request->referral_code ?? null, $order);
```
with:
```php
            $devReg = DeviceService::register(
                $request->device_id ?? null,
                $request->app_check_token ?? null,
                $request->device_platform ?? 'android',
                $order->customer_phone_normalized
            );
            ReferralHelper::captureAtCheckout(
                $request->referral_code ?? null,
                $order,
                $devReg['device_id'],
                (bool) $devReg['attested']
            );
```

- [ ] **Step 3: Add admin settings inputs + fillable.** Add `'refer_max_per_device', 'refer_require_attested_device'` to `Generalsetting` `$fillable`. In `refer.blade.php`, after the existing "Max uses per referral code" row, add:
```blade
                        <div class="row justify-content-center">
                          <div class="col-lg-3"><div class="left-area"><h4 class="heading">{{ __('Max referrals per device') }}</h4></div></div>
                          <div class="col-lg-6">
                            <input type="number" step="1" min="0" class="input-field" placeholder="{{ __('0 = unlimited') }}" name="refer_max_per_device" value="{{ $gs->refer_max_per_device }}">
                          </div>
                        </div>
                        <div class="row justify-content-center">
                          <div class="col-lg-3"><div class="left-area"><h4 class="heading">{{ __('Require attested device') }}</h4></div></div>
                          <div class="col-lg-6">
                            <select class="process select droplinks {{ $gs->refer_require_attested_device == 1 ? 'drop-success' : 'drop-danger' }}">
                              <option data-val="1" value="{{route('admin-gs-status',['refer_require_attested_device',1])}}" {{ $gs->refer_require_attested_device == 1 ? 'selected' : '' }}>{{ __('Required') }}</option>
                              <option data-val="0" value="{{route('admin-gs-status',['refer_require_attested_device',0])}}" {{ $gs->refer_require_attested_device == 0 ? 'selected' : '' }}>{{ __('Not required') }}</option>
                            </select>
                          </div>
                        </div>
```

- [ ] **Step 4: Deploy all (backup each), lint, view:clear**
```bash
# backup + pscp ReferralHelper.php, CheckoutController.php, Generalsetting.php, refer.blade.php (per deploy procedure)
echo y | plink ... "php -l .../ReferralHelper.php; php -l .../Api/Front/CheckoutController.php; php -l .../Models/Generalsetting.php; cd /home/asmishop/htdocs/asmishop.com && php artisan view:clear >/dev/null 2>&1 && echo ok"
```
Expected: no syntax errors + `ok`.

- [ ] **Step 5: Commit**
```bash
cd "G:/asmi_shop/asmi_shop_backend" && git add project/app/Helpers/ReferralHelper.php project/app/Http/Controllers/Api/Front/CheckoutController.php project/app/Models/Generalsetting.php project/resources/views/admin/generalsetting/refer.blade.php && git commit -m "feat(device): referral device gate + per-device cap + admin settings"
```

---

## Task 6: Backend verification (tinker)

**Files:** none.

- [ ] **Step 1: Verify AppCheckVerifier rejects junk + DeviceService trust** (piped tinker)
Create `scratch/device_test.php` (run via `php artisan tinker < file`):
```php
use App\Services\AppCheckVerifier;
use App\Services\DeviceService;
use App\Models\Device;

echo "junk token verify=" . var_export(AppCheckVerifier::verify('not-a-jwt'), true) . " (expect NULL)\n";
echo "empty verify=" . var_export(AppCheckVerifier::verify(''), true) . " (expect NULL)\n";

$r = DeviceService::register('dev-unit-1', null, 'android', '01999111222');
echo "register no-token attested=" . var_export($r['attested'], true) . " (expect false)\n";
echo "isTrusted=" . var_export(DeviceService::isTrusted('dev-unit-1'), true) . " (expect false)\n";

$d = Device::where('device_id', 'dev-unit-1')->first();
echo "device row platform=" . $d->platform . " attested=" . $d->attested . "\n";

Device::where('device_id', 'dev-unit-1')->delete();
\App\Models\DeviceUser::where('device_id', 'dev-unit-1')->delete();
echo "DONE\n";
```
Run it on the server; expect: junk/empty → NULL, register attested=false, isTrusted=false, row exists, cleaned. (A genuine token can only come from the real app — exercised in Task 10.)

---

## Task 7: Flutter — Firebase + App Check dependencies & gradle

**Files:** Modify `pubspec.yaml`, `android/settings.gradle.kts`, `android/app/build.gradle.kts`.

- [ ] **Step 1: Add pub deps.** In `pubspec.yaml` under `dependencies:` add:
```yaml
  firebase_core: ^3.8.0
  firebase_app_check: ^0.3.2
  flutter_secure_storage: ^9.2.2
  uuid: ^4.5.1
```
Run: `cd G:/asmi_shop/asmi_shop && flutter pub get`
Expected: resolves (if a version conflict appears, let pub pick compatible: replace the caret pin with the version pub suggests and re-run).

- [ ] **Step 2: Apply Google Services gradle plugin.** In `android/settings.gradle.kts`, inside the `plugins { ... }` block add:
```kotlin
    id("com.google.gms.google-services") version "4.4.2" apply false
```
In `android/app/build.gradle.kts`, inside its `plugins { ... }` block (after `id("com.android.application")`) add:
```kotlin
    id("com.google.gms.google-services")
```

- [ ] **Step 3: Ensure minSdk ≥ 23.** In `android/app/build.gradle.kts` `defaultConfig`, if `minSdk = flutter.minSdkVersion` resolves below 23, set explicitly:
```kotlin
        minSdk = 23
```
(Play Integrity / App Check require 19+, but 23 avoids multidex/desugar edge cases. Leave as-is if already ≥23.)

- [ ] **Step 4: Build sanity**
Run: `cd G:/asmi_shop/asmi_shop && flutter build apk --debug` (or `flutter run` later). Expected: Gradle resolves google-services + Firebase; build succeeds. (If google-services plugin errors that `google-services.json` is missing, confirm it is at `android/app/google-services.json` — it was fetched during setup.)

- [ ] **Step 5: Commit**
```bash
cd "G:/asmi_shop/asmi_shop" && git add pubspec.yaml pubspec.lock android/settings.gradle.kts android/app/build.gradle.kts && git commit -m "feat(device): add Firebase App Check + secure storage deps"
```

---

## Task 8: Flutter — DeviceIdentity service + Firebase init

**Files:** Create `lib/services/device_identity.dart`; modify `lib/main.dart`.

- [ ] **Step 1: Write `device_identity.dart`**
```dart
import 'dart:io';
import 'package:firebase_app_check/firebase_app_check.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:uuid/uuid.dart';

class DeviceIdentity {
  static const _key = 'asmi_device_id';
  static const _store = FlutterSecureStorage();

  /// Stable per-install id; generated once and persisted.
  static Future<String> getDeviceId() async {
    var id = await _store.read(key: _key);
    if (id == null || id.isEmpty) {
      id = const Uuid().v4();
      await _store.write(key: _key, value: id);
    }
    return id;
  }

  /// Current App Check token; null if unavailable.
  static Future<String?> getAppCheckToken() async {
    try {
      return await FirebaseAppCheck.instance.getToken();
    } catch (_) {
      return null;
    }
  }

  static String platform() => Platform.isIOS ? 'ios' : 'android';
}
```

- [ ] **Step 2: Init Firebase + App Check in `main()`**
In `lib/main.dart`, add imports:
```dart
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_app_check/firebase_app_check.dart';
import 'package:flutter/foundation.dart' show kDebugMode;
```
In `main()`, right after `WidgetsBinding widgetsBinding = WidgetsFlutterBinding.ensureInitialized();` add:
```dart
      try {
        await Firebase.initializeApp();
        await FirebaseAppCheck.instance.activate(
          androidProvider:
              kDebugMode ? AndroidProvider.debug : AndroidProvider.playIntegrity,
        );
      } catch (e) {
        dPrint('[AppCheck] init failed: $e');
      }
```
(`dPrint` is the app's existing debug logger — already used in this file.)

- [ ] **Step 3: Analyze**
Run: `cd G:/asmi_shop/asmi_shop && flutter analyze lib/services/device_identity.dart lib/main.dart`
Expected: no errors.

- [ ] **Step 4: Commit**
```bash
cd "G:/asmi_shop/asmi_shop" && git add lib/services/device_identity.dart lib/main.dart && git commit -m "feat(device): DeviceIdentity service + Firebase App Check init"
```

---

## Task 9: Flutter — send device id + token (register on launch + checkout)

**Files:** Modify `lib/main.dart` (or splash) for the register call; `lib/module/checkout/bloc/checkout_bloc.dart` for the body.

- [ ] **Step 1: Register the device after init.** In `main()`, after the App Check activate block, add a fire-and-forget register call:
```dart
      // ignore: discarded_futures
      () async {
        try {
          final id = await DeviceIdentity.getDeviceId();
          final tok = await DeviceIdentity.getAppCheckToken();
          await ApiClient().Request(
            url: "${URL.baseUrl}api/device/register",
            method: Method.POST,
            withAuth: false,
            enableShowError: false,
            body: {
              'device_id': id,
              'app_check_token': tok ?? '',
              'platform': DeviceIdentity.platform(),
            },
            onSuccess: (_) {},
            onError: (_) {},
          );
        } catch (_) {}
      }();
```
Add imports to `main.dart`:
```dart
import 'package:asmi_shop/services/device_identity.dart';
import 'package:asmi_shop/app_helper/api_client.dart';
import 'package:asmi_shop/utils/url.dart';
```
(If `ApiClient`/`URL` are already imported, skip duplicates.)

- [ ] **Step 2: Attach device id + token to the checkout body.** In `checkout_bloc.dart`, in the `_placeOrder` method, BEFORE building `final body = {...}`, fetch identity:
```dart
    final deviceId = await DeviceIdentity.getDeviceId();
    final appCheckToken = await DeviceIdentity.getAppCheckToken();
```
Add import at top: `import 'package:asmi_shop/services/device_identity.dart';`
Then in the body map (after `"referral_code": referralCode.text.trim(),`) add:
```dart
      "device_id": deviceId,
      "app_check_token": appCheckToken ?? '',
      "device_platform": DeviceIdentity.platform(),
```

- [ ] **Step 3: Analyze**
Run: `cd G:/asmi_shop/asmi_shop && flutter analyze lib/main.dart lib/module/checkout/bloc/checkout_bloc.dart`
Expected: no errors.

- [ ] **Step 4: Commit**
```bash
cd "G:/asmi_shop/asmi_shop" && git add lib/main.dart lib/module/checkout/bloc/checkout_bloc.dart && git commit -m "feat(device): send device id + App Check token on register + checkout"
```

---

## Task 10: End-to-end on emulator (real attestation)

**Files:** none.

- [ ] **Step 1: Run on emulator + register the runtime debug token**
```bash
cd G:/asmi_shop/asmi_shop && flutter run -d emulator-5554
```
On first run, App Check (debug provider) prints a line in the logs like
`App Check debug token: 'XXXXXXXX-....'`. Copy that token, then register it via API:
```bash
PNUM=401152501376; PROJ=asmi-shop; APPID=1:401152501376:android:843815d407e387a1eaa865
TOKEN=$(gcloud auth print-access-token)
curl -s -X POST "https://firebaseappcheck.googleapis.com/v1/projects/$PNUM/apps/$APPID/debugTokens" -H "Authorization: Bearer $TOKEN" -H "x-goog-user-project: $PROJ" -H "Content-Type: application/json" -d '{"displayName":"asmi-runtime-emulator","token":"<PASTE_TOKEN>"}'
```
Hot-restart the app so it fetches a real App Check token.

- [ ] **Step 2: Verify device registered as attested**
```bash
echo y | plink ... "mysql ... -e \"SELECT device_id, platform, attested FROM devices ORDER BY id DESC LIMIT 3\""
```
Expected: a row with `attested = 1` (the emulator's device_id).

- [ ] **Step 3: Turn the gate ON + place a referral order from the app**
```bash
echo y | plink ... "mysql ... -e \"UPDATE generalsettings SET refer_require_attested_device=1, refer_max_per_device=1 WHERE id=1\""
```
In the running app: add a product, checkout, enter a known referrer's code, place the order (new phone). Then:
```bash
echo y | plink ... "mysql ... -e \"SELECT order_id, referrer_id, device_id, status FROM referrals ORDER BY id DESC LIMIT 1\\G\""
```
Expected: a `pending` row WITH `device_id` set (the attested device).

- [ ] **Step 4: Verify per-device cap + unattested block**
- Place a SECOND first-order (another new phone) from the same emulator/device with the code → no new referral row (per-device cap = 1).
- Hit `/api/front/checkout`-style request without a valid token (or old app) while gate ON → device unattested → no referral row; order still places.

- [ ] **Step 5: Restore + decide gating**
Clean test orders/referrals/devices. Leave `refer_require_attested_device` at the value you want for production (recommend `1` once the attested app build is released; until then `0` so the current non-attested app still earns referrals). Document the final state.

---

## Notes
- **Login-alerts unification (deferred):** Task 1 adds `user_login_sessions.device_id` (column ready), but recording it in `AuthController@loginOtpVerify` + keying the new-device alert on it is intentionally DEFERRED — login-alerts (Phase 1) is itself still gated off, and referral anti-farm is the priority. When picked up: in `loginOtpVerify`, call `DeviceService::register($request->device_id, $request->app_check_token, $request->device_platform, $normPhone, $user->id)` and store `device_id` on the session row. Small, additive, no blocker.
- All device logic is fail-safe: missing/invalid token never blocks an order; only referral credit is withheld when the gate requires attestation.
- `refer_require_attested_device=0` until the attested app build ships → backward compatible with the current app.
- Debug provider is used in debug builds (needs the runtime debug token registered, Task 10). Release builds use Play Integrity automatically (SHAs already registered).
- iOS: `AndroidProvider` only here; when the iOS app ships, add `appleProvider: AppleProvider.appAttest` to `activate()` and register the iOS app in Firebase.
- Server = source of truth; local commits under `project/`, no co-author trailer; push only on explicit request.
