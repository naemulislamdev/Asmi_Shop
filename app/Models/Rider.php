<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Rider extends Authenticatable
{


    protected $guarded = [''];
    protected $hidden = [
        'password', 'remember_token'
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function orders()
    {
        return $this->hasMany('App\Models\DeliveryRider');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }
}
