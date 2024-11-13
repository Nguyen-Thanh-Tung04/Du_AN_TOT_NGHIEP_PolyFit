<?php

return [
    'module' => [
        [
            'title' => 'Quản lý Tài Khoản',
            'icon' => 'fa fa-group',
            'name' => ['user', 'member', 'permission'],
            'subModule' => [
                [
                    'title' => 'Quản lý Chức Vụ',
                    'route' => 'user/catalogue/index',
                ],
                [
                    'title' => 'Quản lý Nhân Viên',
                    'route' => 'user/index',
                ],
                [
                    'title' => 'Quản lý Khách Hàng',
                    'route' => 'member/index',
                ],
                [
                    'title' => 'Quản lý Quyền',
                    'route' => 'permission/index',
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
            'icon' => 'fa fa-shopping-cart',
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
            'icon' => 'fa fa-star',
            'name' => ['reviews'],
            'subModule' => [
                [
                    'title' => 'Quản lý đánh giá',
                    'route' => 'reviews/index',
                ],
                [
                    'title' => 'Lịch sử đánh giá',
                    'route' => 'reviews/history',
                ]
            ],
        ],
        [
            'title' => 'Quản lý Đơn hàng',
            'icon' => 'fa fa-shopping-cart',
            'name' => ['orders'],
            'subModule' => [
                [
                    'title' => 'Quản lý Đơn hàng',
                    'route' => 'orders/index',
                ],
            ],
        ],
        [
            'title' => 'Quản lý Banner',
            'icon' => 'fa fa-picture-o',
            'name' => ['banners'],
            'subModule' => [
                [
                    'title' => 'Quản lý Banner',
                    'route' => 'banners/index',
                ],
            ],
        ]

    ]
];
