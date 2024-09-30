<?php

return [
    'module' => [
        [
            'title' => 'QL Tài khoản',
            'icon' => 'fa fa-dashboard',
            'name' => ['user'],
            'subModule' => [
                [
                    'title' => 'QL Vai Trò',
                    'route' => 'user/catalogue/index',
                ],
                [
                    'title' => 'QL Thành Viên',
                    'route' => 'user/index',
                ],
                [
                    'title' => 'QL Khách Hàng',
                    'route' => 'member/index',
                ],
            ],
        ],
        [
            'title' => 'Mẫu CRUD',
            'icon' => 'fa fa-dashboard',
            'name' => ['crud'],
            'subModule' => [
                [
                    'title' => 'Mẫu CRUD',
                    'route' => 'crud/index',
                ],
            ],
        ],
        [
            'title' => 'QL Danh mục',
            'icon' => 'fa fa-sitemap',
            'name' => ['category'],
            'subModule' => [
                [
                    'title' => 'QL Danh Mục',
                    'route' => 'categories/index',
                ],
            ],
        ],
        [
            'title' => 'QL Voucher',
            'icon' => 'fa fa-sitemap',
            'name' => ['vouchers'],
            'subModule' => [
                [
                    'title' => 'QL Voucher',
                    'route' => 'vouchers/index',
                ],
            ],
        ],
    ],
];
