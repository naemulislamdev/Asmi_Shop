<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTrack extends Model
{
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id')->withDefault();
    }

}
