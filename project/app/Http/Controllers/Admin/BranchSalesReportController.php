<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BranchSalesReportController extends Controller
{
     public function index()
    {

        $branches = Branch::where('status', 1)->get();
        return view('admin.report.branch_sale_report.index', compact('branches'));
    }

    public function summary(Request $request)
    {
        $branch_id = $request->get('branch_id');
        $status    = $request->get('status');
        $from_date = $request->get('from_date');
        $to_date   = $request->get('to_date');

        $summary = DB::table('orders')
            ->when($branch_id === 'notAssignedBranch',                              fn($q) => $q->whereNull('branch_id'))
            ->when($branch_id && !in_array($branch_id, ['all', 'notAssignedBranch']), fn($q) => $q->where('branch_id', $branch_id))
            ->when($status && $status !== 'all',                                    fn($q) => $q->where('status', $status))
            ->when($from_date,                                                      fn($q) => $q->whereDate('created_at', '>=', $from_date))
            ->when($to_date,                                                        fn($q) => $q->whereDate('created_at', '<=', $to_date))
            ->selectRaw("
            COUNT(*) as total_orders,
            SUM(pay_amount) as total_amount,
            SUM(CASE WHEN status='pending'     THEN 1 ELSE 0 END) as pending_qty,
            SUM(CASE WHEN status='pending'     THEN pay_amount ELSE 0 END) as pending_amount,
            SUM(CASE WHEN status='completed'   THEN 1 ELSE 0 END) as completed_qty,
            SUM(CASE WHEN status='completed'   THEN pay_amount ELSE 0 END) as completed_amount,
            SUM(CASE WHEN status='cancelled'   THEN 1 ELSE 0 END) as cancelled_qty,
            SUM(CASE WHEN status='cancelled'   THEN pay_amount ELSE 0 END) as cancelled_amount,
            SUM(CASE WHEN status='hold'        THEN 1 ELSE 0 END) as hold_qty,
            SUM(CASE WHEN status='hold'        THEN pay_amount ELSE 0 END) as hold_amount,
            SUM(CASE WHEN status='processing'  THEN 1 ELSE 0 END) as processing_qty,
            SUM(CASE WHEN status='processing'  THEN pay_amount ELSE 0 END) as processing_amount,
            SUM(CASE WHEN status='on delivery' THEN 1 ELSE 0 END) as on_delivery_qty,
            SUM(CASE WHEN status='on delivery' THEN pay_amount ELSE 0 END) as on_delivery_amount
        ")
            ->first();

        return response()->json([
            'total_orders'       => $summary->total_orders ?? 0,
            'total_amount'       => number_format($summary->total_amount ?? 0, 2),
            'pending_qty'        => $summary->pending_qty ?? 0,
            'pending_amount'     => number_format($summary->pending_amount ?? 0, 2),
            'completed_qty'      => $summary->completed_qty ?? 0,
            'completed_amount'   => number_format($summary->completed_amount ?? 0, 2),
            'cancelled_qty'      => $summary->cancelled_qty ?? 0,
            'cancelled_amount'   => number_format($summary->cancelled_amount ?? 0, 2),
            'hold_qty'           => $summary->hold_qty ?? 0,
            'hold_amount'        => number_format($summary->hold_amount ?? 0, 2),
            'processing_qty'     => $summary->processing_qty ?? 0,
            'processing_amount'  => number_format($summary->processing_amount ?? 0, 2),
            'on_delivery_qty'    => $summary->on_delivery_qty ?? 0,
            'on_delivery_amount' => number_format($summary->on_delivery_amount ?? 0, 2),
        ]);
    }
    public function datatable(Request $request)
    {
        $branch_id = $request->get('branch_id');
        $status    = $request->get('status');
        $from_date = $request->get('from_date');
        $to_date   = $request->get('to_date');

        $orders = DB::table('orders')
            ->when($branch_id === 'notAssignedBranch',                                fn($q) => $q->whereNull('branch_id'))
            ->when($branch_id === 'all' || !$branch_id,                               fn($q) => $q) // সব
            ->when($branch_id && !in_array($branch_id, ['all', 'notAssignedBranch']), fn($q) => $q->where('branch_id', $branch_id))
            ->when($status && $status !== 'all',                                      fn($q) => $q->where('status', $status))
            ->when($from_date,                                                        fn($q) => $q->whereDate('created_at', '>=', $from_date))
            ->when($to_date,                                                          fn($q) => $q->whereDate('created_at', '<=', $to_date))
            ->get();

        // আগে সব product id collect করো
        $productIds = [];
        foreach ($orders as $order) {
            $cart = json_decode($order->cart, true);
            if (!isset($cart['items'])) continue;
            foreach ($cart['items'] as $item) {
                $productIds[] = $item['item']['id'];
            }
        }

        // একবারে সব SKU নাও
        $skuMap = DB::table('products')
            ->whereIn('id', array_unique($productIds))
            ->pluck('sku', 'id');

        // Cart JSON থেকে product data বের করো
        $products = [];

        foreach ($orders as $order) {
            $cart = json_decode($order->cart, true);
            if (!isset($cart['items'])) continue;

            foreach ($cart['items'] as $item) {
                $product      = $item['item'];
                $productId    = $product['id'];
                $variationKey = ($item['size'] ?? '') . '-' . ($item['color'] ?? '');
                $key          = $productId . '_' . $variationKey;

                if (!isset($products[$key])) {
                    $products[$key] = [
                        'image'        => $product['photo'] ?? '',
                        'name'         => $product['name'] ?? '',
                        'sku'          => $skuMap->get($productId) ?? 'N/A',
                        'slug'         => $product['slug'] ?? '',
                        'attribute'    => collect([
                            !empty($item['size'])  ? 'Size: '  . $item['size']  : null,
                            !empty($item['color']) ? 'Color: ' . $item['color'] : null,
                        ])->filter()->implode(' | ') ?: 'N/A',
                        'qty'          => 0,
                        'total_amount' => 0,
                    ];
                }

                $products[$key]['qty']          += $item['qty'];
                $products[$key]['total_amount'] += $item['price'];
            }
        }

        // qty desc sort
        usort($products, fn($a, $b) => $b['qty'] <=> $a['qty']);

        $collection = collect(array_values($products));

        return DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('image', function ($row) {
                $src = $row['image']
                    ? asset('assets/images/products/' . $row['image'])
                    : asset('assets/images/noimage.png');
                return '<img src="' . $src . '" width="50" height="50" style="object-fit:cover; border-radius:6px;">';
            })
            ->editColumn('name', function ($row) {
                $url = route('front.product', $row['slug']);
                return '<a class="text-primary" href="' . $url . '" target="_blank">' . $row['name'] . '</a>';
            })
            ->editColumn('attribute', function ($row) {
                return $row['attribute'];
            })
            ->editColumn('total_amount', function ($row) {
                return number_format($row['total_amount'], 2);
            })
            ->rawColumns(['image', 'name'])
            ->make(true);
    }
}
