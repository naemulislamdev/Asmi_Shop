<?php

namespace App\Http\Controllers\Api\Front;

use App\Classes\GeniusMailer;
use App\Helpers\OrderHelper;
use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDetailsResource;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Package;
use App\Models\Pagesetting;
use App\Models\Product;
use App\Models\Reward;
use App\Models\Shipping;
use App\Models\State;
use App\Models\User;
use App\Models\VendorOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        try {

            $input = $request->all();

            // ✅ Decode items safely
            $items = is_string($input['items'])
                ? json_decode($input['items'], true)
                : $input['items'];

            $cart = new Cart(null);
            $gs = Generalsetting::cached();

            $curr = Currency::where('name', $input['currency_code'] ?? '')
                ->first() ?? Currency::where('is_default', 1)->first();

            $productIds = collect($items)
                ->filter(fn($i) => $this->validCartItem($i))
                ->pluck('id')
                ->all();

            $productMap = Product::whereIn('id', $productIds)
                ->get(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes'])
                ->keyBy('id');

            foreach ($items as $item) {
                if ($this->validCartItem($item) && isset($productMap[$item['id']])) {
                    $this->addtocart(
                        $cart,
                        $curr,
                        $gs,
                        $productMap[$item['id']],
                        $item['qty'],
                        $item['size'],
                        $item['color'],
                        $item['size_qty'],
                        $item['size_price'],
                        $item['size_key'],
                        $item['keys'],
                        $item['values'],
                        $item['prices'],
                        $input['affilate_user'] ?? null
                    );
                }
            }

            $cartData = [
                'totalQty' => $cart->totalQty,
                'totalPrice' => $cart->totalPrice,
                'items' => $cart->items,
            ];

            $affilateData = OrderHelper::product_affilate_check($cart);
            $affilate_users = !empty($affilateData) ? json_encode($affilateData) : null;

            $orderCalculate = PriceHelper::getOrderTotal($input, $cart);

            if (!empty($orderCalculate['success']) && !$orderCalculate['success']) {
                return response()->json([
                    'status' => false,
                    'error' => $orderCalculate['message']
                ]);
            }

            $order = new Order();
            $input['user_id'] = $request->user_id ?? null;
            $input['order_source'] = 'Mobile Apps';
            $input['cart'] = json_encode($cartData);
            $input['affilate_users'] = $affilate_users;

            $input['currency_name'] = $curr->name;
            $input['currency_sign'] = $curr->sign;
            $input['currency_value'] = $curr->value;

            $input['pay_amount'] = $orderCalculate['total_amount'] / $curr->value;
            $input['order_number'] = 'A' . now()->timestamp . rand(100, 999);

            $input['wallet_price'] = ($request->wallet_price ?? 0) / $curr->value;

            $input['tax'] = $this->calculateTax($cart, $input);

            $order->fill($input)->save();

            $order->tracks()->create([
                'title' => 'Pending',
                'text' => 'Order placed successfully'
            ]);

            $order->notifications()->create();


            $apiUser = Auth::guard('api')->user();
            if ($apiUser) {
                if ($gs->is_reward == 1) {
                    $final_reword = Reward::orderByRaw('ABS(order_amount - ?)', [$order->pay_amount])->first();
                    if ($final_reword) {
                        $apiUser->update(['reward' => $apiUser->reward + $final_reword->reward]);
                    }
                }
                $apiUser->update(['balance' => $apiUser->balance - $order->wallet_price]);
            }


            OrderHelper::size_qty_check($cart); // For Size Quantiy Checking
            OrderHelper::stock_check($cart); // For Stock Checking
            OrderHelper::vendor_order_check($cart, $order); // For Vendor Order Checking

            if ($order->user_id != 0 && $order->wallet_price != 0) {
                OrderHelper::add_to_transaction($order, $order->wallet_price); // Store To Transactions
            }

            //Sending Email To Buyer
            $data = [
                'to' => $order->customer_email,
                'type' => "new_order",
                'cname' => $order->customer_name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
                'wtitle' => "",
                'onumber' => $order->order_number,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendAutoOrderMail($data, $order->id);
            $ps = Pagesetting::find(1);
            //Sending Email To Admin
            $data = [
                'to' => $ps->contact_email,
                'subject' => "New Order Recieved!!",
                'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is " . $order->order_number . ".Please login to your panel to check. <br>Thank you.",
            ];
            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);

            unset($order['cart']);
            return response()->json(['status' => true, 'data' => route('payment.checkout') . '?order_number=' . $order->order_number, 'error' => []]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    //*** POST Request
    public function update(Request $request, $id)
    {

        try {
            //--- Logic Section
            $data = Order::find($id);

            $input = $request->all();
            if ($data->status == "completed") {

                // Then Save Without Changing it.
                $input['status'] = "completed";
                $data->update($input);
                //--- Logic Section Ends

                //--- Redirect Section
                return response()->json(['status' => true, 'data' => $data, 'error' => []]);
                //--- Redirect Section Ends

            } else {
                if ($input['status'] == "completed") {

                    $totals = [];
                    foreach ($data->vendororders as $vorder) {
                        $totals[$vorder->user_id] = ($totals[$vorder->user_id] ?? 0) + $vorder->price;
                    }
                    foreach ($totals as $uid => $sum) {
                        User::whereKey($uid)->increment('current_balance', $sum);
                    }

                    if ($auser = User::find($data->affilate_user)) {
                        $auser->increment('affilate_income', $data->affilate_charge);
                    }

                    $gs = Generalsetting::cached();
                    if ($gs->is_smtp == 1) {
                        $maildata = [
                            'to' => $data->customer_email,
                            'subject' => 'Your order ' . $data->order_number . ' is Confirmed!',
                            'body' => "Hello " . $data->customer_name . "," . "\n Thank you for shopping with us. We are looking forward to your next visit.",
                        ];

                        $mailer = new GeniusMailer();
                        $mailer->sendCustomMail($maildata);
                    } else {
                        $to = $data->customer_email;
                        $subject = 'Your order ' . $data->order_number . ' is Confirmed!';
                        $msg = "Hello " . $data->customer_name . "," . "\n Thank you for shopping with us. We are looking forward to your next visit.";
                        $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
                        mail($to, $subject, $msg, $headers);
                    }
                }
                if ($input['status'] == "declined") {

                    if ($data->user_id != 0) {
                        if ($data->wallet_price != 0) {
                            $user = User::find($data->user_id);
                            if ($user) {
                                $user->balance = $user->balance + $data->wallet_price;
                                $user->save();
                            }
                        }
                    }

                    $cart = unserialize(bzdecompress(utf8_decode($data->cart)));

                    $itemIds = collect($cart->items)->pluck('item.id')->unique()->all();
                    $productMap = Product::whereIn('id', $itemIds)->get()->keyBy('id');

                    foreach ($cart->items as $prod) {
                        $product = $productMap[$prod['item']['id']] ?? null;
                        if (!$product) {
                            continue;
                        }

                        $x = (string) $prod['stock'];
                        if ($x != null) {
                            $product->stock = $product->stock + $prod['qty'];
                            $product->update();
                        }

                        $sx = (string) $prod['size_qty'];
                        if (!empty($sx)) {
                            $sxi = (int) $sx;
                            $temp = $product->size_qty;
                            $temp[$prod['size_key']] = $sxi;
                            $product->size_qty = implode(',', $temp);
                            $product->update();
                        }
                    }

                    $gs = Generalsetting::cached();
                    if ($gs->is_smtp == 1) {
                        $maildata = [
                            'to' => $data->customer_email,
                            'subject' => 'Your order ' . $data->order_number . ' is Declined!',
                            'body' => "Hello " . $data->customer_name . "," . "\n We are sorry for the inconvenience caused. We are looking forward to your next visit.",
                        ];
                        $mailer = new GeniusMailer();
                        $mailer->sendCustomMail($maildata);
                    } else {
                        $to = $data->customer_email;
                        $subject = 'Your order ' . $data->order_number . ' is Declined!';
                        $msg = "Hello " . $data->customer_name . "," . "\n We are sorry for the inconvenience caused. We are looking forward to your next visit.";
                        $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
                        mail($to, $subject, $msg, $headers);
                    }
                }

                $data->update($input);

                if ($request->track_text) {
                    $title = ucwords($request->status);
                    $ck = OrderTrack::where('order_id', '=', $id)->where('title', '=', $title)->first();
                    if ($ck) {
                        $ck->order_id = $id;
                        $ck->title = $title;
                        $ck->text = $request->track_text;
                        $ck->update();
                    } else {
                        $data = new OrderTrack;
                        $data->order_id = $id;
                        $data->title = $title;
                        $data->text = $request->track_text;
                        $data->save();
                    }
                }

                VendorOrder::where('order_id', '=', $id)->update(['status' => $input['status']]);

                //--- Redirect Section
                return response()->json(['status' => true, 'data' => $data, 'error' => []]);
                //--- Redirect Section Ends

            }
        } catch (\Exception $e) {
            return response()->json(['status' => true, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    //*** POST Request
    public function delete($id)
    {

        try {
            //--- Logic Section
            $data = Order::find($id);
            if ($data) {
                $data->delete();

                //--- Redirect Section
                return response()->json(['status' => true, 'data' => 'Order Deleted Successfully', 'error' => []]);
                //--- Redirect Section Ends
            } else {
                return response()->json(['status' => false, 'data' => [], 'error' => ['message' => 'Order Not Found']]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    //*** GET Request
    public function orderDetails(Request $request)
    {
        try {
            if ($request->has('order_number')) {
                $order_number = $request->order_number;
                $order = Order::where('order_number', $order_number)->firstOrFail();
                return response()->json(['status' => true, 'data' => new OrderDetailsResource($order), 'error' => []]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => [], 'error' => ['message' => $e->getMessage()]]);
        }
    }

    protected function addtocart($cart, $curr, $gs, $prod, $p_qty, $p_size, $p_color, $p_size_qty, $p_size_price, $p_size_key, $p_keys, $p_values, $p_prices, $affilate_user)
    {
        try {
            $qty = $p_qty;
            $size = str_replace(' ', '-', $p_size);
            $color = $p_color;
            $size_qty = $p_size_qty;
            $size_price = (float) $p_size_price;
            $size_key = $p_size_key;
            $keys = $p_keys;
            $keys = explode(",", $keys);
            $values = $p_values;
            $values = explode(",", $values);
            $prices = $p_prices;

            if (!empty($prices)) {
                $prices = explode(",", $prices);
            }

            $keys = $keys == "" ? '' : implode(',', $keys);
            $values = $values == "" ? '' : implode(',', $values);

            $size_price = ($size_price / $curr->value);

            if ($prod->user_id != 0) {
                $prc = $prod->price + $gs->fixed_commission + ($prod->price / 100) * $gs->percentage_commission;
                $prod->price = round($prc, 2);
            }

            if (!empty($prices)) {
                if (!empty($prices[0])) {
                    foreach ($prices as $data) {
                        $prod->price += ($data / $curr->value);
                    }
                }
            }

            if (!empty($prod->license_qty)) {
                $lcheck = 1;
                foreach ($prod->license_qty as $ttl => $dtl) {
                    if ($dtl < 1) {
                        $lcheck = 0;
                    } else {
                        $lcheck = 1;
                        break;
                    }
                }
                if ($lcheck == 0) {
                    return false;
                }
            }
            if (empty($size)) {
                if (!empty($prod->size)) {
                    $size = trim($prod->size[0]);
                }
                $size = str_replace(' ', '-', $size);
            }

            if (empty($color)) {
                if (!empty($prod->color)) {
                    $color = $prod->color[0];
                }
            }


            $color = str_replace('#', '', $color);

            $cart->addnum($prod, $prod->id, $qty, $size, $color, $size_qty, $size_price, $size_key, $keys, $values, $affilate_user);

            $cart->totalPrice = 0;


            foreach ($cart->items as $data) {
                $cart->totalPrice += $data['price'];
            }

            return $cart->items;
        } catch (\Exception $e) {
        }
    }

    public function getCoupon(Request $request)
    {

        $code = $request->coupon;
        $coupon = Coupon::where('code', '=', $code)->where('status', 1)->first();

        if ($coupon) {

            $today = date('Y-m-d');
            $from = date('Y-m-d', strtotime($coupon->start_date));

            $to = date('Y-m-d', strtotime($coupon->end_date));

            if ($from <= $today && $to >= $today) {
                return response()->json(['status' => true, 'data' => $coupon, 'error' => []]);
            } else {
                return response()->json(['status' => false, 'data' => [], 'error' => 'Invalid Coupon']);
            }
        } else {
            return response()->json(['status' => false, 'data' => [], 'error' => 'Coupon Not Found']);
        }
    }

    public function getShippingPackaging()
    {
        $shipping = Shipping::whereUserId(0)->get();
        $packaging = Package::whereUserId(0)->get();
        return response()->json(['status' => true, 'data' => ['shipping' => $shipping, 'packaging' => $packaging], 'error' => []]);
    }


    // public function VendorWisegetShippingPackaging(Request $request)
    // {

    //     $explode = explode(',', $request->vendor_ids);

    //     foreach ($explode as $key => $value) {
    //         $shipping[$value] = Shipping::where('user_id', $value)->get();
    //         $packaging[$value] = Package::where('user_id', $value)->get();
    //     }


    //     return response()->json(['status' => true, 'data' => ['shipping' => $shipping, 'packaging' => $packaging], 'error' => []]);
    // }

    public function VendorWisegetShippingPackaging(Request $request)
    {
        $vendorIds = array_filter(array_map('trim', explode(',', (string) $request->vendor_ids)), 'strlen');

        $columns = ['id', 'user_id', 'title', 'subtitle', 'price'];

        $shipping = Shipping::whereIn('user_id', $vendorIds)
            ->get($columns)
            ->groupBy('user_id');

        $packaging = Package::whereIn('user_id', $vendorIds)
            ->get($columns)
            ->groupBy('user_id');

        $formattedShipping = [];
        $formattedPackaging = [];
        foreach ($vendorIds as $vid) {
            $formattedShipping[$vid] = $shipping->get($vid, collect())->values();
            $formattedPackaging[$vid] = $packaging->get($vid, collect())->values();
        }

        return response()->json([
            'status' => true,
            'data' => [
                'shipping' => $formattedShipping,
                'packaging' => $formattedPackaging,
            ],
            'error' => [],
        ]);
    }


    public function countries()
    {
        $countries = Cache::remember('checkout.countries.tree', 3600, function () {
            return Country::with('states.cities')->get();
        });
        return response()->json(['status' => true, 'data' => $countries, 'error' => []]);
    }
}
