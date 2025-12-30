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
use Session;
use Yajra\DataTables\Facades\DataTables;

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
                return $id;
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

            ->editColumn('order_source', function (Order $data) {
                if ($data->order_source == 'Website') {
                    $badge = 'primary';
                    $source = __('Web');
                } elseif ($data->order_source == 'Mobile Apps') {
                    $badge = 'success';
                    $source = __('App');
                } else {
                    $badge = 'dark';
                    $source = __('Unknown');
                }
                return '<span class="badge badge-' . $badge . '">' . $source . '</span>';
            })
            ->addColumn('action', function (Order $data) {
                $orders = '<a href="javascript:;" data-href="' . route('admin-order-edit', $data->id) . '" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> ' . __('Delivery Status') . '</a>';
                return '<div class="godropdown"><button class="go-dropdown-toggle">' . __('Actions') . '</button><div class="action-list"><a href="' . route('admin-order-show', $data->id) . '" > <i class="fas fa-eye"></i> ' . __('View Details') . '</a><a href="javascript:;" class="send" data-email="' . $data->customer_email . '" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> ' . __('Send') . '</a><a href="javascript:;" data-href="' . route('admin-order-track', $data->id) . '" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> ' . __('Track Order') . '</a>' . $orders . '</div></div>';
            })
            ->rawColumns(['date', 'branch', 'id', 'status', 'custom_note', 'order_source', 'action'])
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

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $cart = json_decode($order->cart, true);
        return view('admin.order.details', compact('order', 'cart'));
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
    public function update(Request $request, $id)
    {
        // dd($request->all());
        //--- Logic Section
        $data = Order::findOrFail($id);

        $input = $request->all();

        if ($request->has('status')) {
            $data->payment_status = $input['payment_status'];
            $data->status = $input['status'];
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
                    $data = new OrderTrack;
                    $data->order_id = $id;
                    $data->title = $title;
                    $data->text = $request->track_text;
                    $data->save();
                }
            }
            $msg = __('Status Updated Successfully.');
            return response()->json($msg);
        }

        if ($request->has('status') == 'test') {
            if ($data->status == "completed") {
                $input['status'] = "completed";
                $data->update($input);
                $msg = __('Status Updated Successfully.');
                return response()->json($msg);
            } else {
                if ($input['status'] == "completed") {

                    if ($data->vendor_ids) {
                        $vendor_ids = json_decode($data->vendor_ids, true);

                        foreach ($vendor_ids as $vendor) {
                            $deliveryRider = DeliveryRider::where('order_id', $data->id)->where('vendor_id', $vendor)->first();
                            if ($deliveryRider) {
                                $rider = Rider::findOrFail($deliveryRider->rider_id);
                                $service_area = RiderServiceArea::findOrFail($deliveryRider->service_area_id);
                                $rider->balance += $service_area->price;
                                $rider->update();
                            }
                        }
                    }

                    foreach ($data->vendororders as $vorder) {
                        $uprice = User::find($vorder->user_id);
                        $uprice->current_balance = $uprice->current_balance + $vorder->price;
                        $vorder->status = 'completed';
                        $vorder->update();

                        $uprice->update();
                        $uprice->update();
                    }

                    if ($data->is_shipping == 1) {
                        $vendor_ids = json_decode($data->vendor_ids, true);
                        $shipping_ids = json_decode($data->vendor_shipping_id, true);
                        $packaging_ids = json_decode($data->vendor_packing_id, true);

                        foreach ($vendor_ids as $vendor) {
                            $vendor = User::findOrFail($vendor);
                            if ($vendor) {
                                $shpping_id = $shipping_ids[$vendor->id];
                                $packaging_id = $packaging_ids[$vendor->id];
                                $shipping = Shipping::findOrFail($shpping_id);
                                $packaging = Package::findOrFail($packaging_id);
                                $extra = 0;
                                if ($shipping) {
                                    $extra += $shipping->price;
                                }
                                if ($packaging) {
                                    $extra += $packaging->price;
                                }
                                $vendor->current_balance = $vendor->current_balance + $extra;
                                if ($data->method == 'Cash On Delivery') {
                                    $vendor->admin_commission += $extra;
                                }
                                $vendor->update();
                            }
                        }
                    }

                    if (User::where('id', $data->affilate_user)->exists()) {
                        $auser = User::where('id', $data->affilate_user)->first();
                        $auser->affilate_income += $data->affilate_charge;
                        $auser->update();

                        $affiliate_bonus = new AffliateBonus();
                        $affiliate_bonus->refer_id = $auser->id;
                        $affiliate_bonus->bonus = $data->affilate_charge;
                        $affiliate_bonus->type = 'Order';
                        $affiliate_bonus->user_id = $data->user_id;
                        $affiliate_bonus->created_at = Carbon::now();
                        $affiliate_bonus->customer_email = $data->customer_email;
                        $affiliate_bonus->save();
                    }

                    if ($data->affilate_users != null) {
                        $ausers = json_decode($data->affilate_users, true);
                        foreach ($ausers as $auser) {
                            $user = User::find($auser['user_id']);
                            if ($user) {
                                $user->affilate_income += $auser['charge'];
                                $user->update();
                            }
                        }
                    }

                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order ' . $data->order_number . ' is Confirmed!',
                        'body' => "Hello " . $data->customer_name . "," . "\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];

                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);
                }
                if ($input['status'] == "declined") {

                    // Refund User Wallet If Any
                    if ($data->user_id != 0) {
                        if ($data->wallet_price != 0) {
                            $user = User::find($data->user_id);
                            if ($user) {
                                $user->balance = $user->balance + $data->wallet_price;
                                $user->save();
                            }
                        }
                    }

                    $cart = json_decode($data->cart, true);

                    // Restore Product Stock If Any
                    foreach ($cart->items as $prod) {
                        $x = (string) $prod['stock'];
                        if ($x != null) {
                            $product = Product::findOrFail($prod['item']['id']);
                            $product->stock = $product->stock + $prod['qty'];
                            $product->update();
                        }
                    }

                    // Restore Product Size Qty If Any
                    foreach ($cart->items as $prod) {
                        $x = (string) $prod['size_qty'];
                        if (!empty($x)) {
                            $product = Product::findOrFail($prod['item']['id']);
                            $x = (int) $x;
                            $temp = $product->size_qty;
                            $temp[$prod['size_key']] = $x;
                            $temp1 = implode(',', $temp);
                            $product->size_qty = $temp1;
                            $product->update();
                        }
                    }

                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order ' . $data->order_number . ' is Declined!',
                        'body' => "Hello " . $data->customer_name . "," . "\n We are sorry for the inconvenience caused. We are looking forward to your next visit.",
                    ];
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);
                }

                $data->update($input);

                $msg = __('Status Updated Successfully.');
                return response()->json($msg);
            }
        }

        $data->update($input);
        $msg = __('Data Updated Successfully.');
        return redirect()->back()->with('success', $msg);
    }

    public function product_submit(Request $request)
    {

        $sku = $request->sku;
        $product = Product::whereUserId($request->vendor_id)->whereStatus(1)->where('sku', $sku)->first();
        $data = array();
        if (!$product) {
            $data[0] = false;
            $data[1] = __('No Product Found');
        } else {
            $data[0] = true;
            $data[1] = $product->id;
        }
        return response()->json($data);
    }

    public function product_show($id)
    {
        $data['productt'] = Product::find($id);
        $data['curr'] = $this->curr;
        return view('admin.order.add-product', $data);
    }

    public function addcart($id)
    {
        $order = Order::find($id);
        $id = $_GET['id'];
        $qty = $_GET['qty'];
        $size = str_replace(' ', '-', $_GET['size']);
        $color = $_GET['color'];
        $size_qty = $_GET['size_qty'];
        $size_price = (float) $_GET['size_price'];
        $size_key = $_GET['size_key'];
        $affilate_user = isset($_GET['affilate_user']) ? $_GET['affilate_user'] : '0';
        $keys = $_GET['keys'];
        $keys = explode(",", $keys);
        $values = $_GET['values'];
        $values = explode(",", $values);
        $prices = $_GET['prices'];
        $prices = explode(",", $prices);
        $keys = $keys == "" ? '' : implode(',', $keys);
        $values = $values == "" ? '' : implode(',', $values);
        $size_price = ($size_price / $order->currency_value);
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes', 'minimum_qty']);

        if ($prod->user_id != 0) {
            $prc = $prod->price + $this->gs->fixed_commission + ($prod->price / 100) * $this->gs->percentage_commission;
            $prod->price = round($prc, 2);
        }
        if (!empty($prices)) {
            if (!empty($prices[0])) {
                foreach ($prices as $data) {
                    $prod->price += ($data / $order->currency_value);
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
                return 0;
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
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        if (!empty($cart->items)) {
            if (!empty($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)])) {
                $minimum_qty = (int) $prod->minimum_qty;
                if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] < $minimum_qty) {
                    return redirect()->back()->with('unsuccess', __('Minimum Quantity is:') . ' ' . $prod->minimum_qty);
                }
            } else {
                if ($prod->minimum_qty != null) {
                    $minimum_qty = (int) $prod->minimum_qty;
                    if ($qty < $minimum_qty) {
                        return redirect()->back()->with('unsuccess', __('Minimum Quantity is:') . ' ' . $prod->minimum_qty);
                    }
                }
            }
        } else {
            $minimum_qty = (int) $prod->minimum_qty;
            if ($prod->minimum_qty != null) {
                if ($qty < $minimum_qty) {
                    return redirect()->back()->with('unsuccess', __('Minimum Quantity is:') . ' ' . $prod->minimum_qty);
                }
            }
        }
        $color_price = isset($request->color_price) ? (float) $_GET['color_price'] : 0;
        $cart->addnum($prod, $prod->id, $qty, $size, $color, $size_qty, $size_price, $color_price, $size_key, $keys, $values, $affilate_user);

        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['dp'] == 1) {
            return redirect()->back()->with('unsuccess', __('This item is already in the cart.'));
        }
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['stock'] < 0) {
            return redirect()->back()->with('unsuccess', __('Out Of Stock.'));
        }
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
            if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] > $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
                return redirect()->back()->with('unsuccess', __('Out Of Stock.'));
            }
        }

        $cart->totalPrice = 0;
        foreach ($cart->items as $data) {
            $cart->totalPrice += $data['price'];
        }

        $o_cart = json_decode($order->cart, true);

        $order->totalQty = $order->totalQty + $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'];
        $order->pay_amount = $order->pay_amount + $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['price'];

        $prev_qty = 0;
        $prev_price = 0;

        if (!empty($o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)])) {
            $prev_qty = $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'];
            $prev_price = $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['price'];
        }

        $prev_qty += $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'];
        $prev_price += $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['price'];

        $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)];
        $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] = $prev_qty;
        $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['price'] = $prev_price;

        $order->cart = json_encode($o_cart);

        $order->update();
        return redirect()->back()->with('success', __('Successfully Added To Cart.'));
    }

    public function product_edit($id, $itemid, $orderid)
    {

        $product = Product::find($itemid);

        $order = Order::find($orderid);
        $cart = json_decode($order->cart, true);
        $data['productt'] = $product;
        $data['item_id'] = $id;
        $data['prod'] = $id;
        $data['order'] = $order;
        $data['item'] = $cart['items'][$id];
        $data['curr'] = $this->curr;

        return view('admin.order.edit-product', $data);
    }

    public function updatecart($id)
    {
        $order = Order::find($id);
        $id = $_GET['id'];
        $qty = $_GET['qty'];
        $size = str_replace(' ', '-', $_GET['size']);
        $color = $_GET['color'];
        $size_qty = $_GET['size_qty'];
        $size_price = (float) $_GET['size_price'];
        $size_key = $_GET['size_key'];
        $affilate_user = isset($_GET['affilate_user']) ? $_GET['affilate_user'] : '0';
        $keys = $_GET['keys'];
        $keys = explode(",", $keys);
        $values = $_GET['values'];
        $values = explode(",", $values);
        $prices = $_GET['prices'];
        $prices = explode(",", $prices);
        $keys = $keys == "" ? '' : implode(',', $keys);
        $values = $values == "" ? '' : implode(',', $values);

        $item_id = $_GET['item_id'];

        $size_price = ($size_price / $order->currency_value);
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes', 'minimum_qty']);

        if ($prod->user_id != 0) {
            $prc = $prod->price + $this->gs->fixed_commission + ($prod->price / 100) * $this->gs->percentage_commission;
            $prod->price = round($prc, 2);
        }
        if (!empty($prices)) {
            if (!empty($prices[0])) {
                foreach ($prices as $data) {
                    $prod->price += ($data / $order->currency_value);
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
                return 0;
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
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        if (!empty($cart->items)) {
            if (!empty($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)])) {
                $minimum_qty = (int) $prod->minimum_qty;
                if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] < $minimum_qty) {
                    return redirect()->back()->with('unsuccess', __('Minimum Quantity is:') . ' ' . $prod->minimum_qty);
                }
            } else {
                if ($prod->minimum_qty != null) {
                    $minimum_qty = (int) $prod->minimum_qty;
                    if ($qty < $minimum_qty) {
                        return redirect()->back()->with('unsuccess', __('Minimum Quantity is:') . ' ' . $prod->minimum_qty);
                    }
                }
            }
        } else {
            $minimum_qty = (int) $prod->minimum_qty;
            if ($prod->minimum_qty != null) {
                if ($qty < $minimum_qty) {
                    return redirect()->back()->with('unsuccess', __('Minimum Quantity is:') . ' ' . $prod->minimum_qty);
                }
            }
        }
        $color_price = 0;

        $cart->addnum($prod, $prod->id, $qty, $size, $color, $size_qty, $size_price, $color_price, $size_key, $keys, $values, $affilate_user);

        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['dp'] == 1) {
            return redirect()->back()->with('unsuccess', __('This item is already in the cart.'));
        }
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['stock'] < 0) {
            return redirect()->back()->with('unsuccess', __('Out Of Stock.'));
        }
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
            if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] > $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
                return redirect()->back()->with('unsuccess', __('Out Of Stock.'));
            }
        }

        $cart->totalPrice = 0;
        foreach ($cart->items as $data) {
            $cart->totalPrice += $data['price'];
        }

        $o_cart = json_decode($order->cart, true);

        if (!empty($o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)])) {

            $cart_qty = $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'];
            $cart_price = $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['price'];

            $prev_qty = $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'];
            $prev_price = $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['price'];

            $temp_qty = 0;
            $temp_price = 0;

            if ($o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] < $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty']) {

                $temp_qty = $cart_qty - $prev_qty;
                $temp_price = $cart_price - $prev_price;

                $order->totalQty += $temp_qty;
                $order->pay_amount += $temp_price;
                $prev_qty += $temp_qty;
                $prev_price += $temp_price;
            } elseif ($o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] > $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty']) {

                $temp_qty = $prev_qty - $cart_qty;
                $temp_price = $prev_price - $cart_price;

                $order->totalQty -= $temp_qty;
                $order->pay_amount -= $temp_price;
                $prev_qty -= $temp_qty;
                $prev_price -= $temp_price;
            }
        } else {

            $order->totalQty -= $o_cart['items'][$item_id]['qty'];

            $order->pay_amount -= $o_cart['items'][$item_id]['price'];

            unset($o_cart['items'][$item_id]);

            $order->totalQty = $order->totalQty + $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'];
            $order->pay_amount = $order->pay_amount + $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['price'];

            $prev_qty = 0;
            $prev_price = 0;

            if (!empty($o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)])) {
                $prev_qty = $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'];
                $prev_price = $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['price'];
            }

            $prev_qty += $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'];
            $prev_price += $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['price'];
        }

        $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)] = $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)];
        $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] = $prev_qty;
        $o_cart['items'][$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['price'] = $prev_price;

        $order->cart = json_encode($o_cart);

        $order->update();
        return redirect()->back()->with('success', __('Successfully Updated The Cart.'));
    }

    public function product_delete($id, $orderid)
    {

        $order = Order::find($orderid);
        $cart = json_decode($order->cart, true);

        $order->totalQty = $order->totalQty - $cart['items'][$id]['qty'];
        $order->pay_amount = $order->pay_amount - $cart['items'][$id]['price'];
        unset($cart['items'][$id]);
        $order->cart = json_encode($cart);

        $order->update();

        return redirect()->back()->with('success', __('Successfully Deleted From The Cart.'));
    }
}
