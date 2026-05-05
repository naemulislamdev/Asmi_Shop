<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Package;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ManualController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'txnid' => 'required',
        ]);
        if ($request->has('order_number')) {
            $order_number = $request->order_number;
            $order = Order::where('order_number', $order_number)->firstOrFail();
            $order->pay_amount = round($order->pay_amount, 2);
            $order->method = $request->method;
            $order->txnid = $request->txnid;
            $order->payment_status = 'Pending';
            $order->save();
            return redirect(route('front.payment.success', 1));
        } else {
            return redirect()->back()->with('unsuccess', 'Something Went Wrong.');
        }
    }
}
