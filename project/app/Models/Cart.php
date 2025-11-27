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
    public function add($item, $id, $size, $color, $keys, $values, $finalPrice = null, $measureValue = '')
    {
        $finalPrice = is_null($finalPrice) ? (float) $item->price : (float) $finalPrice;

        $valuesKeyPart = str_replace(str_split(' ,'), '', (string) $values);

        $priceKey = number_format((float)$finalPrice, 2, '.', '');

        $uniqueKey = implode('_', [
            $id,
            $size ?? '',
            $color ?? '',
            $valuesKeyPart,
            $priceKey,
            str_replace(str_split(' ,'), '', (string)$measureValue)
        ]);

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
            'keys'        => $keys,
            'values'      => $values,
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
        $storedItem['qty'] = ($storedItem['qty'] ?? 0) + 1;

        // decrease stock (if stock is numeric)
        $stck = (string) ($item->stock ?? '');
        if ($stck !== null && $stck !== '') {
            // If stock is numeric, reduce by 1
            if (is_numeric($storedItem['stock'])) {
                $storedItem['stock'] = $storedItem['stock'] - 1;
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

    // ************** ADDING QUANTITY *****************

    public function addItem($item, $key, $size_qty, $size_price)
    {
        // If already in cart → Load it
        if (isset($this->items[$key])) {
            $storedItem = $this->items[$key];
        } else {
            // New cart line
            $storedItem = ['user_id' => $item->user_id, 'qty' => 0, 'size_key' => 0, 'size_qty' => $item->size_qty, 'size_price' => $item->size_price, 'size' => $item->size, 'color' => $item->color, 'stock' => $item->stock, 'price' => $item->price, 'item' => $item, 'license' => '', 'dp' => '0', 'keys' => '', 'values' => '', 'item_price' => $item->price, 'discount' => $item->discount, 'discount_type' => $item->discount_type, 'affilate_user' => 0];
        }

        // Increase qty
        $storedItem['qty']++;

        // Reduce stock
        if (!is_null($item->stock)) {
            $storedItem['stock']--;
        }

        // Final single item price (base + size_price)
        $finalPrice = $item->price + (float) $size_price;

        // Apply wholesale discount
        if (!empty($item->whole_sell_qty)) {
            foreach (array_combine($item->whole_sell_qty, $item->whole_sell_discount) as $q => $d) {
                if ($storedItem['qty'] == $q) {
                    $discountAmount = $finalPrice * ($d / 100);
                    $finalPrice -= $discountAmount;
                    $storedItem['discount'] = $d;
                }
            }
        }

        // Total price
        $storedItem['price'] = $finalPrice * $storedItem['qty'];

        // Store back
        $this->items[$key] = $storedItem;

        $this->recalculateTotals();
    }


    // ************** ADDING QUANTITY ENDS *****************

    // ************** REDUCING QUANTITY *****************

    public function reducing($item, $uniqueKey, $size_qty, $size_price)
    {
        // If item not in cart -> nothing to do
        if (!isset($this->items[$uniqueKey])) {
            return;
        }

        $storedItem = $this->items[$uniqueKey];

        // Prevent reducing below 1
        if ($storedItem['qty'] <= 1) {
            return;
        }

        // Decrease quantity
        $storedItem['qty']--;

        // Restore stock (if tracked)
        if (isset($storedItem['stock']) && is_numeric($storedItem['stock'])) {
            $storedItem['stock']++;
        }

        // base single price (product base + size cost)
        $finalPrice = $item->price + (float) $size_price;

        // Apply wholesale discount
        if (!empty($item->whole_sell_qty)) {
            foreach (array_combine($item->whole_sell_qty, $item->whole_sell_discount) as $q => $d) {
                if ($storedItem['qty'] == $q) {
                    $discountAmount = $finalPrice * ($d / 100);
                    $finalPrice -= $discountAmount;
                    $storedItem['discount'] = $d;
                }
            }
        }

        // Total price
        $storedItem['price'] = $finalPrice * $storedItem['qty'];

        // Store back
        $this->items[$uniqueKey] = $storedItem;

        $this->recalculateTotals();
    }


    // ************** REDUCING QUANTITY ENDS *****************

    public function MobileupdateLicense($id, $license)
    {
        $this->items[$id]['license'] = $license;
    }
    public function updateLicense($id, $license)
    {

        $this->items[$id]['license'] = $license;
    }

    public function updateColor($item, $id, $color)
    {

        $this->items[$id]['color'] = $color;
    }

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
