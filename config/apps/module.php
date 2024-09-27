<?php

return [
    'module' => [
        [
            'title' => 'QL Người dùng',
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
            'title' => 'QL Danh Mục',
            'icon' => 'fa fa-cog',
            'name' => ['category'],
            'subModule' => [
                [
                    'title' => 'QL Danh Mục',
                    'route' => 'category/index',
                ]
            ],
        ],
        
    ],
];
