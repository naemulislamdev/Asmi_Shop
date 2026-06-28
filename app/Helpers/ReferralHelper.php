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
    /** Deterministic short code from a user id, e.g. 8702 -> ASMI6PQ. */
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
