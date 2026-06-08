<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PromoOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoOffersController extends Controller
{
    public function index()
    {
        $promoOffers = PromoOffer::all();
        return view('admin.promo_offers.index', compact('promoOffers'));
    }

    public function create()
    {
        $products = Product::where('status', 1)->get();
        return view('admin.promo_offers.create', compact('products'));
    }

    public function store(Request $request)
    {

        // Validate and store the flash deal
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'promo_products' => 'required|array',
            'promo_products.*' => 'exists:products,id',
        ]);

        $imagePath = null;
        $bgImagePath = null;
        $image = $request->file('image');
        if ($image) {
            $name = time() . Str::random(8) . '.' .  $image->getClientOriginalExtension();
            $image->move('assets/images/promo-offers', $name);
            $imagePath = $name;
        }
        $bg_image = $request->file('bg_image');
        if ($bg_image) {
            $name = time() . Str::random(8) . '.' . $bg_image->getClientOriginalExtension();
            $bg_image->move('assets/images/promo-offers', $name);
            $bgImagePath = $name;
        }

        // Store the flash deal
        PromoOffer::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'subtitle' => $request->subtitle,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'image' => $imagePath,
            'bg_image' => $bgImagePath,
            'products' => json_encode($request->promo_products),
            'status' => $request->status,
        ]);
        return redirect()->route('admin-promo-offer-index')->with('success', 'Promo Offer created successfully.');
    }

    public function edit($id)
    {
        $promoOffer = PromoOffer::findOrFail($id);
        $products = Product::where('status', 1)->get();
        return view('admin.promo_offers.edit', compact('promoOffer', 'products'));
    }

    public function update(Request $request, $id)
    {
        // Validate and update the flash deal
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'promo_products' => 'required|array',
            'promo_products.*' => 'exists:products,id',
        ]);
        $imagePath = null;
        $bgImagePath = null;
        $image = $request->file('image');
        if ($image) {
            $name = time() . Str::random(8) . '.' .  $image->getClientOriginalExtension();
            $image->move('assets/images/promo-offers', $name);
            $imagePath = $name;
        }
        $bg_image = $request->file('bg_image');
        if ($bg_image) {
            $name = time() . Str::random(8) . '.' . $bg_image->getClientOriginalExtension();
            $bg_image->move('assets/images/promo-offers', $name);
            $bgImagePath = $name;
        }

        // Update the flash deal
        $promoOffer = PromoOffer::findOrFail($id);
        $promoOffer->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'image' => $imagePath ?? $promoOffer->image,
            'bg_image' => $bgImagePath ?? $promoOffer->bg_image,
            'products' => json_encode($request->promo_products),
            'status' => $request->status,
        ]);
        return redirect()->route('admin-promo-offer-index')->with('success', 'Promo Offer updated successfully.');
    }

    public function destroy($id)
    {
        // Delete the flash deal
        $promoOffer = PromoOffer::findOrFail($id);
        if ($promoOffer->image) {
            @unlink(public_path('assets/images/promo-offers/' . $promoOffer->image));
        }
        if ($promoOffer->bg_image) {
            @unlink(public_path('assets/images/promo-offers/' . $promoOffer->bg_image));
        }
        $promoOffer->delete();
        return redirect()->route('admin-promo-offer-index')->with('success', 'Promo Offer deleted successfully.');
    }
}
