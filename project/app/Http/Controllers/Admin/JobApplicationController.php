<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class JobApplicationController extends Controller
{
    public function index()
    {
        return view('admin.career.applications.index');
    }
    public function datatable(Request $request)
    {
        $query = JobApplication::query()
            ->latest('id');

        // ✅ Date filter
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay()
            ]);
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('status', function (JobApplication $data) {

                if ($data->status == 'pending') {
                    $badge = 'warning';
                    $source = __('Pending');
                } elseif ($data->status == 'shortlisted') {
                    $badge = 'success';
                    $source = __('Shortlisted');
                } elseif ($data->status == 'rejected') {
                    $badge = 'danger';
                    $source = __('Rejected');
                } else {
                    $badge = 'dark';
                    $source = __('Unknown');
                }
                return '<div class="statusBadge_' . $data->id . '"><span class=" badge badge-' . $badge . '">' . $source . '</span></div>';
            })
            ->editColumn('applyed_date', function (JobApplication $data) {
                return date("d-M-Y", strtotime($data->created_at));
            })
            ->editColumn('cv', function (JobApplication $data) {
                $url = asset('assets/files/job_resume/' . $data->cv);
                $icon = asset('assets/front/images/cv.png');
                $title = 'View Resume / CV';
                // Return HTML string
                return '
                    <a href="' . $url . '"
                    class="btn btn-primary btn-sm"
                    target="_blank"
                    title="' . $title . '"
                    style="cursor: pointer;">
                        <img src="' . $icon . '" style="height: auto; width: 30px;" />
                    </a>
                ';
            })
            ->addColumn('action', function (JobApplication $data) {
                $cvUrl = asset('assets/files/job_resume/' . $data->cv);
                return '
    <div class="godropdown">
        <button class="go-dropdown-toggle"> ' . __("Actions") . ' <i class="fas fa-chevron-down"></i></button>
        <div class="action-list">

            <button
                class="btn btn-white btn-sm viewApplicationBtn"
                data-toggle="modal"
                data-target="#viewApplicationModal"
                data-full_name="' . $data->full_name . '"
                data-email="' . $data->email . '"
                data-phone="' . $data->phone . '"
                data-position="' . $data->position . '"
                data-cv="' . $cvUrl . '"
                data-experience="' . $data->experience . '"
                data-portfolio="' . $data->portfolio . '"
                data-status="' . $data->status . '"
            >
                <i class="fas fa-eye"></i> ' . __("View Application") . '
            </button>

            <a href="javascript:;" data-href="' . route('career.application-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete text-danger">
                <i class="fas fa-trash-alt"></i> ' . __("Delete") . '
            </a>

        </div>
    </div>';
            })

            ->addColumn('change_status', function ($row) {
                return '
            <select class="form-control form-control-sm changeStatus"
                 id="' . $row->id . '">
                <option class="text-warning" value="pending" ' . ($row->status == 'pending' ? 'selected' : '') . '>Pending</option>
                <option class="text-success" value="shortlisted" ' . ($row->status == 'shortlisted' ? 'selected' : '') . '>Shortlisted</option>
                <option class="text-danger" value="rejected" ' . ($row->status == 'rejected' ? 'selected' : '') . '>Rejected</option>
            </select>
        ';
            })

            ->rawColumns(['status', 'change_status', 'cv', 'department_id',  'action'])
            ->toJson();
    }
    public function status(Request $request)
    {

        if ($request->ajax()) {
            $app = JobApplication::find($request->id);
            $app->status = $request->status;
            $app->save();
            $data = $request->all();
            return response()->json($data);
        }
    }
    public function delete($id)
    {
        $data = JobApplication::findOrFail($id);

        if ($data->cv) {
            $cvPath = public_path('assets/files/job_resume/' . $data->cv);
            if (file_exists($cvPath)) {
                @unlink($cvPath);
            }
        }
        $data->delete();
        $msg = __('Application Deleted Successfully.');
        return response()->json(['success' => $msg]);
    }
}
