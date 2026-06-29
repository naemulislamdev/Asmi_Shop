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
