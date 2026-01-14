@extends('Admin::layouts.master')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Tổng quan hệ thống</h1>

    @livewire('admin.dashboard.stats-overview')

    <div class="mt-8">
        <p class="text-gray-500">Khu vực hiển thị biểu đồ hoặc danh sách đơn hàng mới nhất...</p>
    </div>
@endsection
