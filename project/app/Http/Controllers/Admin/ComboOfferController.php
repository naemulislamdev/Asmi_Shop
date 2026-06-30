<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComboOffer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComboOfferController extends Controller
{
    public function index()
    {
        $offers = ComboOffer::all();
        return view('admin.combo-offer.index', compact('offers'));
    }
    public function create()
    {
        $products =  Product::where('status', 1)->get();
        return view('admin.combo-offer.create', compact('products'));
    }
public function store(Request $request)
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'product_ids' => 'required|array|min:1',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $image     = $request->file('image');
        $filename  = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move('assets/images/combo-offers', $filename);
        $imagePath = $filename;
    }

    $slug = \Illuminate\Support\Str::slug($request->title) . '-' . time();

    ComboOffer::create([
        'title'       => $request->title,
        'slug'        => $slug,
        'image'       => $imagePath,
        'product_ids' => json_encode($request->product_ids),
    ]);

    return redirect()->route('admin.combo-offer.index')
        ->with('success', 'Combo offer created successfully!');
}

public function update(Request $request, $id)
{
    $offer = ComboOffer::findOrFail($id);

    $request->validate([
        'title'       => 'required|string|max:255',
        'product_ids' => 'required|array|min:1',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
    ]);

    $imagePath = $offer->image;
    if ($request->hasFile('image')) {
        if ($offer->image && file_exists('assets/images/combo-offers/' . $offer->image)) {
            unlink('assets/images/combo-offers/' . $offer->image);
        }
        $image     = $request->file('image');
        $filename  = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move('assets/images/combo-offers', $filename);
        $imagePath = $filename;
    }

    $offer->update([
        'title'       => $request->title,
        'slug'        => Str::slug($request->slug ? $request->slug : $request->title),
        'image'       => $imagePath,
        'product_ids' => json_encode($request->product_ids),
    ]);

    return redirect()->route('admin.combo-offer.index')
        ->with('success', 'Combo offer updated successfully!');
}
    public function status($id1, $id2)
    {

        $data = ComboOffer::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }
    public function edit($id)
    {
        $products =  Product::where('status', 1)->get();

        $offer = ComboOffer::find($id);
        if ($offer) {
            return view('admin.combo-offer.edit', compact('products', 'offer'));
        } else {
            return redirect()->back();
        }
    }
  
   public function destroy($id)
{
    $offer = ComboOffer::findOrFail($id);
    if ($offer->image && file_exists('assets/images/combo-offers/' . $offer->image)) {
        unlink('assets/images/combo-offers/' . $offer->image);
    }
    $offer->delete();

    $msg = __('Offer Deleted Successfully.');
    return redirect()->back()->with('success', $msg);
}

public function removeImage($id)
{
    $offer = ComboOffer::findOrFail($id);

    if ($offer->image && file_exists('assets/images/combo-offers/' . $offer->image)) {
        unlink('assets/images/combo-offers/' . $offer->image);
    }

    $offer->image = null;
    $offer->save();

    $msg = __('Offer Image Deleted Successfully.');
    return redirect()->back()->with('success', $msg);
}
}
