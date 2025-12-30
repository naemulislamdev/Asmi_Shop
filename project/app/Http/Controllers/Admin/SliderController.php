<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PriceHelper;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends AdminBaseController
{

    public function datatables()
    {
        $datas = Slider::orderBy('order', 'asc')->get();
        //--- Integrating This Collection Into Datatables
        return DataTables::of($datas)
            ->editColumn('photo', function (Slider $data) {
                $photo = $data->photo ? url('assets/images/sliders/' . $data->photo) : url('assets/images/noimage.png');
                return '<img src="' . $photo . '" alt="Image">';
            })
            // ->editColumn('title', function (Slider $data) {
            //     $title = mb_strlen(strip_tags($data->title), 'UTF-8') > 250 ? mb_substr(strip_tags($data->title), 0, 250, 'UTF-8') . '...' : strip_tags($data->title);
            //     return  $title;
            // })
            ->editColumn('published', function (Slider $data) {
                $class = $data->published == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->published == 1 ? 'selected' : '';
                $ns = $data->published == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-sl-status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-sl-status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option>/select></div>';
            })
            ->addColumn('action', function (Slider $data) {
                return '<div class="action-list"><a href="' . route('admin-sl-edit', $data->id) . '"> <i class="fas fa-edit"></i>' . __('Edit') . '</a><a href="javascript:;" data-href="' . route('admin-sl-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['photo', 'published', 'action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.slider.index');
    }


    public function create()
    {
        return view('admin.slider.create');
    }

    public function status($id1, $id2)
    {
        $data = Slider::findOrFail($id1);
        $data->published = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'photo'      => 'required|mimes:jpeg,jpg,png,svg',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Slider();
        $input = $request->all();
        if ($file = $request->file('photo')) {
            $name = PriceHelper::ImageCreateName($file);
            $file->move('assets/images/sliders', $name);
            $input['photo'] = $name;
        }
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('New Data Added Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'photo'      => 'mimes:jpeg,jpg,png,svg',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Slider::findOrFail($id);
        $input = $request->all();
        if ($file = $request->file('photo')) {
            $name = PriceHelper::ImageCreateName($file);
            $file->move('assets/images/sliders', $name);
            if ($data->photo != null) {
                if (file_exists(public_path() . '/assets/images/sliders/' . $data->photo)) {
                    unlink(public_path() . '/assets/images/sliders/' . $data->photo);
                }
            }
            $input['photo'] = $name;
        }
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Slider::findOrFail($id);
        //If Photo Doesn't Exist
        if ($data->photo == null) {
            $data->delete();
            //--- Redirect Section
            $msg = __('Data Deleted Successfully.');
            return response()->json($msg);
            //--- Redirect Section Ends
        }
        //If Photo Exist
        if (file_exists(public_path() . '/assets/images/sliders/' . $data->photo)) {
            unlink(public_path() . '/assets/images/sliders/' . $data->photo);
        }
        $data->delete();
        //--- Redirect Section
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
