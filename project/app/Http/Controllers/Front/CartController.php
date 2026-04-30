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

    public function cartCheckout(Request $request)
    {
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
        $curr = $this->curr;
        $gateways = PaymentGateway::scopeHasGateway($this->curr->id);

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;
        $totalPrice = $cart->totalPrice;
        $mainTotal = $totalPrice;
        $totalQty = $cart->totalQty;

        return view('frontend.cart', compact('products', 'totalPrice', 'mainTotal', 'gateways', 'digital', 'totalQty'));
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
        $prod = Product::findOrFail($id);

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

        // Prepare cart instance from session
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart); // update namespace/path if needed

        $priceKey = number_format((float)$finalPrice, 2, '.', '');
        $uniqueKey = implode('_', [
            $prod->id,
            $priceKey,
            str_replace(str_split(' ,'), '', (string)$measureValue)
        ]);

        if ($cart->items != null && isset($cart->items[$uniqueKey]) && @$cart->items[$uniqueKey]['dp'] == 1) {
            return response()->json('digital');
        }

        // Add to cart (pass finalPrice & measureValue)
        $cart->add($prod, $prod->id, $finalPrice, $uniqueKey, $measureValue, $quantity);

        // Use the same uniqueKey to inspect the cart row

        // if ($cart->items[$uniqueKey]['stock'] < 0) {
        //     return response()->json(0);
        // }

        if (!empty($cart->items[$uniqueKey]['size_qty'])) {
            if ($cart->items[$uniqueKey]['qty'] > $cart->items[$uniqueKey]['size_qty']) {
                return response()->json(0);
            }
        }

        // Save back to session
        Session::put('cart', $cart);
        // $data[0] = count($cart->items);
        // $data[1] = $cart->totalPrice;
        // $data[2] = $uniqueKey;

        $offers = $this->getEligibleOffers($cart);

        return response()->json([
            'cart_count' => count($cart->items),
            'total_price' => $cart->totalPrice,
            'unique_key' => $uniqueKey,
            'offers' => $offers
        ]);
    }

    public function increment(Request $request)
    {
        $cart = Session::get('cart');
        foreach ($cart->items as $key => $row) {
            if ($row['unique_key'] == $request->unique_key) {

                $cart->items[$key]['qty'] += 1;
                $cart->items[$key]['price'] =
                    $cart->items[$key]['qty'] * $cart->items[$key]['item_price'];

                $cart->recalculateTotals();
                Session::put('cart', $cart);

                $offers = $this->getEligibleOffers($cart);

                return response()->json([
                    'cart_count' => count($cart->items),
                    'total_price' => $cart->totalPrice,
                    'qty' => $cart->items[$key]['qty'],
                   // 'product_id' => $row['item']['id'],
                    'offers' => $offers
                ]);
            }
        }
    }

    public function decrement(Request $request)
    {
        $cart = Session::get('cart');
        foreach ($cart->items as $key => $row) {
            if ($row['unique_key'] == $request->unique_key) {

                $productId = $row['item']['id']; // Needed for JS

                // Reduce qty
                $cart->items[$key]['qty'] -= 1;

                // If qty = 0 → remove item
                if ($cart->items[$key]['qty'] <= 0) {
                    unset($cart->items[$key]);
                    $updatedQty = 0;
                } else {
                    $cart->items[$key]['price'] =
                        $cart->items[$key]['qty'] * $cart->items[$key]['item_price'];

                    $updatedQty = $cart->items[$key]['qty'];
                }

                // Recalculate totals
                $cart->recalculateTotals();
                Session::put('cart', $cart);
                $offers = $this->getEligibleOffers($cart);

                return response()->json([
                    'cart_count' => count($cart->items),
                    'total_price' => $cart->totalPrice,
                    'qty' => $updatedQty,
                    'product_id' => $productId,
                    'offers' => $offers
                ]);
            }
        }
    }


    public function cartRemove(Request $request)
    {
        $key = $request->unique_key;

        $cart = new Cart(Session::get('cart'));
        $cart->removeItem($key);

        Session::put('cart', $cart);

        $offers = $this->getEligibleOffers($cart);

        return response()->json([
            'status' => true,
            'html'   => view('includes.frontend.offcanvas-cart')->with([
                'cartItems' => $cart->items
            ])->render(),
            'count'  => count($cart->items),
            'total'  => $cart->totalPrice,
            'offers' => $offers
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

    private function getEligibleOffers($cart)
    {
        $offers = \DB::table('conditional_offers')->get();

        $eligibleProducts = [];

        // ✅ cart total (offer ছাড়া)
        $cartTotal = collect($cart->items)
            ->where('is_offer', '!=', true)
            ->sum('price');

        // ✅ cart sku list
        $cartSkus = collect($cart->items)
            ->pluck('item.sku')
            ->toArray();

        foreach ($offers as $offer) {

            $offerProducts = json_decode($offer->offer_products, true);
            $excludeSkus = json_decode($offer->exclude_product, true);

            // 🔴 exclude check
            if (!empty($excludeSkus) && array_intersect($cartSkus, $excludeSkus)) {
                continue;
            }

            foreach ($offerProducts as $op) {

                $amount = (float) $op['amount'];
                $sku = $op['sku'];

                // ✅ amount match
                if ($cartTotal >= $amount) {

                    $product = Product::where('sku', $sku)->first();

                    if (!$product) continue;

                    $eligibleProducts[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku,
                        'price' => $product->price, // or fixed?
                        'offer_price' => 0, // তুমি চাইলে 1tk / 2tk logic add করতে পারো
                        'image' => $product->photo,
                        'amount' => $amount
                    ];
                }
            }
        }

        // 🔥 duplicate remove (same SKU multiple বার আসতে পারে)
        $eligibleProducts = collect($eligibleProducts)
            ->unique('sku')
            ->values()
            ->toArray();

        return $eligibleProducts;
    }

    //////////////////////Chnage///////////////////////////
}
