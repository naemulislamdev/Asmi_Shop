<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashDeal;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashDealController extends Controller
{
    public function index()
    {
        $flashDeals = FlashDeal::all();
        return view('admin.flash-deal.index', compact('flashDeals'));
    }

    public function create()
    {
        $products = Product::where('status', 1)->get();
        return view('admin.flash-deal.create', compact('products'));
    }

    public function store(Request $request)
    {

        // Validate and store the flash deal
        $request->validate([
            'deal_title' => 'required|string|max:255',
            'deal_subtitle' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'deal_products' => 'required|array',
            'deal_products.*' => 'exists:products,id',
        ]);

        // Store the flash deal
        FlashDeal::create([
            'title' => $request->deal_title,
            'subtitle' => $request->deal_subtitle,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'products' => json_encode($request->deal_products),
            'status' => $request->status,
        ]);
        return redirect()->route('admin-flash-deal-index')->with('success', 'Flash Deal created successfully.');
    }

    public function edit($id)
    {
        $flashDeal = FlashDeal::findOrFail($id);
        $products = Product::where('status', 1)->get();
        return view('admin.flash-deal.edit', compact('flashDeal', 'products'));
    }

    public function update(Request $request, $id)
    {
        // Validate and update the flash deal
        $request->validate([
            'deal_title' => 'required|string|max:255',
            'deal_subtitle' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'deal_products' => 'required|array',
            'deal_products.*' => 'exists:products,id',
        ]);

        // Update the flash deal
        $flashDeal = FlashDeal::findOrFail($id);
        $flashDeal->update([
            'title' => $request->deal_title,
            'subtitle' => $request->deal_subtitle,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'products' => json_encode($request->deal_products),
            'status' => $request->status,
        ]);
        return redirect()->route('admin-flash-deal-index')->with('success', 'Flash Deal updated successfully.');
    }

    public function destroy($id)
    {
        // Delete the flash deal
        $flashDeal = FlashDeal::findOrFail($id);
        $flashDeal->delete();
        return redirect()->route('admin-flash-deal-index')->with('success', 'Flash Deal deleted successfully.');
    }
}
