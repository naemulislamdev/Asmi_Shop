<?php

namespace App\Http\Controllers\Payment\Checkout;

use App\Classes\GeniusMailer;use App\Helpers\OrderHelper;use App\Helpers\PriceHelper;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Order;
use App\Models\Reward;
use App\Models\State;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CashOnDeliveryController extends CheckoutBaseControlller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:50',
            'customer_phone' => 'required|regex:/^(01[3-9]\d{8})$/',
            'email' => 'nullable|string|email|max:255',
            'customer_address' => 'required|string|max:255',
            'order_note' => 'nullable|string|max:255',
        ]);
        $requestInput = $request->all();
        //dd($requestInput);
        //$step1 = Session::get('step1');
        //$input = array_merge($step1, $requestInput);
        $input = $requestInput;
        //dd($input);

        if ($request->pass_check) {
            $auth = OrderHelper::auth_check($input); // For Authentication Checking
            if (!$auth['auth_success']) {
                return redirect()->back()->with('unsuccess', $auth['error_message']);
            }
        }

        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success', __("You don't have any product to checkout."));
        }

        $oldCart = Session::get('cart');

        $cart = new Cart($oldCart);

        $t_oldCart = Session::get('cart');
        $t_cart = new Cart($t_oldCart);
        $new_cart = [];
        $new_cart['totalQty'] = $t_cart->totalQty;
        $new_cart['totalPrice'] = $t_cart->totalPrice;
        $new_cart['items'] = $t_cart->items;
        $new_cart = json_encode($new_cart);
        //$temp_affilate_users = OrderHelper::product_affilate_check($cart);
        //$affilate_users = $temp_affilate_users == null ? null : json_encode($temp_affilate_users);
        $affilate_users = null;

        $orderCalculate = PriceHelper::getOrderTotal($input, $cart);
        //dd($orderCalculate);

        if (isset($orderCalculate['success']) && $orderCalculate['success'] == false) {
            return redirect()->back()->with('unsuccess', $orderCalculate['message']);
        }

        if ($this->gs->multiple_shipping == 0) {
            $orderTotal = $orderCalculate['total_amount'];
            $shipping = $orderCalculate['shipping'];
            $packeing = $orderCalculate['packeing'];
            $is_shipping = $orderCalculate['is_shipping'];
            // $vendor_shipping_ids = $orderCalculate['vendor_shipping_ids'];
            // $vendor_packing_ids = $orderCalculate['vendor_packing_ids'];
            // $vendor_ids = $orderCalculate['vendor_ids'];

            $input['shipping_title'] = @$shipping->title;
            $input['vendor_shipping_id'] = @$shipping->id;
            $input['packing_title'] = @$packeing->title;
            $input['vendor_packing_id'] = @$packeing->id;
            $input['shipping_cost'] = @$packeing->price ?? 0;
            $input['packing_cost'] = @$packeing->price ?? 0;
            $input['is_shipping'] = $is_shipping;
            // $input['vendor_shipping_ids'] = $vendor_shipping_ids;
            // $input['vendor_packing_ids'] = $vendor_packing_ids;
            // $input['vendor_ids'] = $vendor_ids;
        } else {

            // multi shipping
            $orderTotal = $orderCalculate['total_amount'];
            $shipping = $orderCalculate['shipping'];

            $packeing = $orderCalculate['packeing'];
        $is_shipping = $orderCalculate['is_shipping'];
            // $vendor_shipping_ids = $orderCalculate['vendor_shipping_ids'];
            // $vendor_packing_ids = $orderCalculate['vendor_packing_ids'];
            // $vendor_ids = $orderCalculate['vendor_ids'];
            $shipping_cost = $orderCalculate['shipping_cost'];
            $packing_cost = $orderCalculate['packing_cost'];
            //$shipping->id;
            $input['shipping'] = $shipping->id;
            // $input['shipping_title'] = $vendor_shipping_ids;
            // $input['vendor_shipping_id'] = $vendor_shipping_ids;
            // $input['packing_title'] = $vendor_packing_ids;
            // $input['vendor_packing_id'] = $vendor_packing_ids;
            $input['shipping_cost'] = $shipping_cost;
            $input['packing_cost'] = $packing_cost;
            $input['is_shipping'] = $is_shipping;
            // $input['vendor_shipping_ids'] = $vendor_shipping_ids;
            // $input['vendor_packing_ids'] = $vendor_packing_ids;
            // $input['vendor_ids'] = $vendor_ids;
            // unset($input['shipping']);
            // unset($input['packeging']);
        }
        //dd($shipping);

        $order = new Order;
        $success_url = route('front.payment.return');
        $input['order_source'] = 'Website';
        $input['user_id'] = Auth::check() ? Auth::user()->id : null;
        $input['cart'] = $new_cart;
        $input['affilate_users'] = $affilate_users;
        $input['pay_amount'] = $orderTotal;
        $input['order_number'] ='w'. rand(10000, 99999);
        $input['wallet_price'] = $request->wallet_price / $this->curr->value;
        $input['customer_country'] = 'Bangladesh';

        if ($input['tax_type'] == 'state_tax') {
            $input['tax_location'] = State::findOrFail($input['tax'])->state;
        } else {
            $input['tax_location'] = 'Bangladesh'; // Country::findOrFail($input['tax'])->country_name;
        }
        $input['tax'] = Session::get('current_tax') ?? 0;

        $order->fill($input)->save();
     
        $order->notifications()->create();

        $sessionId = $input['session_id'];
        $userInfo = UserInfo::where('session_id', $sessionId)->where('phone', $input['customer_phone'])->first();
        if ($userInfo) {
            $userInfo->delete();
        }

        if ($input['coupon_id'] != "") {
            OrderHelper::coupon_check($input['coupon_id']); // For Coupon Checking
        }

        if (Auth::check()) {
            if ($this->gs->is_reward == 1) {
                $num = $order->pay_amount;
                $rewards = Reward::get();
                foreach ($rewards as $i) {
                    $smallest[$i->order_amount] = abs($i->order_amount - $num);
                }

                if (isset($smallest)) {
                    asort($smallest);
                    $final_reword = Reward::where('order_amount', key($smallest))->first();
                    Auth::user()->update(['reward' => (Auth::user()->reward + $final_reword->reward)]);
                }

            }
        }

        OrderHelper::size_qty_check($cart); // For Size Quantiy Checking
        OrderHelper::stock_check($cart); // For Stock Checking
        OrderHelper::vendor_order_check($cart, $order); // For Vendor Order Checking

        Session::put('temporder', $order);
        Session::put('tempcart', $cart);
        Session::forget('cart');
        Session::forget('already');
        Session::forget('coupon');
        Session::forget('coupon_total');
        Session::forget('coupon_total1');
        Session::forget('coupon_percentage');

        if ($order->user_id != 0 && $order->wallet_price != 0) {
            OrderHelper::add_to_transaction($order, $order->wallet_price); // Store To Transactions
        }

        //Sending Email To Buyer
        // $data = [
        //     'to' => $order->customer_email,
        //     'type' => "new_order",
        //     'cname' => $order->customer_name,
        //     'oamount' => "",
        //     'aname' => "",
        //     'aemail' => "",
        //     'wtitle' => "",
        //     'onumber' => $order->order_number,
        // ];

        // $mailer = new GeniusMailer();
        // $mailer->sendAutoOrderMail($data, $order->id);

        //Sending Email To Admin
        // $data = [
        //     'to' => $this->ps->contact_email,
        //     'subject' => "New Order Recieved!!",
        //     'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is " . $order->order_number . ".Please login to your panel to check. <br>Thank you.",
        // ];
        // $mailer = new GeniusMailer();
        // $mailer->sendCustomMail($data);

        return redirect($success_url);
    }
}
