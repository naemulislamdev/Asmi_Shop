<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConditionalOffer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


class ConditionalOfferController extends Controller
{
    public function index()
    {
        $offers = ConditionalOffer::orderByDesc('created_at')
            ->get();
        return view('admin.conditional_offers.index', compact('offers'));
    }
    public function create()
    {
        $products = Product::all();
        return view('admin.conditional_offers.create', compact('products'));
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'min_purchase_amount' => 'required|numeric|min:1',
            'max_uses_per_order'  => 'required|integer|min:1',
            'offer_quantity'      => 'required|integer|min:1',
            // arrays
            'offer_amount'       => 'required|array',
            'offer_product_sku'      => 'required|array',
            'starts_at'          => 'nullable|date',
            'ends_at'            => 'nullable|date|after_or_equal:starts_at',

            'excluded_sku'      => 'nullable|array',
        ]);

        $offer_product = [];

        foreach ($request->offer_product_sku as $index => $product) {
            $offer_product[] = [
                'amount'  => $validated['offer_amount'][$index] ?? 0,
                'sku'  => $product,
            ];
        }

        ConditionalOffer::create([
            'name'                => $validated['name'],
            'min_purchase_amount' => $validated['min_purchase_amount'],
            'offer_quantity'      => $validated['offer_quantity'],
            'is_active'           => $request->boolean('is_active', true),
            'starts_at'           => $validated['starts_at'] ?? null,
            'ends_at'             => $validated['ends_at'] ?? null,
            'max_uses_per_order'  => $validated['max_uses_per_order'],
            'offer_products' => json_encode($offer_product),
            'excluded_sku' => json_encode($request->excluded_sku),


        ]);

        return redirect()
            ->route('admin-conditional-offer-index')
            ->with('success', 'Offer তৈরি হয়েছে।');
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────
    public function edit($id)
    {
        $products = Product::orderBy('name')->get(['id', 'name', 'sku']);
        $offer    = ConditionalOffer::findOrFail($id);

        return view('admin.conditional_offers.edit', compact('offer', 'products'));
    }

    public function update(Request $request, $id)
    {
        $offer = ConditionalOffer::findOrFail($id);

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'min_purchase_amount' => 'required|numeric|min:1',
            'max_uses_per_order'  => 'required|integer|min:1',
            'offer_quantity'      => 'required|integer|min:1',

            // arrays
            'offer_amount'        => 'required|array',
            'offer_product_sku'   => 'required|array',

            'starts_at'           => 'nullable|date',
            'ends_at'             => 'nullable|date|after_or_equal:starts_at',

            'excluded_sku'        => 'nullable|array',
        ]);

        // 🔥 combine amount + sku
        $offer_product = [];

        foreach ($request->offer_product_sku as $index => $sku) {

            // empty row skip (important for edit page)
            if (!$sku) continue;

            $offer_product[] = [
                'amount' => $validated['offer_amount'][$index] ?? 0,
                'sku'    => $sku,
            ];
        }

        // ✅ update
        $offer->update([
            'name'                => $validated['name'],
            'min_purchase_amount' => $validated['min_purchase_amount'],
            'offer_quantity'      => $validated['offer_quantity'],
            'max_uses_per_order'  => $validated['max_uses_per_order'],
            'is_active'           => $request->boolean('is_active', true),

            'starts_at'           => $validated['starts_at'] ?? null,
            'ends_at'             => $validated['ends_at'] ?? null,

            'offer_products'      => json_encode($offer_product),
            'excluded_sku'        => json_encode($request->excluded_sku ?? []),
        ]);

        return redirect()
            ->route('admin-conditional-offer-index')
            ->with('success', 'Offer আপডেট হয়েছে।');
    }

    // ─── Toggle active status (quick AJAX) ───────────────────────────────────

    public function status($id1, $id2)
    {

        $data = ConditionalOffer::findOrFail($id1);
        $data->is_active = $id2;
        $data->update();
        //--- Redirect Section
        $msg = __('Status Updated Successfully.');
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    // ─── Delete ───────────────────────────────────────────────────────────────

    public function destroy($id)
    {


        $conditionalOffer = ConditionalOffer::findOrFail($id);
        $conditionalOffer->delete();

        $msg = __('Offer Deleted Successfully.');
        return redirect()->back()->with('success', $msg);
    }
}
