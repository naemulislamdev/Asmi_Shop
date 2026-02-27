<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;

class CustomeOrderController extends Controller
{
    public function createOrder()
    {
        $shippings = Shipping::where('status', 1)->get();
        return view('admin.order.create.order_create', compact('shippings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:50',
            'customer_phone' => 'required|regex:/^(01[3-9]\d{8})$/',
            'customer_address' => 'required|string|max:255',
            'payment_method' => 'required|string|max:50',
            'shipping_area' => 'required|string|max:50',
            'total_bill' => 'required|numeric',
        ]);
        $products = $request->products;

        if (!$products || count($products) == 0) {
            return back()->with('error', 'No products selected');
        }

        $totalQty = 0;
        $totalPrice = 0;
        $items = [];

        // Get all products in one query
        $productIds = collect($products)->pluck('product_id');
        $productData = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($products as $key => $product) {

            $qty        = (int) $product['qty'];
            $unitPrice  = (float) $product['unit_price'];
            $lineTotal  = (float) $product['line_total'];

            $dbProduct = $productData[$product['product_id']] ?? null;
            if (!$dbProduct) continue;

            $totalQty += $qty;
            $totalPrice += $lineTotal;

            $items[$product['product_id']] = [
                "user_id" => 0,
                "qty" => $qty,
                "stock" => $dbProduct->stock - $qty,
                "price" => $lineTotal,
                "item" => [
                    "id" => $dbProduct->id,
                    "user_id" => $dbProduct->user_id ?? 0,
                    "slug" => $dbProduct->slug ?? '',
                    "name" => $dbProduct->name,
                    "sku" => $dbProduct->sku,
                    "photo" => $dbProduct->photo ?? '',
                    "price" => $unitPrice,
                    "discount" => $dbProduct->discount ?? 0,
                    "discount_type" => $dbProduct->discount_type,
                    "stock" => $dbProduct->stock,
                    "type" => $dbProduct->type ?? 'Physical',
                    "stock_check" => 0,
                ],
                "license" => "",
                "dp" => "0",
                "keys" => "",
                "values" => "",
                "item_price" => $unitPrice,
                "discount" => 0,
            ];
        }

        $new_cart = [
            "totalQty" => $totalQty,
            "totalPrice" => $totalPrice,
            "items" => $items
        ];

        $order = new Order();

        $order->cart = json_encode($new_cart);
        $order->method = $request->payment_method;
        $order->totalQty = $totalQty;
        $order->pay_amount = $request->total_bill;
        $order->order_number = 'pos' . rand(10000, 99999);
        $order->payment_status = 'Pending';
        $order->customer_name = $request->customer_name;
        $order->customer_country = 'Bangladesh';
        $order->customer_phone = $request->customer_phone;
        $order->customer_address = $request->customer_address;
        $order->coupon_code = $request->coupon_code;
        $order->coupon_discount = $request->coupon_discount;
        $order->order_source = 'POS';
        $order->currency_sign = '৳';
        $order->currency_name = 'BDT';
        $order->currency_value = 1;
        $order->shipping = $request->shipping_area;
        $order->status = 'pending';
        $order->wallet_price = 0;
        $order->affilate_users = null;
        $order->tax = 0;
        $order->tax_location = 'Bangladesh';

        $order->save();

        return back()->with('success', 'POS Order Created Successfully');
    }
    public function getProduct(Request $request)
    {
        $product = Product::where('sku', $request->code)
            ->orWhere('name', $request->code)
            ->first();

        if (!$product) {
            return response()->json(['success' => false]);
        }

        // Base price
        $basePrice = $product->price;

        $discountAmount = 0;

        if ($product->discount_type && $product->discount_amount > 0) {

            if ($product->discount_type === 'percent') {
                $discountAmount = ($basePrice * $product->discount_amount) / 100;
            }

            if ($product->discount_type === 'fixed') {
                $discountAmount = $product->discount_amount;
            }
        }

        $finalPrice = max($basePrice - $discountAmount, 0);

        return response()->json([
            'success' => true,
            'product' => [
                'id'              => $product->id,
                'code'            => $product->sku,
                'name'            => $product->name,
                'price'           => round($finalPrice, 2),
                'original_price'  => round($basePrice, 2),
                'discount_amount' => round($discountAmount, 2),
            ]
        ]);
    }
    public function search(Request $request)
    {
        //naemulislamdev@2026
        $search = $request->search;

        $customer = User::where('name', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")
            ->first();

        if ($customer) {
            return response()->json([
                'status' => 'found',
                'data' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'phone' => $customer->phone,
                    'address' => $customer->address_line_1,
                ]
            ]);
        }

        return response()->json([
            'status' => 'not_found'
        ]);
    }
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'subtotal' => 'required|numeric'
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('status', 1)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ]);
        }

        // Date validation
        $today = now()->format('Y-m-d');

        if ($coupon->start_date && $coupon->start_date > $today) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon not started yet'
            ]);
        }

        if ($coupon->end_date && $coupon->end_date < $today) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon expired'
            ]);
        }

        // Usage limit
        if ($coupon->times && $coupon->used >= $coupon->times) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit exceeded'
            ]);
        }

        $discountAmount = 0;

        // Type 1 = Fixed
        if ($coupon->type == 1) {
            $discountAmount = $coupon->price;
        }

        // Type 2 = Percent
        if ($coupon->type == 0) {
            $discountAmount = ($request->subtotal * $coupon->price) / 100;
        }

        // Never allow discount > subtotal
        $discountAmount = min($discountAmount, $request->subtotal);

        return response()->json([
            'success' => true,
            'discount' => round($discountAmount, 2),
            'coupon_id' => $coupon->id,
            'message' => 'Coupon applied successfully'
        ]);
    }
}
