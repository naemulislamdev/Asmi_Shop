<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceUser extends Model
{
    protected $table = 'device_user';
    public $timestamps = false;
    protected $guarded = ['id'];
}
