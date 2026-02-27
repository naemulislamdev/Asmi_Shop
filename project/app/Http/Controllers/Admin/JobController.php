<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class JobController extends Controller
{
    public function index()
    {
        return view('admin.career.jobs.index');
    }

    public function create()
    {
        $departments = JobDepartment::where('status', 1)->get();
        return view('admin.career.jobs.create', compact('departments'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'department_id'  => 'nullable|integer',
            'job_location'   => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'type'           => 'nullable|string|max:100',
            'circular_date'  => 'nullable|date',
            'deadline'       => 'nullable|date',
            'experience'     => 'nullable|string|max:100',
            'image' => 'nullable|image|max:5120', // 5MB

        ]);

        $job = new Job();
        $job->title = $request->title;
        $job->slug = Str::slug($request->title);
        $job->department_id = $request->department_id;
        $job->job_location = $request->job_location;
        $job->description = $request->description;
        $job->type = $request->type;
        $job->circular_date = $request->circular_date;
        $job->deadline = $request->deadline;
        $job->experience = $request->experience;
        $job->status = 1;

        // image upload (optional)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/jobs/'), $name);
            $job->image = $name;
        }


        if ($job->save()) {
            $msg = __('Status Updated Successfully.');
            return redirect()->route('career.jobs')->with('success', $msg);
            //--- Redirect Section Ends
        } else {
            return back()->with('error', __('Something went wrong!'));
        }
    }


    //*** GET Request
    public function status($id1, $id2)
    {
        $data = Job::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    //*** JSON Request
    public function datatables(Request $request)
    {
        $query = Job::query()
            ->latest('id');

        if ($request->type == 'deactive') {
            $query->whereStatus(0);
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()

            ->addColumn('status', function (Job $data) {
                $class = $data->status ? 'drop-success' : 'drop-danger';
                return '
                <div class="action-list">
                    <select class="process select droplinks ' . $class . '">
                        <option data-val="1" value="' . route('career.job-status', [$data->id, 1]) . '" ' . ($data->status ? 'selected' : '') . '>' . __("Activated") . '</option>
                        <option data-val="0" value="' . route('career.job-status', [$data->id, 0]) . '" ' . (!$data->status ? 'selected' : '') . '>' . __("Deactivated") . '</option>
                    </select>
                </div>';
            })

            ->addColumn('action', function (Job $data) {

                return '
                <div class="godropdown">
                    <button class="go-dropdown-toggle"> ' . __("Actions") . ' <i class="fas fa-chevron-down"></i></button>
                    <div class="action-list">

                    <a href="' . route('career.job-details', $data->id) . '"  ><i class="fas fa-eye"></i> ' . __("View Job") . '</a>

                        <a href="' . route('career.job-edit', $data->id) . '"><i class="fas fa-edit"></i> ' . __("Edit") . '</a>

                        <a href="javascript:;" data-href="' . route('career.job-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete text-danger"><i class="fas fa-trash-alt"></i> ' . __("Delete") . '</a>
                    </div>
                </div>';
            })
            ->editColumn('department_id', function (Job $data) {
                return $data->department ? $data->department->name : 'N/A';
            })
            ->editColumn("circular_date", function (Job $data) {
                return date("d-M-Y", strtotime($data->circular_date));
            })
            ->editColumn("deadline", function (Job $data) {
                return date("d-M-Y", strtotime($data->deadline));
            })

            ->rawColumns(['status', 'department_id', 'circular_date', 'deadline', 'action'])
            ->toJson();
    }
    public function delete($id)
    {
        $data = Job::findOrFail($id);
        $data->delete();
        //--- Redirect Section

        $msg = __('Job Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    public function show($id)
    {
        $job = Job::findOrFail($id);
        return view('admin.career.jobs.details', compact('job'));
    }
    public function edit($id)
    {
        $departments = JobDepartment::where('status', 1)->get();
        $job = Job::findOrFail($id);
        return view('admin.career.jobs.edit', compact('job', 'departments'));
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'title'          => 'required|string|max:255',
            'department_id'     => 'nullable|integer',
            'job_location'       => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'type'           => 'nullable|string|max:100',
            'circular_date'  => 'nullable|date',
            'deadline'       => 'nullable|date',
            'experience'     => 'nullable|string|max:100',
            'image' => 'nullable|image|max:5120', // 5MB

        ]);

        $job = Job::findOrFail($id);
        $job->title = $request->title;
        $job->slug = Str::slug($request->title);
        $job->department_id = $request->department_id;
        $job->job_location = $request->job_location;
        $job->description = $request->description;
        $job->type = $request->type;
        $job->circular_date = $request->circular_date;
        $job->deadline = $request->deadline;
        $job->experience = $request->experience;

        // image upload (optional)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/jobs/'), $name);
            $job->image = $name;
        }
        $job->update();
        return redirect()->route('career.jobs')->with('success', __('Job Updated Successfully.'));
    }
}
