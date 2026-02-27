<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PriceHelper;
use App\Models\Branch;
use App\Models\Notification;
use App\Models\Order;
use DB;
use Yajra\DataTables\DataTables;

class NotificationController extends AdminBaseController
{


    public function viewAllNotification()
    {
        $branchs = Branch::where('status', 1)->get();
        return view('admin.notification.allNotification', compact('branchs'));
    }

    public function datatables()
    {

        $orderIds = Notification::whereNotNull('order_id')
            ->pluck('order_id')
            ->unique();


        $orders = Order::with(['branch', 'tracks'])
            ->whereIn('id', $orderIds)
            ->latest();

        return DataTables::of($orders)

            ->editColumn('customer_name', function (Order $data) {
                return $data->customer_name ?? 'N/A';
            })

            ->editColumn('customer_address', function (Order $data) {
                return $data->customer_address ?? 'N/A';
            })

            ->editColumn('date', function (Order $data) {
                $date = $data->created_at->format('d M Y');
                $time = $data->created_at->format('h:i A');
                return $date . '<br><small>' . $time . '</small>';
            })

            ->editColumn('branch', function (Order $data) {
                if ($data->branch_id && $data->branch) {
                    return '<a href="javascript:;"
                    class="select-branch badge badge-success"
                    data-id="' . $data->id . '"
                    data-toggle="modal"
                    data-target="#branchModal">'
                        . e($data->branch->name) .
                        '</a>';
                }

                return '<a href="javascript:;"
                class="select-branch btn btn-sm btn-primary"
                data-id="' . $data->id . '"
                data-toggle="modal"
                data-target="#branchModal">'
                    . __('Add') .
                    '</a>';
            })

            ->editColumn('id', function (Order $data) {
                return '<a href="' . route('admin-order-invoice', $data->id) . '">'
                    . e($data->order_number) .
                    '</a>';
            })

            ->editColumn('totalQty', function (Order $data) {
                return $data->totalQty ?? 0;
            })

            ->editColumn('pay_amount', function (Order $data) {
                return PriceHelper::showOrderCurrencyPrice(
                    (($data->pay_amount + $data->wallet_price) * $data->currency_value),
                    $data->currency_sign
                );
            })

            ->editColumn('status', function (Order $data) {
                $map = [
                    'completed' => ['success', __('Completed')],
                    'pending' => ['warning', __('Pending')],
                    'hold' => ['secondary', __('Hold')],
                    'processing' => ['info', __('Processing')],
                    'on delivery' => ['primary', __('On Delivery')],
                    'cancelled' => ['danger', __('Cancelled')],
                ];

                [$badge, $text] = $map[$data->status] ?? ['dark', __('Unknown')];

                return '<span class="badge badge-' . $badge . '">' . $text . '</span>';
            })

            ->editColumn('custom_note', function (Order $data) {
                if ($data->tracks && $data->tracks->isNotEmpty()) {
                    $note = e(optional($data->tracks->last())->text);

                    return '<button
                    class="btn btn-info btn-sm note-view-btn"
                    data-note="' . $note . '">
                    <i class="fa fa-eye"></i> View
                </button>';
                }

                return 'N/A';
            })

            ->editColumn('order_source', function (Order $data) {
                if ($data->order_source === 'Website') {
                    return '<span class="badge badge-primary">' . __('Web') . '</span>';
                }

                if ($data->order_source === 'Mobile Apps') {
                    return '<span class="badge badge-success">' . __('App') . '</span>';
                }

                return '<span class="badge badge-dark">' . __('Unknown') . '</span>';
            })

            ->addColumn('action', function (Order $data) {
                $deleteBtn = '<a href="javascript:;"
                class="delete-order"
                data-href="' . route('admin-order-delete', $data->id) . '">
                <i class="fas fa-trash"></i> ' . __('Delete') . '
            </a>';

                return '<div class="godropdown">
                <button class="go-dropdown-toggle">' . __('Actions') . '</button>
                <div class="action-list">
                    <a href="' . route('admin-order-show', $data->id) . '">
                        <i class="fas fa-eye"></i> ' . __('View Details') . '
                    </a>
                    <a href="javascript:;"
                        class="send"
                        data-email="' . e($data->customer_email) . '"
                        data-toggle="modal"
                        data-target="#vendorform">
                        <i class="fas fa-envelope"></i> ' . __('Send') . '
                    </a>
                    ' . $deleteBtn . '
                </div>
            </div>';
            })

            ->rawColumns([
                'date',
                'branch',
                'id',
                'status',
                'custom_note',
                'order_source',
                'action'
            ])

            ->toJson();
    }



    public function all_notf_count()
    {
        $user_count = DB::table('notifications')->where('user_id', '!=', null)->where('is_read', '=', 0)->count();
        $order_count = DB::table('notifications')->where('order_id', '!=', null)->where('is_read', '=', 0)->count();
        $product_count = DB::table('notifications')->where('product_id', '!=', null)->where('is_read', '=', 0)->count();
        $conv_count = DB::table('notifications')->where('conversation_id', '!=', null)->where('is_read', '=', 0)->count();

        $data = array();
        $data['user_count'] = $user_count;
        $data['conv_count'] = $conv_count;
        $data['order_count'] = $order_count;
        $data['product_count'] = $product_count;

        return response()->json($data);
    }

    public function user_notf_clear()
    {
        $data = Notification::where('user_id', '!=', null);
        $data->delete();
    }

    public function user_notf_show()
    {
        $datas = Notification::where('user_id', '!=', null)->latest('id')->get();

        if ($datas->count() > 0) {
            foreach ($datas as $data) {
                $data->is_read = 1;
                $data->update();
            }
        }
        return view('admin.notification.register', compact('datas'));
    }

    public function order_notf_clear()
    {
        $data = Notification::where('order_id', '!=', null);
        $data->delete();
    }

    public function order_notf_show()
    {
        $datas = Notification::where('order_id', '!=', null)->latest('id')->get();
        if ($datas->count() > 0) {
            foreach ($datas as $data) {
                $data->is_read = 1;
                $data->update();
            }
        }
        return view('admin.notification.order', compact('datas'));
    }

    public function product_notf_clear()
    {
        $data = Notification::where('product_id', '!=', null);
        $data->delete();
    }

    public function product_notf_show()
    {
        $datas = Notification::where('product_id', '!=', null)->latest('id')->get();
        if ($datas->count() > 0) {
            foreach ($datas as $data) {
                $data->is_read = 1;
                $data->update();
            }
        }
        return view('admin.notification.product', compact('datas'));
    }

    public function conv_notf_clear()
    {
        $data = Notification::where('conversation_id', '!=', null);
        $data->delete();
    }

    public function conv_notf_show()
    {
        $datas = Notification::where('conversation_id', '!=', null)->latest('id')->get();
        if ($datas->count() > 0) {
            foreach ($datas as $data) {
                $data->is_read = 1;
                $data->update();
            }
        }
        return view('admin.notification.message', compact('datas'));
    }
}
