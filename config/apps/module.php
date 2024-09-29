<?php

return [
    'module' => [
        [
            'title' => 'QL Người Dùng',
            'icon' => 'fa fa-dashboard',
            'name' => ['user'],
            'subModule' => [
                [
                    'title' => 'QL Vai Trò',
                    'route' => 'user/catalogue/index',
                ],
                [
                    'title' => 'QL Người dùng',
                    'route' => 'user/index',
                ],
            ],
        ],
        [
            'title' => 'QL Sản Phẩm',
            'icon' => 'fa fa-dashboard',
            'name' => ['user'],
            'subModule' => [
                [
                    'title' => 'QL Sản Phẩm',
                    'route' => 'product/index',
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
    ],
];