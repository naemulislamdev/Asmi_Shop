<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart = null)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        } else {
            $this->items = [];
            $this->totalQty = 0;
            $this->totalPrice = 0;
        }
    }

    // ************** ADD TO CART *****************
    public function add($item, $id, $finalPrice = null, $uniqueKey, $measureValue = '', $quantity)
    {
        $finalPrice = is_null($finalPrice) ? (float) $item->price : (float) $finalPrice;

        // Default stored item structure
        $storedItem = [
            'user_id'     => $item->user_id ?? 0,
            'qty'         => 0,
            'size_key'    => 0,
            'size_qty'    => $item->size_qty ?? null,
            'size_price'  => $item->size_price ?? null,
            'size'        => $item->size ?? null,
            'color'       => $item->color ?? null,
            'stock'       => $item->stock ?? null,
            'price'       => $finalPrice, // total price for this line (will be item_price * qty)
            'item'        => $item,
            'license'     => '',
            'dp'          => '0',
            'item_price'  => $finalPrice, // unit price
            'discount'    => $item->discount ?? 0,
            'discount_type' => $item->discount_type ?? null,
            'affilate_user' => 0,
            'measure_value' => $measureValue,
            'unique_key'  => $uniqueKey,
        ];

        // If same uniqueKey already exists, use it (increase qty) otherwise keep default
        if ($this->items && array_key_exists($uniqueKey, $this->items)) {
            $storedItem = $this->items[$uniqueKey];
        }

        // increase quantity

        $storedItem['qty'] = ($storedItem['qty'] ?? 0) + $quantity;

        // decrease stock (if stock is numeric)
        $stck = (string) ($item->stock ?? '');
        if ($stck !== null && $stck !== '') {
            // If stock is numeric, reduce by 1
            if (is_numeric($storedItem['stock'])) {
                $storedItem['stock'] = $storedItem['stock'] - $quantity;
            }
        }

        // handle size selection overrides
        if (!empty($item->size)) {
            $storedItem['size'] = is_array($item->size) ? ($item->size[0] ?? $storedItem['size']) : $item->size;
        }
        if (!empty($size)) {
            $storedItem['size'] = $size;
        }

        if (!empty($item->size_qty)) {
            $storedItem['size_qty'] = is_array($item->size_qty) ? ($item->size_qty[0] ?? $storedItem['size_qty']) : $item->size_qty;
        }

        // size_price may affect item_price
        $size_cost = 0;
        if (!empty($item->size_price)) {
            $storedItem['size_price'] = is_array($item->size_price) ? ($item->size_price[0] ?? $item->size_price) : $item->size_price;
            $size_cost = (float) $storedItem['size_price'];
        }

        // apply size cost to unit price
        $storedItem['item_price'] = (float)$finalPrice + $size_cost;

        // If whole sell discounts exist and session has matching data, apply their effects (preserve your existing behavior)
        if (!empty($item->whole_sell_qty) && !empty($item->whole_sell_discount)) {
            foreach (array_combine($item->whole_sell_qty, $item->whole_sell_discount) as $whole_qty => $whole_discount) {
                if ($storedItem['qty'] == $whole_qty) {
                    // store current discounts in session (your existing behavior)
                    $whole_discount_map[$uniqueKey] = $whole_discount;
                    Session::put('current_discount', $whole_discount_map ?? []);
                    $storedItem['discount'] = $whole_discount;
                    break;
                }
            }

            if (Session::has('current_discount')) {
                $data = Session::get('current_discount');
                if (array_key_exists($uniqueKey, $data)) {
                    $discountPercent = $data[$uniqueKey];
                    $discountAmount = $storedItem['item_price'] * ($discountPercent / 100);
                    $storedItem['item_price'] = $storedItem['item_price'] - $discountAmount;
                }
            }
        }

        // final line price = unit price * qty
        $storedItem['price'] = $storedItem['item_price'] * $storedItem['qty'];

        // persist back into items using uniqueKey
        $this->items[$uniqueKey] = $storedItem;

        // recalculate totals (totalQty and totalPrice)
        $this->recalculateTotals();
    }

    /**
     * Recalculate totalQty and totalPrice based on $this->items
     */
    public function recalculateTotals()
    {
        $this->totalQty = 0;
        $this->totalPrice = 0.0;

        if (!empty($this->items) && is_array($this->items)) {
            foreach ($this->items as $key => $it) {
                $this->totalQty += (int) ($it['qty'] ?? 0);
                $this->totalPrice += (float) ($it['price'] ?? 0);
            }
        }

        // store totals to session-friendly fields too
        $this->totalPrice = round($this->totalPrice, 2);
    }

    // ************** ADD TO CART MULTIPLE ENDS *****************

    public function addnum($item, $id, $qty, $size, $color, $size_qty, $size_price, $size_key, $keys, $values, $affilate_user)
    {
        $size_cost = 0;
        $color_cost = 0;

        $storedItem = ['user_id' => $item->user_id, 'qty' => 0, 'size_key' => 0, 'size_qty' => $item->size_qty, 'size_price' => $item->size_price, 'size' => $item->size, 'color' => $item->color, 'stock' => $item->stock, 'price' => $item->price, 'item' => $item, 'license' => '', 'dp' => '0', 'keys' => $keys, 'values' => $values, 'item_price' => $item->price, 'discount' => 0, 'affilate_user' => 0];
        if ($item->type == 'Physical') {
            if ($this->items) {
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $this->items)) {
                    $storedItem = $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)];
                }
            }
        } else {
            if ($this->items) {
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $this->items)) {
                    $storedItem = $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)];
                }
            }
            $storedItem['dp'] = 1;
        }
        $storedItem['affilate_user'] = $affilate_user;
        if (Auth::guard('admin')->check()) {
            $storedItem['qty'] = $qty;
        } else {
            $storedItem['qty'] = $storedItem['qty'] + $qty;
        }
        $stck = (string) $item->stock;
        if ($stck != null) {
            $storedItem['stock'] = $storedItem['stock'] - $qty;
        }
        if (!empty($item->size)) {
            $storedItem['size'] = $item->size[0];
        }
        if (!empty($size)) {
            $storedItem['size'] = $size;
        }
        if (!empty($size_key)) {
            $storedItem['size_key'] = $size_key;
        }
        if (!empty($item->size_qty)) {
            $storedItem['size_qty'] = $item->size_qty[0];
        }
        if (!empty($size_qty)) {
            $storedItem['size_qty'] = $size_qty;
        }


        if (!empty($item->size_price)) {
            $storedItem['size_price'] = $item->size_price[0];
            $size_cost = $item->size_price[0];
        }
        if (!empty($size_price)) {
            $storedItem['size_price'] = $size_price;
            $size_cost = $size_price;
        }

        if (!empty($item->color_price)) {
            $storedItem['color_price'] = $item->color_price[0];
            $color_cost = $item->color_price[0];
        }
        if (!empty($color_price)) {
            $storedItem['color_price'] = $color_price;
            $color_cost = $color_price;
        }


        if (!empty($item->color)) {
            $storedItem['color'] = $item->color[0];
        }
        if (!empty($color)) {
            $storedItem['color'] = $color;
        }
        if (!empty($keys)) {
            $storedItem['keys'] = $keys;
        }
        if (!empty($values)) {
            $storedItem['values'] = $values;
        }



        $item->price += $size_cost;
        $item->price += $color_cost;
        $storedItem['item_price'] = $item->price;
        if (!empty($item->whole_sell_qty)) {
            foreach ($item->whole_sell_qty as $key => $data) {
                if (($key + 1) != count($item->whole_sell_qty)) {
                    if (($storedItem['qty'] >= $item->whole_sell_qty[$key]) && ($storedItem['qty'] < $item->whole_sell_qty[$key + 1])) {
                        $whole_discount[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $item->whole_sell_discount[$key];
                        Session::put('current_discount', $whole_discount);
                        $storedItem['discount'] = $item->whole_sell_discount[$key];
                        break;
                    }
                } else {
                    if (($storedItem['qty'] >= $item->whole_sell_qty[$key])) {
                        $whole_discount[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $item->whole_sell_discount[$key];
                        Session::put('current_discount', $whole_discount);
                        $storedItem['discount'] = $item->whole_sell_discount[$key];
                        break;
                    }
                }
            }

            if (Session::has('current_discount')) {
                $data = Session::get('current_discount');
                if (array_key_exists($id . $size . $color . str_replace(str_split(' ,'), '', $values), $data)) {
                    $discount = $item->price * ($data[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] / 100);
                    $item->price = $item->price - $discount;
                }
            }
        }

        $storedItem['price'] = $item->price * $storedItem['qty'];
        //$this->recalculateTotals();


        $this->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $storedItem;
        $this->totalQty += $storedItem['qty'];
    }


    // ************** REDUCING QUANTITY ENDS *****************

    public function removeItem($id)
    {
        $this->totalQty -= (int) $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
        if (Session::has('current_discount')) {
            $data = Session::get('current_discount');
            if (array_key_exists($id, $data)) {
                unset($data[$id]);
                Session::put('current_discount', $data);
            }
        }
    }
}
