<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserInfoController extends AdminBaseController
{
    public function index()
    {
        return view('admin.userinfos.index');
    }

    public function datatable(Request $request)
    {
        $query = UserInfo::query()->latest('id');

        return DataTables::eloquent($query)
            ->editColumn('date', function (UserInfo $data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->editColumn('status', function (UserInfo $data) {
                if ($data->status == 'completed') {
                    $badge = 'success';
                    $source = __('Completed');
                } elseif ($data->status == 'pending') {
                    $badge = 'warning';
                    $source = __('Pending');
                } elseif ($data->status == 'hold') {
                    $badge = 'secondary';
                    $source = __('Hold');
                } elseif ($data->status == 'processing') {
                    $badge = 'info';
                    $source = __('Processing');
                } elseif ($data->status == 'on delivery') {
                    $badge = 'primary';
                    $source = __('On Delivery');
                } elseif ($data->status == 'cancelled') {
                    $badge = 'danger';
                    $source = __('Cancelled');
                } else {
                    $badge = 'dark';
                    $source = __('Unknown');
                }
                return '<span class="badge badge-' . $badge . '">' . $source . '</span>';
            })
            ->addColumn('action', function (UserInfo $data) {
                $status = '<a href="javascript:;" data-href="' . route('admin-userinfo-status-edit', $data->id) . '" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> ' . __('Change Status') . '</a>';
                return '<div class="godropdown"><button class="go-dropdown-toggle">' . __('Actions') . '</button><div class="action-list">' . $status . '</div></div>';
            })
            ->rawColumns(['date', 'status', 'action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function statusEdit($id)
    {
        $data = UserInfo::findOrFail($id);
        return view('admin.userinfos.status', compact('data'));
    }
    public function statusUpdate(Request $request, $id)
    {
        $data = UserInfo::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,processing,on delivery,completed,hold,cancelled',
            'custome_note' => 'nullable|string',
        ]);

        $data->status = $request->status;
        $data->custome_note = $request->custome_note;
        $data->update();

        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
    }
}
