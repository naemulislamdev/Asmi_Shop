<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PreOrderController extends Controller
{
    public function index(Request $request)
    {
        $views = [
            'pending'   => 'admin.pre_order.pending',
            'confirmed' => 'admin.pre_order.confirmed',
        ];

        $status = $request->status;
        $view   = $views[$status] ?? 'admin.pre_order.index';

        return view($view, ['status' => $status]);
    }

    public function datatables(Request $request, $status)
    {
        $query = RequestItem::query()
            ->with(['product', 'user'])
            // route status (pending/confirmed/none tab) — only applies if dropdown status not sent
            ->when($status && $status !== 'all' && !$request->status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            // dropdown filter status — takes priority over route status
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('from_date'), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            });

        $query = $query->latest('id');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('photo', function (RequestItem $data) {
                $photo = $data->product->photo
                    ? asset('assets/images/products/' . $data->product->photo)
                    : asset('assets/images/noimage.png');

                return '<img src="' . $photo . '" class="img-thumbnail" style="width:80px">';
            })

            ->addColumn('product_name', fn($row) => $row->product->name ?? 'N/A')
            ->addColumn('product_sku', fn($row) => $row->product->sku ?? 'N/A')
            ->addColumn('price', fn($row) => $row->product->price ?? 'N/A')
            ->addColumn('date', fn($row) => $row->created_at->format('d M Y, h:i A'))
            ->addColumn('customer_phone', fn($row) => $row->user->phone ?? 'Guest')
            ->addColumn('status', function ($row) {
                $statuses = ['pending', 'confirmed', 'cancelled'];
                $options = '';
                foreach ($statuses as $s) {
                    $selected = $row->status === $s ? 'selected' : '';
                    $options .= '<option value="' . $s . '" ' . $selected . '>' . ucfirst($s) . '</option>';
                }
                return '<select class="form-select form-select-sm status-select" data-id="' . $row->id . '">' . $options . '</select>';
            })
            ->addColumn('action', function ($row) {
                return '
                <div class="d-flex gap-2">
                    <a href="#" data-href="' . route('admin.pre_order.delete', $row->id) . '" class="btn btn-sm btn-danger delete-order" data-id="' . $row->id . '">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            ';
            })
            ->rawColumns(['status', 'action', 'photo'])
            ->make(true);
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $item = RequestItem::findOrFail($id);
        $item->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated successfully!']);
    }
    public function preorderDelete($id)
    {
        $item = RequestItem::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully!']);
    }
}
