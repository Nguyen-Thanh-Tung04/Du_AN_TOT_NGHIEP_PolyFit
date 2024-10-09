<?php

return [
    'module' => [
        [
            'title' => 'Quản lý Tài Khoản',
            'icon' => 'fa fa-dashboard',
            'name' => ['user'],
            'subModule' => [
                [
                    'title' => 'Quản lý Vai Trò',
                    'route' => 'user/catalogue/index',
                ],
                [
                    'title' => 'Quản lý Thành Viên',
                    'route' => 'user/index',
                ],
                [
                    'title' => 'Quản lý Khách Hàng',
                    'route' => 'member/index',
                ],
            ],
        ],
        [
            'title' => 'Quản lý Danh mục',
            'icon' => 'fa fa-sitemap',
            'name' => ['category'],
            'subModule' => [
                [
                    'title' => 'Quản lý Danh Mục',
                    'route' => 'categories/index',
                ],
            ],
        ],
        [
            'title' => 'Quản lý Sản Phẩm',
            'icon' => 'fa fa-dashboard',
            'name' => ['product'],
            'subModule' => [
                [
                    'title' => 'Quản lý Sản Phẩm',
                    'route' => 'product/index',
                ],
                [
                    'title' => 'Quản lý Màu Sắc',
                    'route' => 'product/color/index',
                ],
                [
                    'title' => 'Quản lý Kích Cỡ',
                    'route' => 'product/size/index',
                ]
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
            'title' => 'Quản lý Khuyến ',
            'icon' => 'fa fa-money',
            'name' => ['vouchers'],
            'subModule' => [
                [
                    'title' => 'Quản lý Voucher',
                    'route' => 'vouchers/index',
                ],
            ],
        ],

        [
            'title' => 'Quản lý đánh giá',
            'icon' => 'fa fa-money',
            'name' => ['reviews'],
            'subModule' => [
                [
                    'title' => 'Quản lý đánh giá',
                    'route' => 'reviews/index',
                ],
            ],
        ]
    ]
];