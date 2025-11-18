<?php

return [
    [
        'label' => 'Dashboard',
        'icon' => 'fas fa-home',
        'route' => 'admin.dashboard',
        'permission' => 'view dashboard',
    ],
    [
        'label' => 'Người dùng',
        'icon' => 'fas fa-users',
        'permission' => 'manage users',
        'children' => [
            [
                'label' => 'Danh sách',
                'icon' => 'fas fa-list',
                'route' => 'admin.users.index',
                'permission' => 'view users',
            ],
            [
                'label' => 'Thêm mới',
                'icon' => 'fas fa-plus',
                'route' => 'admin.users.create',
                'permission' => 'create users',
            ],
        ],
    ],
    [
        'label' => 'Template HTML',
        'icon' => 'fas fa-home',
        'permission' => 'template-list',
        'children' => [
            [
                'label' => 'Dashboard',
                'icon' => 'fas fa-list',
                'route' => 'template.index',
                'permission' => 'template-list',
            ],
            [
                'label' => 'Form Add',
                'icon' => 'fas fa-plus',
                'route' => 'template.form-add',
                'permission' => 'template-list',
            ],
            [
                'label' => 'Form Basic',
                'icon' => 'fas fa-plus',
                'route' => 'template.form-basic',
                'permission' => 'template-list',
            ],
            [
                'label' => 'Form Select',
                'icon' => 'fas fa-plus',
                'route' => 'template.form-select',
                'permission' => 'template-list',
            ],
        ],
    ],
];
