<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderGeoReportController extends Controller
{
    /**
     * Order-origin analytics page: GPS heatmap + breakdowns by outlet,
     * city and division so marketing can see where orders come from.
     */
    public function index()
    {
        return view('admin.report.order_location_heatmap.index');
    }

    /**
     * JSON feed: GPS points for the heat layer, a data-quality summary,
     * and order/revenue breakdowns by outlet, city and division.
     * Filters: date range and order_source (Website / Mobile Apps).
     */
    public function points(Request $request)
    {
        $from   = $request->get('from_date');
        $to     = $request->get('to_date');
        $source = $request->get('source'); // all | Website | Mobile Apps

        // Reusable filter applied to every query below.
        $filter = function ($q) use ($from, $to, $source) {
            return $q
                ->when($from, fn ($x) => $x->whereDate('orders.created_at', '>=', $from))
                ->when($to, fn ($x) => $x->whereDate('orders.created_at', '<=', $to))
                ->when($source && $source !== 'all', fn ($x) => $x->where('orders.order_source', $source));
        };

        // --- Data-quality summary over the whole filtered set ---
        $quality = $filter(DB::table('orders'))
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN location_source = 'gps' AND order_lat IS NOT NULL THEN 1 ELSE 0 END) as gps,
                SUM(CASE WHEN location_source = 'denied' THEN 1 ELSE 0 END) as denied,
                SUM(CASE WHEN location_source IS NULL OR location_source NOT IN ('gps','denied') THEN 1 ELSE 0 END) as other
            ")
            ->first();

        // --- GPS points for the heat layer + markers ---
        $points = $filter(DB::table('orders'))
            ->whereNotNull('order_lat')
            ->whereNotNull('order_lng')
            ->select('order_lat', 'order_lng')
            ->get()
            ->map(fn ($r) => [(float) $r->order_lat, (float) $r->order_lng, 1])
            ->values();

        // --- Orders by outlet (branch) — the reliable location signal.
        // customer_city/customer_state are NOT used: legacy data has them
        // defaulted ("Uttara") or stored as raw ids ("14"), so they'd mislead.
        $outlets = $filter(DB::table('orders'))
            ->join('branches', 'branches.id', '=', 'orders.branch_id')
            ->groupBy('orders.branch_id', 'branches.name')
            ->selectRaw('branches.name as name, COUNT(orders.id) as orders, ROUND(SUM(orders.pay_amount)) as revenue')
            ->orderByDesc('orders')
            ->get();

        $outletOrders = $filter(DB::table('orders'))->whereNotNull('branch_id')->count();

        $total = (int) ($quality->total ?? 0);
        $gps   = (int) ($quality->gps ?? 0);

        return response()->json([
            'points' => $points,
            'stats'  => [
                'total'         => $total,
                'gps'           => $gps,
                'denied'        => (int) ($quality->denied ?? 0),
                'other'         => (int) ($quality->other ?? 0),
                'gps_percent'   => $total > 0 ? round($gps / $total * 100, 1) : 0,
                'top_outlet'    => $outlets->first()->name ?? '—',
                'outlet_orders' => $outletOrders,
            ],
            'breakdowns' => [
                'outlets' => $outlets,
            ],
        ]);
    }
}
