<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Routing\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        return view('Admin::pages.customers.index');
    }

    // Các hàm create, edit, show sẽ làm ở bước sau (CustomerDetail)
    public function show($id)
    {
        return view('Admin::pages.customers.show', compact('id')); // Truyền ID sang View
    }
    public function create()
    {
        return view('Admin::pages.customers.create');
    }
}