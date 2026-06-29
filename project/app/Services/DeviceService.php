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
