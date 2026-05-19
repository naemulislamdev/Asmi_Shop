<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class PromoOfferResource extends JsonResource
{
    public function toArray($request)
    {
        $productIds = [];
        if (!empty($this->products)) {
            $decoded = is_string($this->products) ? json_decode($this->products, true) : $this->products;
            if (is_array($decoded)) {
                $productIds = array_values(array_filter(array_map('intval', $decoded)));
            }
        }

        $products = [];
        if (!empty($productIds)) {
            $rows = Product::whereIn('id', $productIds)
                ->where('status', 1)
                ->get();
            $products = ProductlistResource::collection($rows);
        }

        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'slug'       => $this->slug,
            'subtitle'   => $this->subtitle,
            'image'      => $this->image
                ? url('/') . '/assets/images/promo-offers/' . $this->image
                : null,
            'bg_image'   => $this->bg_image
                ? url('/') . '/assets/images/promo-offers/' . $this->bg_image
                : null,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
            'status'     => (bool) $this->status,
            'products'   => $products,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
