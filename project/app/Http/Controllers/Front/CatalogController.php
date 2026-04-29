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

        $minprice = $minprice ? ($minprice / $this->curr->value) : null;
        $maxprice = $maxprice ? ($maxprice / $this->curr->value) : null;

        $type = $request->has('type');

        // ======================
        // CATEGORY HANDLING
        // ======================
        if ($slug) {
            $cat = Category::where('slug', $slug)->firstOrFail();
            $data['cat'] = $cat;
        }

        if ($slug1) {
            $subcat = Subcategory::where('slug', $slug1)->firstOrFail();
            $data['subcat'] = $subcat;
        }

        if ($slug2) {
            $childcat = Childcategory::where('slug', $slug2)->firstOrFail();
            $data['childcat'] = $childcat;
        }

        // ======================
        // LATEST PRODUCTS
        // ======================
        $data['latest_products'] = Product::with('user')
            ->whereStatus(1)
            ->whereLatest(1)
            ->whereHas('user', fn($q) => $q->where('is_vendor', 2))
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->orderByDesc('updated_at')
            ->orderByDesc('stock')
            ->take(5)
            ->get();

        // ======================
        // MAIN QUERY
        // ======================
        $prods = Product::with('user')

            // CATEGORY FILTER
            ->when($cat, fn($q) => $q->where('category_id', $cat->id))
            ->when($subcat, fn($q) => $q->where('subcategory_id', $subcat->id))
            ->when($childcat, fn($q) => $q->where('childcategory_id', $childcat->id))

            // DISCOUNT FILTER
            ->when($type, function ($q) {
                return $q->whereStatus(1)
                    ->whereIsDiscount(1)
                    ->where('discount_date', '>=', now()->format('Y-m-d'))
                    ->whereHas('user', fn($u) => $u->where('is_vendor', 2));
            })

            // SEARCH
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "{$search}%");
                });
            })

            // PRICE FILTER
            ->when($minprice, fn($q) => $q->where('price', '>=', $minprice))
            ->when($maxprice, fn($q) => $q->where('price', '<=', $maxprice))

            // SORTING (PRIMARY)
            ->when($sort, function ($q) use ($sort) {

                switch ($sort) {
                    case 'date_desc':
                        $q->orderBy('id', 'desc');
                        break;

                    case 'date_asc':
                        $q->orderBy('id', 'asc');
                        break;

                    case 'price_desc':
                        $q->orderBy('price', 'desc');
                        break;

                    case 'price_asc':
                        $q->orderBy('price', 'asc');
                        break;

                    default:
                        $q->orderBy('id', 'desc');
                }
            }, function ($q) {
                $q->orderBy('id', 'desc');
            })

            // ======================
            // ⭐ STOCK ALWAYS LAST (MAIN FIX)
            // ======================
            ->orderByRaw('CASE WHEN COALESCE(stock, 0) = 0 THEN 1 ELSE 0 END')

            // OPTIONAL: stable ordering
            ->orderBy('stock', 'desc')

            // RATINGS
            ->withCount('ratings')
            ->withAvg('ratings', 'rating');

        // ======================
        // ATTRIBUTE FILTER
        // ======================
        $prods = $prods->where(function ($query) use ($cat, $subcat, $childcat, $request) {

            $applyFilter = function ($attributes) use ($query, $request) {
                foreach ($attributes as $attribute) {

                    $input = $attribute->input_name;
                    $filters = $request[$input] ?? null;

                    if ($filters) {
                        $query->where(function ($q) use ($filters) {
                            foreach ($filters as $i => $filter) {
                                if ($i == 0) {
                                    $q->where('attributes', 'like', '%' . "\"{$filter}\"" . '%');
                                } else {
                                    $q->orWhere('attributes', 'like', '%' . "\"{$filter}\"" . '%');
                                }
                            }
                        });
                    }
                }
            };

            if ($cat) $applyFilter($cat->attributes);
            if ($subcat) $applyFilter($subcat->attributes);
            if ($childcat) $applyFilter($childcat->attributes);
        });

        // ======================
        // FINAL PAGINATION
        // ======================
        $prods = $prods->where('status', 1)
            ->paginate($pageby ?? $this->gs->page_count);

        // PRICE OVERRIDE AFTER PAGINATION
        $prods->getCollection()->transform(function ($item) {
            $item->price = $item->vendorSizePrice();
            return $item;
        });

        $data['prods'] = $prods;

        // ======================
        // RESPONSE
        // ======================
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
