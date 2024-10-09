<?php

return [
    'module' => [
        [
            'title' => 'QL Tài Khoản',
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
            'title' => 'QL Sản Phẩm',
            'icon' => 'fa fa-dashboard',
            'name' => ['product'],
            'subModule' => [
                [
                    'title' => 'QL Sản Phẩm',
                    'route' => 'product/index',
                ],
                [
                    'title' => 'QL Màu Sắc',
                    'route' => 'product/color/index',
                ],
                [
                    'title' => 'QL Kích Cỡ',
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
            'title' => 'QL Khuyến ',
            'icon' => 'fa fa-money',
            'name' => ['vouchers'],
            'subModule' => [
                [
                    'title' => 'QL Voucher',
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
        ],
        [
            'title' => 'Quản lý Đơn hàng',
            'icon' => 'fa fa-money',
            'name' => ['orders'],
            'subModule' => [
                [
                    'title' => 'Quản lý Đơn hàng',
                    'route' => 'orders/index',
                ],
            ],
        ]

    ]
];
