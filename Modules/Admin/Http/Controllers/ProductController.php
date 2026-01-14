<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // Danh sách sản phẩm
    public function index()
    {
        return view('Admin::pages.products.index');
    }

    // Trang thêm mới
    public function create()
    {
        return view('Admin::pages.products.create');
    }

    // Trang chỉnh sửa
    public function edit($id)
    {
        return view('Admin::pages.products.edit', compact('id'));
    }
}
