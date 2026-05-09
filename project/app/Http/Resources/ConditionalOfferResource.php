<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ConditionalOfferResource extends JsonResource
{
    public function toArray($request)
    {
        $offerProducts = [];
        if (!empty($this->offer_products)) {
            $decoded = is_string($this->offer_products) ? json_decode($this->offer_products, true) : $this->offer_products;
            if (is_array($decoded)) {
                foreach ($decoded as $row) {
                    $sku    = $row['sku']    ?? null;
                    $amount = $row['amount'] ?? null;
                    if (!$sku) continue;

                    $product = Product::where('sku', $sku)
                        ->where('status', 1)
                        ->first();

                    $offerProducts[] = [
                        'sku'      => $sku,
                        'amount'   => $amount,
                        'product'  => $product ? new ProductlistResource($product) : null,
                    ];
                }
            }
        }

        $excludedSku = [];
        if (!empty($this->excluded_sku)) {
            $decoded = is_string($this->excluded_sku) ? json_decode($this->excluded_sku, true) : $this->excluded_sku;
            if (is_array($decoded)) {
                $excludedSku = array_values(array_filter(array_map('strval', $decoded)));
            }
        }

        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'description'         => $this->description,
            'min_purchase_amount' => (float) $this->min_purchase_amount,
            'offer_quantity'      => (int) $this->offer_quantity,
            'max_uses_per_order'  => (int) $this->max_uses_per_order,
            'is_active'           => (bool) $this->is_active,
            'starts_at'           => optional($this->starts_at)->toDateString(),
            'ends_at'             => optional($this->ends_at)->toDateString(),
            'offer_products'      => $offerProducts,
            'excluded_sku'        => $excludedSku,
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
        ];
    }
}
