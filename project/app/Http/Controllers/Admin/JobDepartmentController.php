<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class JobDepartmentController extends Controller
{
    public function index()
    {
        return view('admin.career.department.index');
    }
    public function departmentDatatables(Request $request)
    {
        $query = JobDepartment::query()
            ->latest('id');

        if ($request->type == 'deactive') {
            $query->whereStatus(0);
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()

            ->addColumn('status', function (JobDepartment $data) {
                $class = $data->status ? 'drop-success' : 'drop-danger';
                return '
                <div class="action-list">
                    <select class="process select droplinks ' . $class . '">
                        <option data-val="1" value="' . route('career.department-status', [$data->id, 1]) . '" ' . ($data->status ? 'selected' : '') . '>' . __("Activated") . '</option>
                        <option data-val="0" value="' . route('career.department-status', [$data->id, 0]) . '" ' . (!$data->status ? 'selected' : '') . '>' . __("Deactivated") . '</option>
                    </select>
                </div>';
            })
            ->addColumn('action', function (JobDepartment $data) {

                return '
                <div class="godropdown">
                    <button class="go-dropdown-toggle"> ' . __("Actions") . ' <i class="fas fa-chevron-down"></i></button>
                    <div class="action-list">
                       <button
                            type="button"
                            class="edit-btn btn btn-white"
                            data-toggle="modal"
                            data-target="#editModal"
                            data-id="' . $data->id . '"
                            data-name="' . $data->name . '"
                            >
                            <i class="fas fa-edit"></i> ' . __("Edit") . '
                        </button>
                        <a href="javascript:;" data-href="' . route('career.department-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete text-danger"><i class="fas fa-trash-alt"></i> ' . __("Delete") . '</a>
                    </div>
                </div>';
            })

            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    //*** GET Request
    public function status($id1, $id2)
    {
        $data = JobDepartment::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    public function delete($id)
    {
        $data = JobDepartment::findOrFail($id);
        $data->delete();
        //--- Redirect Section

        $msg = __('Department Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:job_departments,name',
        ]);

        JobDepartment::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        $msg = __('Department Added Successfully.');
        return response()->json($msg);
    }
    public function update(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
        ]);

        $job = JobDepartment::findOrFail($request->id);
        $job->name = $request->name;
        $job->slug = Str::slug($request->name);

        // image upload (optional)

        $job->update();
        $msg = __('Department Updated Successfully.');
        return response()->json($msg);
    }
}
