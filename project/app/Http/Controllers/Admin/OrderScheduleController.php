<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Yajra\DataTables\Facades\DataTables;

class OrderScheduleController extends Controller
{
    public function datatables()
    {
        $datas = OrderSchedule::latest('id')->get();
        //--- Integrating This Collection Into Datatables
        return DataTables::of($datas)
            ->addColumn('status', function (OrderSchedule $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('schedule.status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('schedule.status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option>/select></div>';
            })

            ->addColumn('action', function (OrderSchedule $data) {
                return '<div class="action-list"><a data-href="' . route('schedule.edit', $data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>' . __('Edit') . '</a><a href="javascript:;" data-href="' . route('schedule.delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['status', 'action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.order_schedule.index');
    }

    public function create()
    {
        return view('admin.order_schedule.create');
    }
    //*** POST Request
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string',
            'time_form' => 'required|string',
            'time_to' => 'required|string',
            'offer' => 'nullable|string',
        ]);
        $data = new OrderSchedule();
        $input = $request->all();

        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('Order Schedule Added Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $data = OrderSchedule::findOrFail($id);
        return view('admin.order_schedule.edit', compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string',
            'time_form' => 'required|string',
            'time_to' => 'required|string',
            'offer' => 'nullable|string',
        ]);

        //--- Logic Section
        $data = OrderSchedule::findOrFail($id);
        $input = $request->all();
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Status
    public function status($id1, $id2)
    {
        $data = OrderSchedule::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    //*** GET Request Delete
    public function delete($id)
    {
        $data = OrderSchedule::findOrFail($id);
        $data->delete();
        //--- Redirect Section
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
