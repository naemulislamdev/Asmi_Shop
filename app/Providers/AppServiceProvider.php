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
            // Compute shared view globals ONCE per request (was ~12 queries per partial).
            if (app()->bound('asmi.viewglobals')) {
                $view->with(app('asmi.viewglobals'));
                return;
            }

            $d = [];
            $d['gs'] = DB::table('generalsettings')->first();
            $d['ps'] = DB::table('pagesettings')->first();
            $d['seo'] = DB::table('seotools')->first();
            $d['socialsetting'] = DB::table('socialsettings')->first();
            $d['default_font'] = Font::whereIsDefault(1)->first();

            if (Session::has('currency')) {
                $d['curr'] = Currency::find(Session::get('currency'));
            } else {
                $d['curr'] = Currency::where('is_default', '=', 1)->first();
            }

            if (Session::has('language')) {
                $d['langg'] = Language::find(Session::get('language'));
            } else {
                $d['langg'] = Language::where('is_default', '=', 1)->first();
            }

            $d['totalBranchOrders'] = Order::count();

            // branchWiseOrders MUST be Order objects with the `branch` relation:
            // admin super.blade.php reads $item->branch_id and $item->branch->name.
            $d['branchWiseOrders'] = Order::select('branch_id', DB::raw('COUNT(*) as total'))
                ->with('branch')
                ->groupBy('branch_id')
                ->get();

            $d['orderCounts'] = Order::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'hold' THEN 1 ELSE 0 END) as hold,
                SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
            ")->first();

            $d['todayOrders'] = Order::whereDate('created_at', today())->where('status', 'pending')->count();

            app()->instance('asmi.viewglobals', $d);
            $view->with($d);
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