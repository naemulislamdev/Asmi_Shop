<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderGeoReportController extends Controller
{
    /**
     * Order-origin heatmap page. Plots the buyer's real device location
     * (captured at checkout) so marketing can see where orders cluster.
     */
    public function index()
    {
        return view('admin.report.order_location_heatmap.index');
    }

    /**
     * JSON feed for the Leaflet heat layer + a data-quality summary.
     * Filters: date range and order_source (Website / Mobile Apps).
     */
    public function points(Request $request)
    {
        $from   = $request->get('from_date');
        $to     = $request->get('to_date');
        $source = $request->get('source'); // all | Website | Mobile Apps

        $base = DB::table('orders')
            ->when($from, fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('created_at', '<=', $to))
            ->when($source && $source !== 'all', fn ($q) => $q->where('order_source', $source));

        // Data-quality counts over the WHOLE filtered set (not just GPS rows),
        // so the admin knows how representative the map is.
        $quality = (clone $base)
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN location_source = 'gps' AND order_lat IS NOT NULL THEN 1 ELSE 0 END) as gps,
                SUM(CASE WHEN location_source = 'denied' THEN 1 ELSE 0 END) as denied,
                SUM(CASE WHEN location_source IS NULL OR location_source NOT IN ('gps','denied') THEN 1 ELSE 0 END) as other
            ")
            ->first();

        $points = (clone $base)
            ->whereNotNull('order_lat')
            ->whereNotNull('order_lng')
            ->select('order_lat', 'order_lng')
            ->get()
            ->map(fn ($r) => [(float) $r->order_lat, (float) $r->order_lng, 1])
            ->values();

        $total = (int) ($quality->total ?? 0);
        $gps   = (int) ($quality->gps ?? 0);

        return response()->json([
            'points'     => $points,
            'stats'      => [
                'total'       => $total,
                'gps'         => $gps,
                'denied'      => (int) ($quality->denied ?? 0),
                'other'       => (int) ($quality->other ?? 0),
                'gps_percent' => $total > 0 ? round($gps / $total * 100, 1) : 0,
            ],
        ]);
    }
}
