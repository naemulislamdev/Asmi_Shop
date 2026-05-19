<?php

namespace App\Providers;

use App\Models\Branch;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\{
    Support\Facades\DB,
    Support\Collection,
    Support\ServiceProvider,
    Pagination\LengthAwarePaginator
};

use App\Models\Font;
use App\Models\Order;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Cache::flush();
        Paginator::useBootstrap();
        view()->composer('*', function ($view) {

            $view->with('gs', DB::table('generalsettings')->first());

            $view->with('ps', DB::table('pagesettings')->first());

            $view->with('seo', DB::table('seotools')->first());
            $view->with('socialsetting', DB::table('socialsettings')->first());

            $view->with('default_font', Font::whereIsDefault(1)->first());

            if (Session::has('currency')) {
                $view->with('curr', Currency::find(Session::get('currency')));
            } else {
                $view->with('curr', Currency::where('is_default', '=', 1)->first());
            }

            if (Session::has('language')) {
                $view->with('langg', Language::find(Session::get('language')));
            } else {
                $view->with('langg', Language::where('is_default', '=', 1)->first());
            }
            // $totalBranchOrders = Order::whereNotNull('branch_id')->count();

            // $branchWiseOrders = Order::select(
            //     'branch_id',
            //     DB::raw('COUNT(*) as total')
            // )
            //     ->whereNotNull('branch_id')
            //     ->with('branch')
            //     ->groupBy('branch_id')
            //     ->get();
            $totalBranchOrders = Order::count(); // সব orders

            // branch wise order
            $branchWiseOrders = Order::select(
                'branch_id',
                DB::raw('COUNT(*) as total')
            )
                ->groupBy('branch_id')
                ->get();

            // branch গুলো একবারে নাও
            $branchIds = $branchWiseOrders->pluck('branch_id')->filter()->unique()->values();
            $branchMap = Branch::whereIn('id', $branchIds)->get()->keyBy('id')->toArray();

            // result prepare করো
            $result = $branchWiseOrders->map(function ($item) use ($branchMap) {
                return [
                    'branch_id'   => $item->branch_id,
                    'total'       => $item->total,
                    'branch_name' => $item->branch_id
                        ? ($branchMap[$item->branch_id]['name'] ?? 'Unknown')
                        : null,
                ];
            });
            // branch wise order

            $orderCounts = Order::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'hold' THEN 1 ELSE 0 END) as hold,
            SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
        ")->first();

            $todayOrders = Order::whereDate('created_at', today())->where('status', 'pending')->count();

            $view->with([
                'orderCounts' => $orderCounts,
                'todayOrders' => $todayOrders,
                'totalBranchOrders' => $totalBranchOrders,
                'branchWiseOrders' => $result,
            ]);
        });
    }

    public function register()
    {
        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
