<?php

namespace Modules\Website\Http\Controllers;

use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function index(?string $categorySlug = null)
    {

        return view('Website::products.index', compact('categorySlug'));
    }

    public function show(string $slug)
    {
        return view('Website::products.show', compact('slug'));
    }
}
