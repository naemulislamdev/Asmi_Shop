<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    public function datatables()
    {
        $datas = Branch::latest('id')->get();
        //--- Integrating This Collection Into Datatables
        return DataTables::of($datas)
            ->addColumn('status', function (Branch $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-branch-status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-branch-status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option></select></div>';
            })
            ->addColumn('action', function (Branch $data) {
                return '<div class="action-list"><a href="' . route('admin-branch-edit', $data->id) . '"> <i class="fas fa-edit"></i>' . __('Edit') . '</a><a href="javascript:;" data-href="' . route('admin-branch-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['status', 'action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.branch.index');
    }


    //*** GET Request
    public function create()
    {
        return view('admin.branch.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $request->validate([
            'name' => 'required|unique:branches,name',
            'address' => 'required',
            'order' => 'required|integer',
        ]);
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Branch();
        $input = $request->all();
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('New Data Added Successfully.') . '<a href="' . route("admin-branch-index") . '">' . __("View Branch Lists") . '</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Branch::findOrFail($id);
        return view('admin.branch.edit', compact('data'));
    }


    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section

        $request->validate([
            'name' => 'required|unique:branches,name,' . $id,
            'address' => 'required',
            'order' => 'required|integer',
        ]);
        //--- Validation Section Ends

        //--- Logic Section
        $data = Branch::findOrFail($id);
        $input = $request->all();
        $data->fill($input)->save();

        //--- Redirect Section
        $msg = __('Data Updated Successfully.') . '<a href="' . route("admin-branch-index") . '">' . __("View Branch Lists") . '</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    //*** GET Request Status
    public function status($id1, $id2)
    {
        $data = Branch::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }


    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Branch::findOrFail($id);
        $data->delete();
        //--- Redirect Section
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
