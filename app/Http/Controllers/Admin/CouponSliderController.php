<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CouponSlider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PriceHelper;

class CouponSliderController extends Controller
{
    public function datatables()
    {
        $datas = CouponSlider::orderBy('order', 'asc')->get();
        //--- Integrating This Collection Into Datatables
        return DataTables::of($datas)
            ->editColumn('image', function (CouponSlider $data) {
                $photo = $data->image ? url('assets/images/sliders/coupon/' . $data->image) : url('assets/images/noimage.png');
                return '<img src="' . $photo . '" alt="Image">';
            })

            ->editColumn('published', function (CouponSlider $data) {
                $class = $data->published == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->published == 1 ? 'selected' : '';
                $ns = $data->published == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks ' . $class . '"><option data-val="1" value="' . route('admin-coupon-slider-status', ['id1' => $data->id, 'id2' => 1]) . '" ' . $s . '>' . __("Activated") . '</option><option data-val="0" value="' . route('admin-coupon-slider-status', ['id1' => $data->id, 'id2' => 0]) . '" ' . $ns . '>' . __("Deactivated") . '</option>/select></div>';
            })
            ->addColumn('action', function (CouponSlider $data) {
                return '<div class="action-list"><a href="' . route('admin-coupon-slider-edit', $data->id) . '"> <i class="fas fa-edit"></i>' . __('Edit') . '</a><a href="javascript:;" data-href="' . route('admin-coupon-slider-delete', $data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
            })
            ->rawColumns(['image', 'published', 'action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.coupon_slider.index');
    }


    public function create()
    {
        return view('admin.coupon_slider.create');
    }

    public function status($id1, $id2)
    {
        $data = CouponSlider::findOrFail($id1);
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
            'image'      => 'required|mimes:jpeg,jpg,png,svg',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new CouponSlider();
        $input = $request->all();
        if ($file = $request->file('image')) {
            $name = PriceHelper::ImageCreateName($file);
            $file->move('assets/images/sliders/coupon/', $name);
            $input['image'] = $name;
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
        $data = CouponSlider::findOrFail($id);
        return view('admin.coupon_slider.edit', compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'image'      => 'mimes:jpeg,jpg,png,svg',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = CouponSlider::findOrFail($id);
        $input = $request->all();
        if ($file = $request->file('image')) {
            $name = PriceHelper::ImageCreateName($file);
            $file->move('assets/images/sliders/coupon/', $name);
            if ($data->image != null) {
                if (file_exists(public_path() . '/assets/images/sliders/coupon/' . $data->image)) {
                    unlink(public_path() . '/assets/images/sliders/coupon/' . $data->image);
                }
            }
            $input['image'] = $name;
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
        $data = CouponSlider::findOrFail($id);
        //If Photo Doesn't Exist
        if ($data->image == null) {
            $data->delete();
            //--- Redirect Section
            $msg = __('Data Deleted Successfully.');
            return response()->json($msg);
            //--- Redirect Section Ends
        }
        //If Photo Exist
        if (file_exists(public_path() . '/assets/images/sliders/coupon/' . $data->image)) {
            unlink(public_path() . '/assets/images/sliders/coupon/' . $data->image);
        }
        $data->delete();
        //--- Redirect Section
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
