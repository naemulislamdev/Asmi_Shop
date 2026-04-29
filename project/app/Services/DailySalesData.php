<?php

namespace App\Services;

use App\Exports\DataExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class DailySalesData
{
    public static function getDailySalesData($request)
    {
        [$from_date, $to_date] = self::getDateRange($request);

        $statuses = $request->order_status ?? ['completed'];

        $orders = DB::table('orders')
            ->whereBetween('created_at', [$from_date, $to_date])
            ->when(!empty($statuses), function ($q) use ($statuses) {
                $q->whereIn('status', $statuses);
            })
            ->get();

        $products = [];

        foreach ($orders as $order) {

            $cart = json_decode($order->cart, true);

            if (!isset($cart['items'])) continue;

            foreach ($cart['items'] as $item) {

                $product = $item['item'];

                $productId = $product['id'];
                $variationKey = ($item['size'] ?? '') . '-' . ($item['color'] ?? '');

                $key = $productId . '_' . $variationKey;

                if (!isset($products[$key])) {
                    $products[$key] = [
                        'thumbnail' => $product['photo'] ?? '',
                        'name' => $product['name'] ?? '',
                        'code' => $product['slug'] ?? '',
                        'variation' => [
                            'Size' => $item['size'] ?? '',
                            'color' => $item['color'] ?? ''
                        ],
                        'total_qty' => 0,
                        'total_amount' => 0,
                    ];
                }

                $products[$key]['total_qty'] += $item['qty'];
                $products[$key]['total_amount'] += $item['price'];
            }
        }

        $collection = collect(array_values($products));
        //dd($collection);

        return DataTables::of($collection)
            ->addIndexColumn()

            ->editColumn('thumbnail', function ($row) {
                return '<img src="' . asset('assets/storage/product/thumbnail/' . $row['thumbnail']) . '" width="50">';
            })

            ->editColumn('variation', function ($row) {

                $output = [];

                if (!empty($row['variation']['Size'])) {
                    $output[] = 'Size: ' . $row['variation']['Size'];
                }

                if (!empty($row['variation']['color'])) {
                    $output[] = 'Color: ' . $row['variation']['color'];
                }

                return !empty($output) ? implode('<br>', $output) : 'N/A';
            })

            ->editColumn('total_amount', function ($row) {
                return number_format($row['total_amount'], 2);
            })

            ->rawColumns(['thumbnail'])
            ->make(true);
    }

    public static function getDailySalesSummary($request)
    {
        $statuses = $request->order_status ?? ['completed'];

        return response()->json([
            'today_sales' => number_format(self::getSalesAmount(
                Carbon::today()->startOfDay(),
                Carbon::today()->endOfDay(),
                $statuses
            ), 2),

            'yesterday_sales' => number_format(self::getSalesAmount(
                Carbon::yesterday()->startOfDay(),
                Carbon::yesterday()->endOfDay(),
                $statuses
            ), 2),

            'last_7_days_sales' => number_format(self::getSalesAmount(
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::today()->endOfDay(),
                $statuses
            ), 2),

            'monthly_sales' => number_format(self::getSalesAmount(
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
                $statuses
            ), 2),
        ]);
    }
    public static function getDateRange($request)
    {
        $reportType = $request->report_type ?? 'today';

        switch ($reportType) {
            case 'today':
                $from_date = Carbon::today()->startOfDay();
                $to_date = Carbon::today()->endOfDay();
                break;

            case 'yesterday':
                $from_date = Carbon::yesterday()->startOfDay();
                $to_date = Carbon::yesterday()->endOfDay();
                break;

            case 'last_7_days':
                $from_date = Carbon::now()->subDays(6)->startOfDay();
                $to_date = Carbon::today()->endOfDay();
                break;

            case 'monthly':
                $from_date = Carbon::now()->startOfMonth();
                $to_date = Carbon::now()->endOfMonth();
                break;

            case 'custom':
                $from_date = $request->from_date
                    ? Carbon::parse($request->from_date)->startOfDay()
                    : Carbon::today()->startOfDay();

                $to_date = $request->to_date
                    ? Carbon::parse($request->to_date)->endOfDay()
                    : Carbon::today()->endOfDay();
                break;

            default:
                $from_date = Carbon::today()->startOfDay();
                $to_date = Carbon::today()->endOfDay();
                break;
        }

        return [$from_date, $to_date];
    }

    public static function getSalesAmount($from, $to, $statuses = [])
    {
        $orders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->when(!empty($statuses), function ($q) use ($statuses) {
                $q->whereIn('status', $statuses);
            })
            ->get();

        $total = 0;

        foreach ($orders as $order) {

            $cart = json_decode($order->cart, true);

            if (!isset($cart['items'])) continue;

            foreach ($cart['items'] as $item) {
                $total += $item['price'];
            }
        }

        return $total;
    }

    public static function getExportDailySales($request)
    {
        $from_date = Carbon::parse($request->from_date)->startOfDay();
        $to_date   = Carbon::parse($request->to_date)->endOfDay();

        $orders = DB::table('orders')
            ->whereBetween('created_at', [$from_date, $to_date])
            ->where('status', 'confirmed')
            ->get();

        $products = [];

        foreach ($orders as $order) {

            $cart = json_decode($order->cart, true);

            if (!isset($cart['items'])) continue;

            foreach ($cart['items'] as $item) {

                $product = $item['item'];

                $productId = $product['id'];
                $variationKey = ($item['size'] ?? '') . '-' . ($item['color'] ?? '');

                $key = $productId . '_' . $variationKey;

                if (!isset($products[$key])) {
                    $products[$key] = [
                        'name' => $product['name'] ?? '',
                        'code' => $product['slug'] ?? '',
                        'variation' => [
                            'Size' => $item['size'] ?? '',
                            'Color' => $item['color'] ?? ''
                        ],
                        'total_qty' => 0,
                        'total_amount' => 0,
                    ];
                }

                // qty add
                $products[$key]['total_qty'] += $item['qty'];

                // ⚠️ IMPORTANT: price already total (qty সহ)
                $products[$key]['total_amount'] += $item['price'];
            }
        }

        // Convert to export array
        $data = collect($products)->map(function ($item) {

            $variationText = [];

            if (!empty($item['variation']['Size'])) {
                $variationText[] = 'Size: ' . $item['variation']['Size'];
            }

            if (!empty($item['variation']['Color'])) {
                $variationText[] = 'Color: ' . $item['variation']['Color'];
            }

            return [
                $item['name'],
                !empty($variationText) ? implode(', ', $variationText) : 'N/A',
                $item['code'],
                $item['total_qty'],
                number_format($item['total_amount'], 2),
            ];
        })->values()->toArray();

        $headings = [
            'Product Name',
            'Attributes',
            'Product Code',
            'Total Qty',
            'Total Selling Amount',
        ];

        $filename = 'Daily_Sales_Report_' . $request->from_date . '_to_' . $request->to_date . '.xlsx';

        return Excel::download(new DataExport($headings, $data), $filename);
    }
}
