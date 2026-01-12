<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('Website::products.index');
    }

    public function show($slug)
    {
        return view('Website::products.show', compact('slug'));
    }
}
