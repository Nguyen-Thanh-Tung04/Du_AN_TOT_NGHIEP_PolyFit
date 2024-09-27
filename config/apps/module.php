<?php

return [
    'module' => [
        [
            'title' => 'QL Thành Viên',
            'icon' => 'fa fa-dashboard',
            'name' => ['user'],
            'subModule' => [
                [
                    'title' => 'QL Chức Vụ',
                    'route' => 'user/catalogue/index',
                ],
                [
                    'title' => 'QL Thành Viên',
                    'route' => 'user/index',
                ],
            ],
        ],
        [
            'title' => 'QL Danh mục',
            'icon' => 'fa fa-sitemap',
            'name' => ['category'],
            'route' => 'categories/index',
        ],
        [
            'title' => 'Cấu hình chung',
            'icon' => 'fa fa-cog',
            'name' => ['language'],
            'subModule' => [
                [
                    'title' => 'QL Ngôn Ngữ',
                    'route' => 'language/index',
                ]
            ],
        ],

    ],
];