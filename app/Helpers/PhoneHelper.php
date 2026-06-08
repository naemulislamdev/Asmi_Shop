<?php

namespace App\Helpers;

class PhoneHelper
{
    /**
     * Canonicalize a (BD) phone number to the form 01XXXXXXXXX.
     *
     * digits-only -> drop leading 880 country code -> ensure leading 0.
     * Returns null when there are no digits, so callers can treat
     * "no usable phone" as ineligible without extra checks.
     *
     * Examples (all -> 01805020340):
     *   01805020340, +8801805020340, 8801805020340, "0 1805 020340", +88001805020340
     */
    public static function normalize($raw): ?string
    {
        $d = preg_replace('/\D+/', '', (string) $raw);
        if ($d === '') {
            return null;
        }
        if (strpos($d, '880') === 0) {
            $d = substr($d, 3);
        }
        if (strlen($d) === 10 && $d[0] === '1') {
            $d = '0' . $d;
        }
        return $d !== '' ? $d : null;
    }
}
