<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $guarded = ['id'];

    public function vendororders()
    {
        return $this->hasMany('App\Models\VendorOrder','order_id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification','order_id');
    }

    public function tracks()
    {
        return $this->hasMany('App\Models\OrderTrack','order_id');
    }

    public static function getShipData($cart)
    {
        $vendor_shipping_id = 0;
        $user = array();
        foreach ($cart->items as $prod) {
                $user[] = $prod['item']['user_id'];
        }
        $users = array_unique($user);
        if(count($users) == 1)
        {
            $shipping_data  = DB::table('shippings')->whereUserId($users[0])->get();
            if(count($shipping_data) == 0){
                $shipping_data  = DB::table('shippings')->whereUserId(0)->get();
            }
            else{
                $vendor_shipping_id = $users[0];
            }
        }
        else {
            $shipping_data  = DB::table('shippings')->whereUserId(0)->get();
        }
        $data['shipping_data'] = $shipping_data;
        $data['vendor_shipping_id'] = $vendor_shipping_id;
        return $data;
    }

    public static function getPackingData($cart)
    {
        $vendor_packing_id = 0;
        $user = array();
        foreach ($cart->items as $prod) {
                $user[] = $prod['item']['user_id'];
        }
        $users = array_unique($user);
        if(count($users) == 1)
        {
            $package_data  = DB::table('packages')->whereUserId($users[0])->get();

            if(count($package_data) == 0){
                $package_data  = DB::table('packages')->whereUserId(0)->get();
            }
            else{
                $vendor_packing_id = $users[0];
            }
        }
        else {
            $package_data  = DB::table('packages')->whereUserId(0)->get();
        }
        $data['package_data'] = $package_data;
        $data['vendor_packing_id'] = $vendor_packing_id;
        return $data;
    }
    public function shippingMethod()
    {
        return $this->belongsTo('App\Models\Shipping','shipping');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
