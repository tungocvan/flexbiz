<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;

use Livewire\Mechanisms\ComponentRegistry;

class EnvConfigController extends Controller
{
    public function index()
    {
        $registry = app(ComponentRegistry::class);

        // Danh sách các tab dự kiến
        $rawTabs = [
            ['id' => 'database', 'label' => 'Cơ sở dữ liệu', 'icon' => 'M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4', 'component' => 'admin.settings.database-config'],
            ['id' => 'mail', 'label' => 'Cấu hình Email', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'component' => 'admin.settings.mail-config'],
            ['id' => 'advanced', 'label' => 'Hệ thống & Queue', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'component' => 'admin.settings.advanced-config'],

        ];

        $tabs = collect($rawTabs)->map(function ($tab) use ($registry) {
            // Kiểm tra Class tồn tại thực tế
            $tab['is_ready'] = !is_null($registry->getClass($tab['component']));
            return $tab;
        });

        return view('Admin::pages.settings.env', compact('tabs'));
    }
}
