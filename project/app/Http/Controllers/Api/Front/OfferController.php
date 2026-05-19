<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConditionalOfferResource;
use App\Http\Resources\PromoOfferResource;
use App\Models\ConditionalOffer;
use App\Models\PromoOffer;

class OfferController extends Controller
{
    /**
     * GET /api/front/promo-offers
     * Active promo offers (status=true and within date window if set).
     */
    public function promoOffers()
    {
        try {
            $today = now()->toDateString();

            $offers = PromoOffer::where('status', true)
                ->where(function ($q) use ($today) {
                    $q->whereNull('start_date')->orWhere('start_date', '<=', $today);
                })
                ->where(function ($q) use ($today) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', $today);
                })
                ->orderByDesc('created_at')
                ->get();

            return response()->json([
                'status' => true,
                'data'   => PromoOfferResource::collection($offers),
                'error'  => [],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * GET /api/front/promo-offer/{id}
     * Single promo offer with populated products.
     */
    public function promoOffer($id)
    {
        try {
            $offer = PromoOffer::find($id);
            if (!$offer) {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'Offer not found.']]);
            }
            return response()->json([
                'status' => true,
                'data'   => new PromoOfferResource($offer),
                'error'  => [],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * GET /api/front/conditional-offers
     * Active conditional offers (is_active=1 and within date window if set).
     */
    public function conditionalOffers()
    {
        try {
            $today = now()->toDateString();

            $offers = ConditionalOffer::where('is_active', 1)
                ->where(function ($q) use ($today) {
                    $q->whereNull('starts_at')->orWhereDate('starts_at', '<=', $today);
                })
                ->where(function ($q) use ($today) {
                    $q->whereNull('ends_at')->orWhereDate('ends_at', '>=', $today);
                })
                ->orderByDesc('created_at')
                ->get();

            return response()->json([
                'status' => true,
                'data'   => ConditionalOfferResource::collection($offers),
                'error'  => [],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    /**
     * GET /api/front/conditional-offer/{id}
     */
    public function conditionalOffer($id)
    {
        try {
            $offer = ConditionalOffer::find($id);
            if (!$offer) {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'Offer not found.']]);
            }
            return response()->json([
                'status' => true,
                'data'   => new ConditionalOfferResource($offer),
                'error'  => [],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }
}
