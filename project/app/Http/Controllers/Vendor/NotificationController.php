<?php

namespace App\Http\Controllers\Vendor;

use App\Models\UserNotification;

class NotificationController extends VendorBaseController
{

    public function order_notf_count($id)
    {
        $data = UserNotification::where('user_id','=',$id)->where('is_read','=',0)->get()->count();
        return response()->json($data);            
    } 

    public function order_notf_clear($id)
    {
        $data = UserNotification::where('user_id','=',$id);
        $data->delete(); 
        return back()->with("success","Notification Clear Successfully");       
    } 

    public function order_notf_show($id)
    {
        $datas = UserNotification::where('user_id','=',$id)->get();
        if($datas->count() > 0){
          foreach($datas as $data){
            $data->is_read = 1;
            $data->update();
          }
        }       
        return view('vendor.notification.order',compact('datas'));           
    } 
}
