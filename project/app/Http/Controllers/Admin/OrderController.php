<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Helpers\PriceHelper;
use App\Models\AffliateBonus;
use App\Models\Branch;
use App\Models\Cart;
use App\Models\Category;
use App\Models\DeliveryRider;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Package;

use App\Models\Product;
use App\Models\Rider;
use App\Models\RiderServiceArea;
use App\Models\Shipping;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class OrderController extends AdminBaseController
{
    //*** GET Request
    public function orders(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $branchs = Branch::where('status', 1)->get();

        if ($request->status == 'pending') {
            return view('admin.order.pending', compact('categories', 'branchs'));
        } else if ($request->status == 'hold') {
            return view('admin.order.hold', compact('categories', 'branchs'));
        } else if ($request->status == 'processing') {
            return view('admin.order.processing', compact('categories', 'branchs'));
        } else if ($request->status == 'completed') {
            return view('admin.order.completed', compact('categories', 'branchs'));
        } else if ($request->status == 'cancelled') {
            return view('admin.order.cancelled', compact('categories', 'branchs'));
        } else if ($request->status == 'today-orders') {
            return view('admin.order.today_orders', compact('categories', 'branchs'));
        } else {
            return view('admin.order.index', compact('categories', 'branchs'));
        }
    }

    public function datatables($status)
    {
        if (auth()->user()->role_id != 0) {
            if ($status == 'pending') {
                $datas = Order::where('status', '=', 'pending')->where('branch_id', auth()->user()->branch_id)->latest('id')->get();
            } elseif ($status == 'hold') {
                $datas = Order::where('status', '=', 'hold')->where('branch_id', auth()->user()->branch_id)->latest('id')->get();
            } elseif ($status == 'processing') {
                $datas = Order::where('status', '=', 'processing')->where('branch_id', auth()->user()->branch_id)->latest('id')->get();
            } elseif ($status == 'completed') {
                $datas = Order::where('status', '=', 'completed')->where('branch_id', auth()->user()->branch_id)->latest('id')->get();
            } elseif ($status == 'cancelled') {
                $datas = Order::where('status', '=', 'cancelled')->where('branch_id', auth()->user()->branch_id)->latest('id')->get();
            } elseif ($status == 'today-orders') {
                $from = date('Y-m-d') . " 00:00:00";
                $to   = date('Y-m-d') . " 23:59:59";
                $datas = Order::whereBetween('created_at', [$from, $to])->where('branch_id', auth()->user()->branch_id)->latest('id')->get();
            } else {
                $datas = Order::where('branch_id', auth()->user()->branch_id)->latest('id')->get();
            }
        } else {
            if ($status == 'pending') {
                $datas = Order::where('status', '=', 'pending')->latest('id')->get();
            } elseif ($status == 'hold') {
                $datas = Order::where('status', '=', 'hold')->latest('id')->get();
            } elseif ($status == 'processing') {
                $datas = Order::where('status', '=', 'processing')->latest('id')->get();
            } elseif ($status == 'completed') {
                $datas = Order::where('status', '=', 'completed')->latest('id')->get();
            } elseif ($status == 'cancelled') {
                $datas = Order::where('status', '=', 'cancelled')->latest('id')->get();
            } elseif ($status == 'today-orders') {
                $from = date('Y-m-d') . " 00:00:00";
                $to   = date('Y-m-d') . " 23:59:59";
                $datas = Order::whereBetween('created_at', [$from, $to])->where('branch_id', auth()->user()->branch_id)
                    ->where('status', 'pending')->latest('id')->get();
            } else {
                $datas = Order::latest()->get();
            }
        }

        //--- Integrating This Collection Into Datatables
        return DataTables::of($datas)
            ->editColumn('customer_address', function (Order $data) {
                return Str::limit($data->customer_address, 30, '...');
            })
            ->editColumn('date', function (Order $data) {
                $date = \Carbon\Carbon::parse($data->created_at)->format('d M Y');
                $time = \Carbon\Carbon::parse($data->created_at)->format('h:i A');
                return $date . '<br><small>' . $time . '</small>';
            })
            ->editColumn('branch', function (Order $data) {
                if ($data->branch_id) {
                    return '<a href="javascript:;" class="select-branch badge badge-success"
                data-id="' . $data->id . '"
                data-toggle="modal"
                data-target="#branchModal">' . $data->branch->name . '</a>';
                }
                return '<a href="javascript:;" class="select-branch btn btn-sm btn-primary"
                data-id="' . $data->id . '"
                data-toggle="modal"
                data-target="#branchModal">' . __('Add') . '</a>';
            })
            ->editColumn('id', function (Order $data) {
                $id = '<a href="' . route('admin-order-invoice', $data->id) . '">' . $data->order_number . '</a>';
                $viewbtn = '<a href="' . route('admin-order-show', $data->id) . '" class="btn btn-sm btn-primary">Details</a>';
                return $id . $viewbtn;
            })
            ->editColumn('pay_amount', function (Order $data) {
                return PriceHelper::showOrderCurrencyPrice((($data->pay_amount + $data->wallet_price) * $data->currency_value), $data->currency_sign);
            })
            ->editColumn('status', function (Order $data) {
                if ($data->status == 'completed') {
                    $badge = 'success';
                    $source = __('Completed');
                } elseif ($data->status == 'pending') {
                    $badge = 'warning';
                    $source = __('Pending');
                } elseif ($data->status == 'hold') {
                    $badge = 'secondary';
                    $source = __('Hold');
                } elseif ($data->status == 'processing') {
                    $badge = 'info';
                    $source = __('Processing');
                } elseif ($data->status == 'on delivery') {
                    $badge = 'primary';
                    $source = __('On Delivery');
                } elseif ($data->status == 'cancelled') {
                    $badge = 'danger';
                    $source = __('Cancelled');
                } else {
                    $badge = 'dark';
                    $source = __('Unknown');
                }
                return '<span class="badge badge-' . $badge . '">' . $source . '</span>';
            })
            ->editColumn('custom_note', function (Order $data) {
                if ($data->tracks->isNotEmpty()) {
                    $note = e(optional($data->tracks->last())->text);
                    return "
            <button
                style='font-size: 13px;'
                class='btn btn-info btn-sm note-view-btn d-inline-block'
                data-note='{$note}'
            >
                <i class='fa fa-eye'></i> View
            </button>
        ";
                }
                return 'N/A';
            })
            ->editColumn('customer_name', function (Order $data) {
                return $data->customer_name . ' || ' . $data->customer_phone;
            })

            ->editColumn('order_source', function (Order $data) {
                if ($data->order_source == 'Website') {
                    $badge = 'primary';
                    $source = __('Web');
                } elseif ($data->order_source == 'Mobile Apps') {
                    $badge = 'success';
                    $source = __('App');
                } elseif ($data->order_source == 'POS') {
                    $badge = 'info';
                    $source = __('POS');
                } else {
                    $badge = 'dark';
                    $source = __('Unknown');
                }
                return '<span class="badge badge-' . $badge . '">' . $source . '</span>';
            })
            ->addColumn('action', function (Order $data) {
                $orders = '<a href="javascript:;" data-href="' . route('admin-order-edit', $data->id) . '" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> ' . __('Delivery Status') . '</a>';
                $deleteBtn = '<a href="javascript:;"
        class="delete-order"
        data-href="' . route('admin-order-delete', $data->id) . '">
        <i class="fas fa-trash"></i> ' . __('Delete') . '</a>';

                return '<div class="godropdown"><button class="go-dropdown-toggle">' . __('Actions') . '</button><div class="action-list"><a href="' . route('admin-order-show', $data->id) . '" > <i class="fas fa-eye"></i> ' . __('View Details') . '</a><a href="javascript:;" class="send" data-email="' . $data->customer_email . '" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> ' . __('Send') . '</a><a href="javascript:;" data-href="' . route('admin-order-track', $data->id) . '" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> ' . __('Track Order') . '</a>' . $orders . $deleteBtn . '</div></div>';
            })
            ->rawColumns(['date', 'branch', 'customer_address', 'id', 'status', 'custom_note', 'customer_name', 'order_source', 'action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function assignBranch(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->branch_id = $request->branch_id;
        $order->save();

        return response()->json(['message' => 'Branch assigned successfully.']);
    }

    public function orderDelete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        $msg = __('Order Deleted Successfully.');
        return response()->json(['message' => $msg]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);
        if (!$cart) {
            $cart = [
                'totalQty' => 0,
                'totalPrice' => 0,
                'items' => []
            ];
        }
        if (!empty($cart['items'])) {
            foreach ($cart['items'] as $key => $item) {
                if (!isset($cart['items'][$key]['item'])) {
                    $cart['items'][$key]['item'] = [
                        'id' => $item['id'] ?? null,
                        'slug' => $item['slug'] ?? null,
                        'name' => $item['name'] ?? 'Unnamed Product',
                        'sku' => $item['sku'] ?? '',
                        'photo' => $item['photo'] ?? null,
                    ];
                }
            }
        }
        return view('admin.order.details', compact('order', 'cart'));
    }
    // Add Multiple Product In order Details page Start
    public function productSearch(Request $request)
    {
        $products = Product::where('name', 'LIKE', "%{$request->keyword}%")
            ->orWhere('sku', 'LIKE', "%{$request->keyword}%")
            ->limit(10)
            ->get();

        return response()->json($products);
    }
    public function addProduct(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $product = Product::findOrFail($request->product_id);

        $cart = json_decode($order->cart, true);

        if (!$cart) {
            $cart = [
                'totalQty' => 0,
                'totalPrice' => 0,
                'items' => []
            ];
        }

        $productId = (string) $product->id;
        $productPrice = (float) ($product->price ?? 0);
        $productDiscount = (float) ($product->discount ?? 0);
        $discountType = $product->discount_type ?? null;

        $unitDiscount = 0;
        if ($productDiscount > 0) {
            if ($discountType === 'percent') {
                $unitDiscount = ($productPrice * $productDiscount) / 100;
            } else {
                $unitDiscount = $productDiscount;
            }
        }

        // exact product id key exists?
        if (isset($cart['items'][$productId])) {
            $cart['items'][$productId]['qty'] += 1;

            $qty = (int) $cart['items'][$productId]['qty'];
            $cart['items'][$productId]['item_price'] = $productPrice;
            $cart['items'][$productId]['unit_discount'] = $unitDiscount;
            $cart['items'][$productId]['discount'] = $unitDiscount * $qty;
            $cart['items'][$productId]['price'] = ($productPrice * $qty) - ($unitDiscount * $qty);

            if (!isset($cart['items'][$productId]['item']) || !is_array($cart['items'][$productId]['item'])) {
                $cart['items'][$productId]['item'] = [];
            }

            $cart['items'][$productId]['item']['id'] = $product->id;
            $cart['items'][$productId]['item']['user_id'] = $product->user_id ?? 0;
            $cart['items'][$productId]['item']['slug'] = $product->slug;
            $cart['items'][$productId]['item']['name'] = $product->name;
            $cart['items'][$productId]['item']['sku'] = $product->sku;
            $cart['items'][$productId]['item']['photo'] = $product->photo;
            $cart['items'][$productId]['item']['price'] = $productPrice;
            $cart['items'][$productId]['item']['discount'] = $productDiscount;
            $cart['items'][$productId]['item']['discount_type'] = $discountType;
            $cart['items'][$productId]['item']['stock'] = $product->stock;
            $cart['items'][$productId]['item']['type'] = $product->type ?? 'Physical';
            $cart['items'][$productId]['item']['stock_check'] = $product->stock_check ?? 0;
        } else {
            $cart['items'][$productId] = [
                'user_id' => $product->user_id ?? 0,
                'qty' => 1,
                'stock' => $product->stock,
                'price' => $productPrice - $unitDiscount,
                'item' => [
                    'id' => $product->id,
                    'user_id' => $product->user_id ?? 0,
                    'slug' => $product->slug,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'photo' => $product->photo,
                    'price' => $productPrice,
                    'discount' => $productDiscount,
                    'discount_type' => $discountType,
                    'stock' => $product->stock,
                    'type' => $product->type ?? 'Physical',
                    'stock_check' => $product->stock_check ?? 0,
                ],
                'license' => '',
                'dp' => '0',
                'keys' => '',
                'values' => '',
                'item_price' => $productPrice,
                'unit_discount' => $unitDiscount,
                'discount' => $unitDiscount,
            ];
        }

        $this->recalculateOrderCart($order, $cart);

        $cart = json_decode($order->cart, true);
        $html = view('admin.order.partials.order_items', compact('order', 'cart'))->render();

        return response()->json([
            'status' => true,
            'message' => 'Product added successfully',
            'html' => $html
        ]);
    }
    public function removeProduct(Request $request, $id, $productId = null)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);

        if (!$cart || !isset($cart['items']) || !is_array($cart['items'])) {
            return response()->json([
                'status' => false,
                'message' => 'Cart is empty'
            ], 404);
        }

        $cartKey = trim((string) $request->cart_key);

        if (!$cartKey || !array_key_exists($cartKey, $cart['items'])) {
            $requestProductId = trim((string) ($productId ?? $request->product_id));

            foreach ($cart['items'] as $key => $item) {
                $keyProductId = explode('_', (string) $key)[0];

                if ((string) $keyProductId === $requestProductId) {
                    $cartKey = $key;
                    break;
                }
            }
        }

        if (!$cartKey || !array_key_exists($cartKey, $cart['items'])) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found in cart'
            ], 404);
        }

        unset($cart['items'][$cartKey]);

        $this->recalculateOrderCart($order, $cart);

        $cart = json_decode($order->cart, true);
        $html = view('admin.order.partials.order_items', compact('order', 'cart'))->render();

        return response()->json([
            'status' => true,
            'message' => 'Product removed successfully',
            'html' => $html
        ]);
    }
    public function updateProductQty(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);

        if (!$cart || !isset($cart['items']) || !is_array($cart['items'])) {
            return response()->json([
                'status' => false,
                'message' => 'Cart is empty'
            ], 404);
        }

        $cartKey = trim((string) $request->cart_key);

        // fallback old call support
        if (!$cartKey || !array_key_exists($cartKey, $cart['items'])) {
            $productId = trim((string) $request->product_id);

            foreach ($cart['items'] as $key => $item) {
                $keyProductId = explode('_', (string) $key)[0];

                if ((string) $keyProductId === $productId) {
                    $cartKey = $key;
                    break;
                }
            }
        }

        if (!$cartKey || !array_key_exists($cartKey, $cart['items'])) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found in cart',
                'debug' => [
                    'request_cart_key' => $request->cart_key,
                    'request_product_id' => $request->product_id,
                    'cart_item_keys' => array_keys($cart['items'] ?? [])
                ]
            ], 404);
        }

        $qty = (int) $request->qty;
        $item = $cart['items'][$cartKey];

        $itemPrice = (float) ($item['item_price'] ?? (($item['item']['price'] ?? $item['price']) ?? 0));
        $oldQty = (int) ($item['qty'] ?? 1);

        // safest discount logic
        if (isset($item['unit_discount'])) {
            $unitDiscount = (float) $item['unit_discount'];
        } else {
            $oldTotalDiscount = (float) ($item['discount'] ?? 0);
            $unitDiscount = $oldQty > 0 ? ($oldTotalDiscount / $oldQty) : 0;
        }

        $cart['items'][$cartKey]['item_price'] = $itemPrice;
        $cart['items'][$cartKey]['qty'] = $qty;
        $cart['items'][$cartKey]['unit_discount'] = $unitDiscount;
        $cart['items'][$cartKey]['discount'] = $unitDiscount * $qty;
        $cart['items'][$cartKey]['price'] = ($itemPrice * $qty) - ($unitDiscount * $qty);

        $this->recalculateOrderCart($order, $cart);

        $cart = json_decode($order->cart, true);
        $html = view('admin.order.partials.order_items', compact('order', 'cart'))->render();

        return response()->json([
            'status' => true,
            'message' => 'Quantity updated successfully',
            'html' => $html
        ]);
    }
    private function recalculateOrderCart($order, array $cart)
    {
        $totalQty = 0;
        $subTotal = 0;

        if (!isset($cart['items']) || !is_array($cart['items'])) {
            $cart['items'] = [];
        }

        foreach ($cart['items'] as $cartKey => $item) {
            $qty = (int) ($item['qty'] ?? 0);
            $itemPrice = (float) ($item['item_price'] ?? (($item['item']['price'] ?? $item['price']) ?? 0));

            if (isset($item['unit_discount'])) {
                $unitDiscount = (float) $item['unit_discount'];
            } else {
                $existingDiscount = (float) ($item['discount'] ?? 0);
                $oldQty = $qty > 0 ? $qty : 1;
                $unitDiscount = $oldQty > 0 ? ($existingDiscount / $oldQty) : 0;
            }

            $lineDiscount = $unitDiscount * $qty;
            $lineTotal = ($itemPrice * $qty) - $lineDiscount;

            $cart['items'][$cartKey]['item_price'] = $itemPrice;
            $cart['items'][$cartKey]['unit_discount'] = $unitDiscount;
            $cart['items'][$cartKey]['discount'] = $lineDiscount;
            $cart['items'][$cartKey]['price'] = $lineTotal;

            $totalQty += $qty;
            $subTotal += $lineTotal;
        }

        $cart['totalQty'] = $totalQty;
        $cart['totalPrice'] = $subTotal;

        $shippingCost = (float) ($order->shipping_cost ?? 0);
        $packingCost = (float) ($order->packing_cost ?? 0);
        $tax = (float) ($order->tax ?? 0);
        $couponDiscount = (float) ($order->coupon_discount ?? 0);
        $orderDiscount = (float) ($order->discount ?? 0);

        $grandTotal = $subTotal + $shippingCost + $packingCost + $tax - $couponDiscount - $orderDiscount;

        $order->cart = json_encode($cart);
        $order->totalQty = $totalQty;
        $order->pay_amount = $grandTotal;
        $order->save();
    }
    public function multipleOrderNote(Request $request)
    {

        $order = Order::findOrFail($request->id);

        // existing notes
        $existingNotes = json_decode($order->multiple_note, true) ?? [];

        // new notes with date & time
        $newNotes = [];

        foreach ($request->multiple_note as $note) {
            $newNotes[] = [
                'note' => $note,
                'time' => now()->format('d M Y h:i A'),
                'user' => auth('admin')->user()->name
            ];
        }

        // merge old + new
        $mergedNotes = array_merge($existingNotes, $newNotes);

        // save as json
        $order->multiple_note = json_encode($mergedNotes);
        $order->save();

        return response()->json([
            'status' => true,
            'note' => end($newNotes)
        ]);
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);
        return view('admin.order.invoice', compact('order', 'cart'));
    }

    public function emailsub(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        if ($gs->is_smtp == 1) {
            $data = [
                'to' => $request->to,
                'subject' => $request->subject,
                'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);
        } else {
            $data = 0;
            $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
            $mail = mail($request->to, $request->subject, $request->message, $headers);
            if ($mail) {
                $data = 1;
            }
        }

        return response()->json($data);
    }

    public function printpage($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);
        return view('admin.order.print', compact('order', 'cart'));
    }

    public function license(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);
        $cart['items'][$request->license_key]['license'] = $request->license;
        $new_cart = json_encode($cart);
        $order->cart = $new_cart;
        $order->update();
        $msg = __('Successfully Changed The License Key.');
        return redirect()->back()->with('license', $msg);
    }

    public function edit($id)
    {
        $data = Order::find($id);
        return view('admin.order.delivery', compact('data'));
    }

    //*** POST Request
    // public function update(Request $request, $id)
    // {

    //     $data = Order::findOrFail($id);
    //     $input = $request->all();


    //     if ($request->has('status')) {
    //         $data->payment_status = $input['payment_status'];
    //         $data->status = $input['status'];
    //         if ($input['status'] == 'cancelled') {
    //             if ($data->user) {
    //                 $data->user->decrement('wallet_points', $data->loyalty_point);
    //             }
    //         }

    //         if ($input['status'] == 'completed') {
    //             if ($data->user) {
    //                 $data->user->increment('wallet_points', $data->loyalty_point);
    //             }
    //         }
    //         $data->update();

    //         if ($request->track_text) {
    //             $title = ucwords($request->status);
    //             $ck = OrderTrack::where('order_id', '=', $id)->where('title', '=', $title)->first();
    //             if ($ck) {
    //                 $ck->order_id = $id;
    //                 $ck->title = $title;
    //                 $ck->text = $request->track_text;
    //                 $ck->update();
    //             } else {
    //                 $data = new OrderTrack;
    //                 $data->order_id = $id;
    //                 $data->title = $title;
    //                 $data->text = $request->track_text;
    //                 $data->save();
    //             }
    //         }
    //         $msg = __('Status Updated Successfully.');
    //         return response()->json($msg);
    //     }


    //     $data->update($input);
    //     $msg = __('Data Updated Successfully.');
    //     return redirect()->back()->with('success', $msg);
    // }
    public function update(Request $request, $id)
    {
        //--- Logic Section
        $data = Order::findOrFail($id);
        $input = $request->all();

        if ($request->has('status')) {
            $data->payment_status = $input['payment_status'];
            $data->status = $input['status'];

            // ✅ Fix: Ensure loyalty_point is a valid numeric value
            $loyaltyPoint = (int) ($data->loyalty_point ?? 0);

            if ($input['status'] == 'cancelled') {
                if ($data->user && $loyaltyPoint > 0) {
                    $data->user->decrement('wallet_points', $loyaltyPoint);
                }
            }

            if ($input['status'] == 'completed') {
                if ($data->user && $loyaltyPoint > 0) {
                    $data->user->increment('wallet_points', $loyaltyPoint);
                }
            }

            $data->update();

            if ($request->track_text) {
                $title = ucwords($request->status);
                $ck = OrderTrack::where('order_id', '=', $id)->where('title', '=', $title)->first();
                if ($ck) {
                    $ck->order_id = $id;
                    $ck->title = $title;
                    $ck->text = $request->track_text;
                    $ck->update();
                } else {
                    $track = new OrderTrack;  // ✅ Also fixed: was reusing $data variable
                    $track->order_id = $id;
                    $track->title = $title;
                    $track->text = $request->track_text;
                    $track->save();
                }
            }

            $msg = __('Status Updated Successfully.');
            return response()->json($msg);
        }

        $data->update($input);
        $msg = __('Data Updated Successfully.');
        return redirect()->back()->with('success', $msg);
    }
}
