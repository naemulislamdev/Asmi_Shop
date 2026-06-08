<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderExportController extends Controller
{
    public function export(Request $request)
    {
        $format = $request->input('format');
        $status = $request->input('status');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        if ($format == 'excel') {
            return Excel::download(new OrdersExport($status, $fromDate, $toDate), 'orders.xlsx');
        }

        return back()->with('error', 'Format not supported yet!');
    }
}
