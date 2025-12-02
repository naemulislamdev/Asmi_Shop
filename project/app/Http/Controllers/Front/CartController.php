<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Country;
use App\Models\Generalsetting;
use App\Models\Product;
use App\Models\State;
use App\Helpers\PriceHelper;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Session;
use Svg\Tag\Rect;

class CartController extends Controller
{

    public function cart(Request $request)
    {
        //return Session::forget('cart');
        if (!Session::has('cart')) {
            return view('frontend.cart');
        }
        if (Session::has('already')) {
            Session::forget('already');
        }
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        if (Session::has('coupon_total')) {
            Session::forget('coupon_total');
        }
        if (Session::has('coupon_total1')) {
            Session::forget('coupon_total1');
        }
        if (Session::has('coupon_percentage')) {
            Session::forget('coupon_percentage');
        }

        $digital = 0;
        $vendor_shipping_id = 0;
        $vendor_packing_id = 0;
        $curr = $this->curr;
        $gateways = PaymentGateway::scopeHasGateway($this->curr->id);

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;
        $totalPrice = $cart->totalPrice;
        $mainTotal = $totalPrice;
        $totalQty = $cart->totalQty;

        if ($request->ajax()) {
            return view('frontend.ajax.cart-page', compact('products', 'totalPrice', 'mainTotal', 'gateways', 'digital', 'totalQty', 'vendor_shipping_id', 'vendor_packing_id'));
        }
        return view('frontend.cart', compact('products', 'totalPrice', 'mainTotal', 'gateways', 'digital', 'totalQty', 'vendor_shipping_id', 'vendor_packing_id'));
    }

    public function cartview()
    {
        return view('load.cart');
    }
    public function view_cart()
    {
        if (!Session::has('cart')) {
            return view('frontend.cart');
        }
        if (Session::has('already')) {
            Session::forget('already');
        }
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        if (Session::has('coupon_code')) {
            Session::forget('coupon_code');
        }
        if (Session::has('coupon_total')) {
            Session::forget('coupon_total');
        }
        if (Session::has('coupon_total1')) {
            Session::forget('coupon_total1');
        }
        if (Session::has('coupon_percentage')) {
            Session::forget('coupon_percentage');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;
        $totalPrice = $cart->totalPrice;
        $mainTotal = $totalPrice;
        return view('frontend.ajax.cart-page', compact('products', 'totalPrice', 'mainTotal'));
    }

    public function addcartPost(Request $request)
    {
        $id = $request->product_id;
        $prod = Product::select(
            'id',
            'user_id',
            'slug',
            'name',
            'photo',
            'size',
            'size_qty',
            'size_price',
            'color',
            'price',
            'discount',
            'discount_type',
            'stock',
            'type',
            'file',
            'link',
            'license',
            'license_qty',
            'measure',
            'whole_sell_qty',
            'whole_sell_discount',
            'attributes',
            'color_all',
            'color_price'
        )->findOrFail($id);

        $finalPriceFromRequest = $request->has('final_price') ? (float) $request->final_price : null;
        $measureValue = $request->has('measure_value') ? (string) $request->measure_value : '';
        $quantity = $request->has('quantity') ? $request->quantity : 1;

        if (is_null($finalPriceFromRequest)) {
            if ($prod->discount > 0) {
                $finalPriceFromRequest = (float) \App\Helpers\PriceHelper::discountPrice($prod->price, $prod->discount, $prod->discount_type);
            } else {
                $finalPriceFromRequest = (float) $prod->price;
            }
        }

        $finalPrice = (float) $finalPriceFromRequest;

        $prod->price = $finalPrice;

        // Validate license quantity
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
                return response()->json(0);
            }
        }

        // Default size and color handling (same as previous behavior)
        $size = !empty($prod->size) ? trim($prod->size[0]) : '';
        $size = str_replace(' ', '-', $size);

        $color = '';
        if (!empty($prod->color)) {
            $color = $prod->color[0] ?? '';
            $color = str_replace('#', '', $color);
        }

        // Vendor Commission: optionally modify price for vendor products
        if ($prod->user_id != 0) {
            $gs = Generalsetting::findOrFail(1);
            $prc = $prod->price + $gs->fixed_commission + ($prod->price / 100) * $gs->percentage_commission;
            $prod->price = (float)$prc;
            // Also update finalPrice so cart receives vendor-inclusive price
            $finalPrice = (float)$prc;
        }

        // Attributes handling (preserve original behavior - chooses first option)
        $keys = '';
        $values = '';
        if (!empty($prod->attributes)) {
            $attrArr = json_decode($prod->attributes, true);
            $count = is_array($attrArr) ? count($attrArr) : 0;
            $j = 0;
            if (!empty($attrArr)) {
                foreach ($attrArr as $attrKey => $attrVal) {
                    if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {
                        if ($j == $count - 1) {
                            $keys .= $attrKey;
                        } else {
                            $keys .= $attrKey . ',';
                        }
                        $j++;
                        foreach ($attrVal['values'] as $optionKey => $optionVal) {
                            $values .= $optionVal . ',';
                            // add price of that attribute choice to product price (if exists)
                            if (!empty($attrVal['prices'][$optionKey])) {
                                $prod->price += (float)$attrVal['prices'][$optionKey];
                                $finalPrice += (float)$attrVal['prices'][$optionKey];
                            }
                            break;
                        }
                    }
                }
            }
        }
        $keys = rtrim($keys, ',');
        $values = rtrim($values, ',');

        // Prepare cart instance from session
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart); // update namespace/path if needed

        // Check for digital product case (your previous behavior)
        // Build the same key generation logic as Cart uses (for comparison)
        $valuesKeyPart = str_replace(str_split(' ,'), '', (string) $values);
        $priceKey = number_format((float)$finalPrice, 2, '.', '');
        $uniqueKey = implode('_', [
            $prod->id,
            $size ?? '',
            $color ?? '',
            $valuesKeyPart,
            $priceKey,
            str_replace(str_split(' ,'), '', (string)$measureValue)
        ]);

        if ($cart->items != null && isset($cart->items[$uniqueKey]) && @$cart->items[$uniqueKey]['dp'] == 1) {
            return response()->json('digital');
        }

        // Add to cart (pass finalPrice & measureValue)
        $cart->add($prod, $prod->id, $size, $color, $keys, $values, $finalPrice, $uniqueKey, $measureValue, $quantity);

        // Use the same uniqueKey to inspect the cart row
        if ($cart->items[$uniqueKey]['stock'] < 0) {
            return response()->json(0);
        }
        if (!empty($cart->items[$uniqueKey]['size_qty'])) {
            if ($cart->items[$uniqueKey]['qty'] > $cart->items[$uniqueKey]['size_qty']) {
                return response()->json(0);
            }
        }

        // Save back to session
        Session::put('cart', $cart);
        $data[0] = count($cart->items);
        $data[1] = $cart->totalPrice;
        return response()->json($data);
    }

    public function addbyone()
    {
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        $curr        = $this->curr;
        $id          = $_GET['id'];
        $itemId      = $_GET['itemid'];     // base product identifier
        $size_qty    = $_GET['size_qty'];
        $size_price  = $_GET['size_price'];
        $item_price  = $_GET['item_price'];
        $uniqueKey  = $_GET['unique_key'];

        // Load product
        $prod = Product::findOrFail($id);

        // Override price (variation price)
        $prod->price = $item_price ? (float)$item_price : $prod->price;

        // Load existing cart
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        // Add or Update Quantity
        $cart->addItem($prod, $uniqueKey, $size_qty, $size_price);

        // Stock check
        if ($prod->stock_check == 1) {
            if ($cart->items[$uniqueKey]['stock'] < 0) {
                return 0;
            }

            if (!empty($size_qty)) {
                if ($cart->items[$uniqueKey]['qty'] > $cart->items[$uniqueKey]['size_qty']) {
                    return 0;
                }
            }
        }

        // Save
        Session::put('cart', $cart);

        // Response
        $response = [
            PriceHelper::showCurrencyPrice($cart->totalPrice * $curr->value),
            $cart->items[$uniqueKey]['qty'],
            PriceHelper::showCurrencyPrice($cart->items[$uniqueKey]['price'] * $curr->value),
            PriceHelper::showCurrencyPrice($cart->totalPrice * $curr->value),
            $cart->items[$uniqueKey]['discount'] == 0 ? '' : '(' . $cart->items[$uniqueKey]['discount'] . '% Off)',
        ];

        return response()->json($response);
    }

    public function reducebyone(Request $request)
    {
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        $curr = $this->curr;

        // Use Request to be consistent and safer than raw $_GET
        $id         = $request->id;
        $uniqueKey  = $request->unique_key;
        $item_price  = $request->item_price;    // Must be the same unique key format used by add()
        $size_qty   = $request->size_qty;
        $size_price = $request->size_price;

        // Load product (we need product data for price/discount/wholesale rules)
        $prod = Product::findOrFail($id);

        // Ensure price not negative
        $prod->price = $item_price ? (float)$item_price : $prod->price;

        // Load existing cart
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        // Do the reduction using the uniqueKey
        $cart->reducing($prod, $uniqueKey, $size_qty, $size_price);

        // Persist cart
        Session::put('cart', $cart);

        return response()->json([
            'total_price' => PriceHelper::showCurrencyPrice($cart->totalPrice * $curr->value),
            'qty'         =>  $cart->items[$uniqueKey]['qty'],
            'item_price'  => PriceHelper::showCurrencyPrice($cart->items[$uniqueKey]['price'] * $curr->value),
            'sub_total'   => PriceHelper::showCurrencyPrice($cart->totalPrice * $curr->value),
            'discount'    => $cart->items[$uniqueKey]['discount'] == 0 ? '' : '(' . $cart->items[$uniqueKey]['discount'] . '% Off)'
        ]);
    }

    public function removecart($id)
    {
        $curr = $this->curr;
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        Session::forget('cart');
        Session::forget('already');
        Session::forget('coupon');
        Session::forget('coupon_total');
        Session::forget('coupon_total1');
        Session::forget('coupon_percentage');
        Session::put('cart', $cart);
        if (count($cart->items) == 0) {
            Session::forget('cart');
        }

        return back()->with('success', __('Item has been removed from cart.'));
    }

    public function country_tax(Request $request)
    {

        if ($request->country_id) {
            if ($request->state_id != 0) {
                $state = State::findOrFail($request->state_id);
                $tax = $state->tax;
                $data[11] = $state->id;
                $data[12] = 'state_tax';
            } else {
                $country = Country::findOrFail($request->country_id);
                $tax = $country->tax;
                $data[11] = $country->id;
                $data[12] = 'country_tax';
            }
        } else {
            $tax = 0;
        }

        $tax = $tax;
        Session::put('is_tax', $tax);
        $total = (float) preg_replace('/[^0-9\.]/ui', '', $_GET['total']);

        $stotal = ($total * $tax) / 100;

        $sstotal = $stotal * $this->curr->value;
        Session::put('current_tax', $sstotal);

        $total = $total + $stotal;

        $data[0] = $total;
        $data[1] = $tax;

        $data[0] = round($total, 2);

        if (Session::has('coupon')) {
            $data[0] = round($total - Session::get('coupon'), 2);
        }

        return response()->json($data);
    }

    //////////////////////Chnage///////////////////////////
}
