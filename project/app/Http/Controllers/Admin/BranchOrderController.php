<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Helpers\PriceHelper;


class BranchOrderController extends Controller
{
    // public function allBranchOrders()
    // {
    //     $orders = Order::with('branch')
    //         ->whereHas('branch')
    //         ->latest()
    //         ->count();
    //     $branchs = Branch::where('status', 1)->get();
    //     return view('admin.branch_orders.index', compact('orders', 'branchs'));
    // }
    // public function datatables(Request $request, $branch_id = null)
    // {
    //     $status = $request->get('status'); // query param দিয়ে নেব
    //     $datas = Order::with(['branch', 'tracks'])
    //         ->whereHas('branch')
    //         ->when($branch_id, function ($query) use ($branch_id) {
    //             return $query->where('branch_id', $branch_id);
    //         })
    //         ->when($status && $status !== 'all', function ($query) use ($status) {
    //             return $query->where('status', $status);
    //         })
    //         ->latest()
    //         ->get();

    //     //--- Integrating This Collection Into Datatables
    //     return DataTables::of($datas)
    //         ->editColumn('customer_address', function (Order $data) {
    //             return Str::limit($data->customer_address, 30, '...');
    //         })
    //         ->editColumn('date', function (Order $data) {
    //             $date = \Carbon\Carbon::parse($data->created_at)->format('d M Y');
    //             $time = \Carbon\Carbon::parse($data->created_at)->format('h:i A');
    //             return $date . '<br><small>' . $time . '</small>';
    //         })
    //         ->editColumn('branch', function (Order $data) {
    //             if ($data->branch_id) {
    //                 return '<a href="javascript:;" class="select-branch badge badge-success"
    //             data-id="' . $data->id . '"
    //             data-toggle="modal"
    //             data-target="#branchModal">' . $data->branch->name . '</a>';
    //             }
    //             return '<a href="javascript:;" class="select-branch btn btn-sm btn-primary"
    //             data-id="' . $data->id . '"
    //             data-toggle="modal"
    //             data-target="#branchModal">' . __('Add') . '</a>';
    //         })
    //         ->editColumn('id', function (Order $data) {
    //             $id = '<a href="' . route('admin-order-invoice', $data->id) . '">' . $data->order_number . '</a>';
    //             $viewbtn = '<a href="' . route('admin-order-show', $data->id) . '" class="btn btn-sm btn-primary">Details</a>';
    //             return $id . $viewbtn;
    //         })
    //         ->editColumn('pay_amount', function (Order $data) {
    //             return PriceHelper::showOrderCurrencyPrice((($data->pay_amount + $data->wallet_price) * $data->currency_value), $data->currency_sign);
    //         })
    //         ->editColumn('status', function (Order $data) {
    //             if ($data->status == 'completed') {
    //                 $badge = 'success';
    //                 $source = __('Completed');
    //             } elseif ($data->status == 'pending') {
    //                 $badge = 'warning';
    //                 $source = __('Pending');
    //             } elseif ($data->status == 'hold') {
    //                 $badge = 'secondary';
    //                 $source = __('Hold');
    //             } elseif ($data->status == 'processing') {
    //                 $badge = 'info';
    //                 $source = __('Processing');
    //             } elseif ($data->status == 'on delivery') {
    //                 $badge = 'primary';
    //                 $source = __('On Delivery');
    //             } elseif ($data->status == 'cancelled') {
    //                 $badge = 'danger';
    //                 $source = __('Cancelled');
    //             } else {
    //                 $badge = 'dark';
    //                 $source = __('Unknown');
    //             }
    //             return '<span class="badge badge-' . $badge . '">' . $source . '</span>';
    //         })
    //         ->editColumn('custom_note', function (Order $data) {
    //             if ($data->tracks->isNotEmpty()) {
    //                 $note = e(optional($data->tracks->last())->text);
    //                 return "
    //         <button
    //             style='font-size: 13px;'
    //             class='btn btn-info btn-sm note-view-btn d-inline-block'
    //             data-note='{$note}'
    //         >
    //             <i class='fa fa-eye'></i> View
    //         </button>
    //     ";
    //             }
    //             return 'N/A';
    //         })
    //         ->editColumn('customer_name', function (Order $data) {
    //             return $data->customer_name . ' || ' . $data->customer_phone;
    //         })

    //         ->editColumn('order_source', function (Order $data) {
    //             if ($data->order_source == 'Website') {
    //                 $badge = 'primary';
    //                 $source = __('Web');
    //             } elseif ($data->order_source == 'Mobile Apps') {
    //                 $badge = 'success';
    //                 $source = __('App');
    //             } elseif ($data->order_source == 'POS') {
    //                 $badge = 'info';
    //                 $source = __('POS');
    //             } else {
    //                 $badge = 'dark';
    //                 $source = __('Unknown');
    //             }
    //             return '<span class="badge badge-' . $badge . '">' . $source . '</span>';
    //         })
    //         ->addColumn('action', function (Order $data) {
    //             $orders = '<a href="javascript:;" data-href="' . route('admin-order-edit', $data->id) . '" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> ' . __('Delivery Status') . '</a>';
    //             $deleteBtn = '<a href="javascript:;"
    //     class="delete-order"
    //     data-href="' . route('admin-order-delete', $data->id) . '">
    //     <i class="fas fa-trash"></i> ' . __('Delete') . '</a>';

    //             return '<div class="godropdown"><button class="go-dropdown-toggle">' . __('Actions') . '</button><div class="action-list"><a href="' . route('admin-order-show', $data->id) . '" > <i class="fas fa-eye"></i> ' . __('View Details') . '</a><a href="javascript:;" class="send" data-email="' . $data->customer_email . '" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> ' . __('Send') . '</a><a href="javascript:;" data-href="' . route('admin-order-track', $data->id) . '" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> ' . __('Track Order') . '</a>' . $orders . $deleteBtn . '</div></div>';
    //         })
    //         ->rawColumns(['date', 'branch', 'customer_address', 'id', 'status', 'custom_note', 'customer_name', 'order_source', 'action'])
    //         ->toJson(); //--- Returning Json Data To Client Side
    // }
    // public function singleBranchOrders($branch_id)
    // {
    //     $branch = Branch::findOrFail($branch_id);

    //     $statusCounts = Order::where('branch_id', $branch_id)
    //         ->selectRaw('status, count(*) as total')
    //         ->groupBy('status')
    //         ->pluck('total', 'status');

    //     $totalCount = Order::where('branch_id', $branch_id)->count();

    //     return view('admin.branch_orders.single', compact('branch', 'statusCounts', 'totalCount'));
    // }

    public function allBranchOrders()
    {
        $branchs = Branch::where('status', 1)->get();
        return view('admin.branch_orders.index', compact('branchs'));
    }

    public function datatables(Request $request, $branch_id = null)
    {
        $status       = $request->get('status');
        $order_status = $request->get('order_status');
        $from_date    = $request->get('from_date');
        $to_date      = $request->get('to_date');
        $unassigned   = $request->get('unassigned'); // নতুন param

        $datas = Order::with(['branch', 'tracks'])
            // branch filter logic
            ->when($unassigned, fn($q) => $q->whereNull('branch_id'))         // not assigned page
            ->when(!$unassigned && !$branch_id, fn($q) => $q->whereHas('branch')) // all branch page
            ->when(!$unassigned && $branch_id, fn($q) => $q->where('branch_id', $branch_id)) // single branch
            ->when($status && $status !== 'all', fn($q) => $q->where('status', $status))
            ->when($order_status, fn($q) => $q->where('status', $order_status))
            ->when($from_date, fn($q) => $q->whereDate('created_at', '>=', $from_date))
            ->when($to_date,   fn($q) => $q->whereDate('created_at', '<=', $to_date))
            ->latest()
            ->get();

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
                    return '<span class="badge badge-success">' . $data->branch->name . '</span>';
                }
                return 'N/A';
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
                return $id . '<br>' . $viewbtn;
            })
            ->editColumn('pay_amount', function (Order $data) {
                return PriceHelper::showOrderCurrencyPrice(
                    (($data->pay_amount + $data->wallet_price) * $data->currency_value),
                    $data->currency_sign
                );
            })
            ->editColumn('status', function (Order $data) {
                $map = [
                    'completed'   => ['success',   'Completed'],
                    'pending'     => ['warning',   'Pending'],
                    'hold'        => ['secondary', 'Hold'],
                    'processing'  => ['info',      'Processing'],
                    'on delivery' => ['primary',   'On Delivery'],
                    'cancelled'   => ['danger',    'Cancelled'],
                ];
                [$badge, $label] = $map[$data->status] ?? ['dark', 'Unknown'];
                return '<span class="badge badge-' . $badge . '">' . __($label) . '</span>';
            })
            ->editColumn('custom_note', function (Order $data) {
                if ($data->tracks->isNotEmpty()) {
                    $note = e(optional($data->tracks->last())->text);
                    return "<button style='font-size:13px;' class='btn btn-info btn-sm note-view-btn' data-note='{$note}'>
                    <i class='fa fa-eye'></i> View
                </button>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('customer_name', function (Order $data) {
                return $data->customer_name . '<br><small>' . $data->customer_phone . '</small>';
            })
            ->editColumn('order_source', function (Order $data) {
                $map = [
                    'Website'     => ['primary', 'Web'],
                    'Mobile Apps' => ['success', 'App'],
                    'POS'         => ['info',    'POS'],
                ];
                [$badge, $label] = $map[$data->order_source] ?? ['dark', 'Unknown'];
                return '<span class="badge badge-' . $badge . '">' . __($label) . '</span>';
            })
            ->addColumn('action', function (Order $data) {
                $view    = '<a href="' . route('admin-order-show', $data->id) . '"><i class="fas fa-eye"></i> ' . __('View Details') . '</a>';
                $send    = '<a href="javascript:;" class="send" data-email="' . $data->customer_email . '" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> ' . __('Send') . '</a>';
                $track   = '<a href="javascript:;" data-href="' . route('admin-order-track', $data->id) . '" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> ' . __('Track Order') . '</a>';
                $status  = '<a href="javascript:;" data-href="' . route('admin-order-edit', $data->id) . '" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> ' . __('Delivery Status') . '</a>';
                $delete  = '<a href="javascript:;" class="delete-order" data-href="' . route('admin-order-delete', $data->id) . '"><i class="fas fa-trash"></i> ' . __('Delete') . '</a>';
                return '<div class="godropdown"><button class="go-dropdown-toggle">' . __('Actions') . '</button><div class="action-list">' . $view . $send . $track . $status . $delete . '</div></div>';
            })
            ->rawColumns(['date', 'branch', 'customer_address', 'id', 'status', 'custom_note', 'customer_name', 'order_source', 'action'])
            ->toJson();
    }

    public function singleBranchOrders($branch_id)
    {
        $branch = Branch::findOrFail($branch_id);
        $modalBranch = Branch::where('status', 1)->get();
        $statusCounts = Order::where('branch_id', $branch_id)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalCount = Order::where('branch_id', $branch_id)->count();

        return view('admin.branch_orders.single', compact('branch', 'modalBranch', 'statusCounts', 'totalCount'));
    }
    public function summary(Request $request, $branch_id = null)
    {
        $status       = $request->get('status');
        $order_status = $request->get('order_status');
        $from_date    = $request->get('from_date');
        $to_date      = $request->get('to_date');
        $unassigned   = $request->get('unassigned');

        $query = Order::query()
            // branch filter logic
            ->when($unassigned,                        fn($q) => $q->whereNull('branch_id'))
            ->when(!$unassigned && $branch_id,         fn($q) => $q->where('branch_id', $branch_id))
            ->when(!$unassigned && !$branch_id,        fn($q) => $q->whereHas('branch'))
            // other filters
            ->when($status && $status !== 'all',       fn($q) => $q->where('status', $status))
            ->when($order_status,                      fn($q) => $q->where('status', $order_status))
            ->when($from_date,                         fn($q) => $q->whereDate('created_at', '>=', $from_date))
            ->when($to_date,                           fn($q) => $q->whereDate('created_at', '<=', $to_date));

        $results = $query->selectRaw("
        COUNT(*) as total_orders,
        SUM(pay_amount) as total_amount,
        SUM(CASE WHEN status='pending'   THEN 1 ELSE 0 END) as pending_qty,
        SUM(CASE WHEN status='pending'   THEN pay_amount ELSE 0 END) as pending_amount,
        SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) as confirmed_qty,
        SUM(CASE WHEN status='completed' THEN pay_amount ELSE 0 END) as confirmed_amount,
        SUM(CASE WHEN status='cancelled' THEN 1 ELSE 0 END) as canceled_qty,
        SUM(CASE WHEN status='cancelled' THEN pay_amount ELSE 0 END) as canceled_amount
    ")->first();

        return response()->json([
            'total_orders'     => $results->total_orders     ?? 0,
            'total_amount'     => number_format($results->total_amount     ?? 0, 2),
            'pending_qty'      => $results->pending_qty      ?? 0,
            'pending_amount'   => number_format($results->pending_amount   ?? 0, 2),
            'confirmed_qty'    => $results->confirmed_qty    ?? 0,
            'confirmed_amount' => number_format($results->confirmed_amount ?? 0, 2),
            'canceled_qty'     => $results->canceled_qty     ?? 0,
            'canceled_amount'  => number_format($results->canceled_amount  ?? 0, 2),
        ]);
    }
    public function notAssignedBranch()
    {
        $branchs = Branch::where('status', 1)->get();
        $statusCounts = Order::where('branch_id', null)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalCount = Order::where('branch_id', null)->count();

        return view('admin.branch_orders.notAssignedBranch', compact('branchs', 'statusCounts', 'totalCount'));
    }
}
