<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VendorBaseController extends Controller
{
    protected $gs;
    protected $curr;
    protected $language_id;
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');

        // Set Global GeneralSettings

        $this->gs = DB::table('generalsettings')->find(1);

        $this->middleware(function ($request, $next) {

        // Set Global Users

        $this->user = Auth::user();

            // Set Global Language

            // Set Global Language

            if (Session::has('language'))
            {
                $this->language = DB::table('languages')->find(Session::get('language'));
            }
            else
            {
                $this->language = DB::table('languages')->where('is_default','=',1)->first();
            }
            view()->share('langg', $this->language);
            App::setlocale($this->language->name);

            // Set Global Currency

            $this->curr = DB::table('currencies')->where('is_default','=',1)->first();


            return $next($request);
        });
    }
}
