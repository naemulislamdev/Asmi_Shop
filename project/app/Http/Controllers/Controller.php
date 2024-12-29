<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $gs;
    protected $ps;
    protected $curr;
    protected $language;

    public function __construct()
    {
        $this->gs = DB::table('generalsettings')->first();

        // Set Global PageSettings

        $this->ps = DB::table('pagesettings')->first();


        $this->middleware(function ($request, $next) {

            if (Session::has('language')) {
                $this->language = Language::find(Session::get('language'));
            } else {
                $this->language = Language::where('is_default', '=', 1)->first();
            }

            if (Session::has('currency')) {
                $this->curr = Currency::find(Session::get('currency'));
            } else {
                $this->curr = Currency::where('is_default', '=', 1)->first();
            }

            view()->share('langg', $this->language);
            App::setlocale($this->language->name);


            // Set Popup

            if (!Session::has('popup')) {
                view()->share('visited', 1);
            }
            Session::put('popup', 1);


            return $next($request);
        });

    }
}
