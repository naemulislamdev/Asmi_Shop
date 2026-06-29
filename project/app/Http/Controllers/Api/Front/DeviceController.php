<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Services\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function register(Request $request)
    {
        $res = DeviceService::register(
            $request->device_id,
            $request->app_check_token,
            $request->platform
        );
        return response()->json(['status' => true, 'data' => $res, 'error' => []]);
    }
}
