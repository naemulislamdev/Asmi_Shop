<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Product;
use App\Models\Report;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CatalogController extends Controller
{

    // CATEGORIES SECTOPN

    public function categories()
    {
        $categories = Category::where('status', 1)->get();
        return view('frontend.products', compact('categories'));
    }

    // -------------------------------- CATEGORY SECTION ----------------------------------------

    
    public function category(Request $request, $slug = null, $slug1 = null, $slug2 = null, $slug3 = null)
    {
        $data['categories'] = Category::where('status', 1)->get();

        if ($request->view_check) {
            session()->put('view', $request->view_check);
        }

        $cat = null;
        $subcat = null;
        $childcat = null;

        $minprice = $request->min;
        $maxprice = $request->max;
        $sort     = $request->sort;
        $search   = $request->search;
        $pageby   = $request->pageby;

        $minprice = ($minprice / $this->curr->value);
        $maxprice = ($maxprice / $this->curr->value);
        $type     = $request->has('type');

        // Category 
        if (!empty($slug)) {
            $cat = Category::where('slug', $slug)->firstOrFail();
            $data['cat'] = $cat;
        }

        if (!empty($slug1)) {
            $subcat = Subcategory::where('slug', $slug1)->firstOrFail();
            $data['subcat'] = $subcat;
        }

        if (!empty($slug2)) {
            $childcat = Childcategory::where('slug', $slug2)->firstOrFail();
            $data['childcat'] = $childcat;
        }

        // Latest Products
        $data['latest_products'] = Product::with('user')
            ->whereStatus(1)
            ->whereLatest(1)
            ->whereHas('user', function ($q) {
                $q->where('is_vendor', 2);
            })
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->orderByDesc('updated_at')
            ->orderByDesc('stock')
            ->take(5)
            ->get();

        // Main Query
       $prods = Product::with('user')

    // ✅ Category Filters
    ->when($cat, fn($q) => $q->where('category_id', $cat->id))
    ->when($subcat, fn($q) => $q->where('subcategory_id', $subcat->id))
    ->when($childcat, fn($q) => $q->where('childcategory_id', $childcat->id))

    // ✅ Type Filter
    ->when($type, function ($q) {
        return $q->whereStatus(1)
            ->whereIsDiscount(1)
            ->where('discount_date', '>=', date('Y-m-d'))
            ->whereHas('user', function ($user) {
                $user->where('is_vendor', 2);
            });
    })

    // ✅ Search (FIXED OR CONDITION)
    ->when($search, function ($q, $search) {
        $q->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', $search . '%');
        });
    })

    // ✅ Price Filter
    ->when($minprice, fn($q) => $q->where('price', '>=', $minprice))
    ->when($maxprice, fn($q) => $q->where('price', '<=', $maxprice));


// =========================
// ✅ Attribute Filter
// =========================
$prods = $prods->where(function ($query) use ($cat, $subcat, $childcat, $request) {

    $applyFilter = function ($attributes) use ($query, $request) {
        foreach ($attributes as $attribute) {
            $input = $attribute->input_name;
            $filters = $request[$input];

            if (!empty($filters)) {
                $query->where(function ($q) use ($filters) {
                    foreach ($filters as $i => $val) {
                        if ($i == 0) {
                            $q->where('attributes', 'like', '%"' . $val . '"%');
                        } else {
                            $q->orWhere('attributes', 'like', '%"' . $val . '"%');
                        }
                    }
                });
            }
        }
    };

    if (!empty($cat)) {
        $applyFilter($cat->attributes);
    }

    if (!empty($subcat)) {
        $applyFilter($subcat->attributes);
    }

    if (!empty($childcat)) {
        $applyFilter($childcat->attributes);
    }
});


// =========================
// ✅ Final Query
// =========================
$prods = $prods
    ->where('status', 1)
    ->where('is_offer_active', 0)

    // 🔥 STOCK FIX (OUT OF STOCK LAST)
    ->orderByRaw("CASE WHEN stock IS NULL OR stock = 0 THEN 1 ELSE 0 END ASC")

    // ✅ Sorting
    ->when($sort, function ($q, $sort) {
        if ($sort == 'date_desc') {
            $q->orderByDesc('id');
        } elseif ($sort == 'date_asc') {
            $q->orderBy('id');
        } elseif ($sort == 'price_desc') {
            $q->orderByDesc('price');
        } elseif ($sort == 'price_asc') {
            $q->orderBy('price');
        }
    }, function ($q) {
        // default sort
        $q->orderByDesc('id');
    })

    ->withCount('ratings')
    ->withAvg('ratings', 'rating')

    ->paginate($pageby ?? $this->gs->page_count);


// =========================
// ✅ Modify Collection
// =========================
$prods->getCollection()->transform(function ($item) {
    $item->price = $item->vendorSizePrice();
    return $item;
});


// =========================
// ✅ Return Data
// =========================
$data['prods'] = $prods;

if ($request->ajax()) {
    $data['ajax_check'] = 1;
    return view('frontend.ajax.category', $data);
}

        return view('frontend.products', $data);
    }
   public function homeSearch(Request $request)
{
    $request->validate([
        'search' => 'nullable|string|max:100'
    ]);

    $keyword = strip_tags($request->search);

    $products = Product::where('status', 1)
        ->where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('sku', 'like', "%{$keyword}%");
        })
        ->paginate(20);

    return view('frontend.search', compact('products', 'keyword'));
}

public function ajaxSearch(Request $request)
{
    $request->validate([
        'q' => 'nullable|string|max:100'
    ]);

    $keyword = strip_tags($request->query('q'));

    $products = Product::where('status', 1)
        ->where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('sku', 'like', "%{$keyword}%");
        })
        ->where('is_offer_active', 0)
        ->get(['id', 'name', 'slug', 'price', 'thumbnail', 'photo']);

    return response()->json($products);
}

    public function getsubs(Request $request)
    {
        $category = Category::where('slug', $request->category)->firstOrFail();
        $subcategories = Subcategory::where('category_id', $category->id)->get();
        return $subcategories;
    }
    public function report(Request $request)
    {

        //--- Validation Section
        $rules = [
            'note' => 'max:400',
        ];
        $customs = [
            'note.max' => 'Note Must Be Less Than 400 Characters.',
        ];

        $request->validate($rules, $customs);


        $data = new Report;
        $input = $request->all();
        $data->fill($input)->save();
        return back()->with('success', 'Report has been sent successfully.');
    }
}
