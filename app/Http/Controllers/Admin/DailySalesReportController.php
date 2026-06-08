<?php

namespace App\Http\Controllers\Admin;

use App\Services\DailySalesData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DailySalesReportController extends Controller
{
    public function dailySales()
    {
        return view('admin.report.daily_sale_report.index');
    }
    public function dailySalesData(Request $request)
    {
        return DailySalesData::getDailySalesData($request);
    }
    public function dailySalesSummary(Request $request)
    {
        return DailySalesData::getDailySalesSummary($request);
    }
    public function dailySalesExport(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ]);

        return DailySalesData::getExportDailySales($request);
    }
}
