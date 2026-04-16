<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    public function index()
    {
        return view("frontend.pharmacy.index");
    }
    public function productDetails()
    {
        return view("frontend.pharmacy.details");
    }
}
