<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $discounted = null;
        if ($this->discount > 0) {
            if ($this->discount_type === 'percent') {
                $discounted = (int) $this->price - ($this->price * ($this->discount / 100));
            } elseif ($this->discount_type === 'flat') {
                $discounted = (int) $this->price - $this->discount;
            }
        }
        return [
            'id' => $this->id,
            'title' => $this->name,
            'thumbnail' => url('/') . '/assets/images/thumbnails/' . $this->thumbnail,
            'rating' =>  $this->ratings()->avg('rating') > 0 ? (string) round($this->ratings()->avg('rating'), 2) : (string) round(0.00, 2),
            'current_price' => (string)$this->ApishowPrice(),
            'previous_price' => (string)$discounted,
            'sale_end_date' => $this->when($this->is_discount == 1, $this->discount_date),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        //   return [
        //     'id' => $this->id,
        //     'title' => $this->name,
        //     'thumbnail' => url('/') . '/assets/images/thumbnails/'.$this->thumbnail,
        //     'rating' =>  $this->ratings()->avg('rating') > 0 ? (string) round($this->ratings()->avg('rating'), 2) : (string) round(0.00, 2),
        //     'current_price' => (string)$this->ApishowPrice(),
        //     'previous_price' => (string)$this->ApishowPreviousPrice(),
        //     'sale_end_date' => $this->when($this->is_discount == 1, $this->discount_date),
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        //   ];
    }
}
