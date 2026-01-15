<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Report;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportController extends AdminBaseController
{

    //*** JSON Request
    public function datatables()
    {
        $datas = Report::latest('id')->get();
        //--- Integrating This Collection Into Datatables
        return DataTables::of($datas)
            ->addColumn('product', function (Report $data) {
                $name =  mb_strlen(strip_tags($data->product->name), 'UTF-8') > 50 ? mb_substr(strip_tags($data->product->name), 0, 50, 'UTF-8') . '...' : strip_tags($data->product->name);
                $product = '<a href="' . route('front.product', $data->product->slug) . '" target="_blank">' . $name . '</a>';
                return $product;
            })
            ->addColumn('reporter', function (Report $data) {
                $name = $data->user->name;
                return $name;
            })
            ->addColumn('title', function (Report $data) {
                $text = mb_strlen(strip_tags($data->title), 'UTF-8') > 250 ? mb_substr(strip_tags($data->title), 0, 250, 'UTF-8') . '...' : strip_tags($data->title);
                return $text;
            })
            ->editColumn('created_at', function (Report $data) {
                return $data->created_at->diffForHumans();
            })
            ->addColumn('action', function (Report $data) {
                return '<div class="action-list"><a data-href="' . route('admin-report-show', $data->id) . '" class="view details-width" data-toggle="modal" data-target="#modal1"> <i class="fas fa-eye"></i>' . __('Details') . '</a><a href="javascript:;" data-href="' . route('admin-report-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['product', 'action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.report.index');
    }

    //*** GET Request
    public function show($id)
    {
        $data = Report::findOrFail($id);
        return view('admin.report.show', compact('data'));
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Report::findOrFail($id);
        $data->delete();
        //--- Redirect Section
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    public function orderReportIndex()
    {
        //Order report data
        $from = date('Y-m-d') . " 00:00:00";
        $to   = date('Y-m-d') . " 23:59:59";

        // Fetch data
        $results = Order::selectRaw("
                COUNT(*) as total_orders,
                SUM(pay_amount) as pay_amount,
                SUM(CASE WHEN status='pending' THEN 1 END) as pending_qty,
                SUM(CASE WHEN status='pending' THEN pay_amount END) as pending_amount,
                SUM(CASE WHEN status='completed' THEN 1 END) as completed_qty,
                SUM(CASE WHEN status='completed' THEN pay_amount END) as completed_amount,
                SUM(CASE WHEN status='declined' THEN 1 END) as declined_qty,
                SUM(CASE WHEN status='declined' THEN pay_amount END) as declined_amount,
                SUM(CASE WHEN status='processing' THEN 1 END) as processing_qty,
                SUM(CASE WHEN status='processing' THEN pay_amount END) as processing_amount,
                SUM(CASE WHEN status='on delivery' THEN 1 END) as on_delivery_qty,
                SUM(CASE WHEN status='on delivery' THEN pay_amount END) as on_delivery_amount,
                SUM(CASE WHEN order_source='Website' THEN 1 END) as website_orders,
                SUM(CASE WHEN order_source='Mobile Apps' THEN 1 END) as mobile_app_orders
        ")
            ->whereBetween('created_at', [$from, $to])
            ->first();

        // Convert USD → BDT
        $results->pay_amount        = $results->pay_amount ?? 0;
        $results->pending_amount      = $results->pending_amount ?? 0;
        $results->completed_amount    = $results->completed_amount ?? 0;
        $results->declined_amount     = $results->declined_amount ?? 0;
        $results->processing_amount   = $results->processing_amount ?? 0;
        $results->on_delivery_amount  = $results->on_delivery_amount ?? 0;

        // top selling product
        $ordersCart = Order::where('status', 'completed')
            ->pluck('cart');

        // dd($ordersCart);

        $productSales = [];

        foreach ($ordersCart as $cartJson) {
            $cart = json_decode($cartJson, true);
            // dd($cart);

            if (!isset($cart['items'])) continue;

            foreach ($cart['items'] as $productId => $item) {
                $qty  = $item['qty'] ?? 0;
                $name = $item['item']['name'] ?? 'Unknown';

                if (!isset($productSales[$productId])) {
                    $productSales[$productId] = [
                        'name' => $name,
                        'qty'  => 0
                    ];
                }

                $productSales[$productId]['qty'] += $qty;
            }
        }

        // Sort by qty desc
        uasort($productSales, fn($a, $b) => $b['qty'] <=> $a['qty']);

        $topSellingProduct = reset($productSales);

        $results->top_selling_product = $topSellingProduct
            ? $topSellingProduct['name'] . ' Sell Quantity:' . ' (' . $topSellingProduct['qty'] . ')'
            : 'N/A';
        return view('admin.report.order_report.index', compact('results'));
    }

    public function orderReportFilter(Request $request)
    {
        $from = $request->from_date . " 00:00:00";
        $to   = $request->to_date . " 23:59:59";

        // Fetch data
        $results = Order::selectRaw("
                COUNT(*) as total_orders,
                SUM(pay_amount) as pay_amount,
                SUM(CASE WHEN status='pending' THEN 1 END) as pending_qty,
                SUM(CASE WHEN status='pending' THEN pay_amount END) as pending_amount,
                SUM(CASE WHEN status='completed' THEN 1 END) as completed_qty,
                SUM(CASE WHEN status='completed' THEN pay_amount END) as completed_amount,
                SUM(CASE WHEN status='declined' THEN 1 END) as declined_qty,
                SUM(CASE WHEN status='declined' THEN pay_amount END) as declined_amount,
                SUM(CASE WHEN status='processing' THEN 1 END) as processing_qty,
                SUM(CASE WHEN status='processing' THEN pay_amount END) as processing_amount,
                SUM(CASE WHEN status='on delivery' THEN 1 END) as on_delivery_qty,
                SUM(CASE WHEN status='on delivery' THEN pay_amount END) as on_delivery_amount,

        ")
            ->whereBetween('created_at', [$from, $to])
            ->first();

        //top selling product
        // Top selling product logic
        $ordersCarts = Order::whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->pluck('carts');
        // dd($ordersCarts);

        $productSales = [];

        foreach ($ordersCarts as $cartJson) {
            $cart = json_decode($cartJson, true);

            if (!isset($cart['items'])) continue;

            foreach ($cart['items'] as $productId => $item) {
                $qty  = $item['qty'] ?? 0;
                $name = $item['item']['name'] ?? 'Unknown';

                if (!isset($productSales[$productId])) {
                    $productSales[$productId] = [
                        'name' => $name,
                        'qty'  => 0
                    ];
                }

                $productSales[$productId]['qty'] += $qty;
            }
        }

        uasort($productSales, fn($a, $b) => $b['qty'] <=> $a['qty']);

        $topSellingProduct = reset($productSales);

        $results->top_selling_products = $topSellingProduct
            ? $topSellingProduct['name'] . ' (' . $topSellingProduct['qty'] . ')'
            : 'N/A';



        // Convert USD → BDT
        $results->pay_amount        = $results->pay_amount ?? 0;
        $results->pending_amount      = $results->pending_amount ?? 0;
        $results->completed_amount    = $results->completed_amount ?? 0;
        $results->declined_amount     = $results->declined_amount ?? 0;
        $results->processing_amount   = $results->processing_amount ?? 0;
        $results->on_delivery_amount  = $results->on_delivery_amount ?? 0;

        // dd($results);
        // Return the updated card HTML
        $html = view('admin.report.order_report.order_report_data', compact('results'))->render();

        return response()->json([
            'view' => $html
        ]);
    }
}
