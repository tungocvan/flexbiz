<?php

namespace Modules\Website\Http\Controllers;

use Illuminate\Routing\Controller;

class CartController extends Controller
{
    public function index()
    {
        return view('Website::cart.index');
    }
}
