<?php

return [
    'default' => [
        'folder_name' => 'product',
        'public_relative' => 'product/',
        'path' => 'files/product',
        'full_path' => storage_path('app/product'),
    ],

    'users' => [
        'folder_name' => 'users',
        'public_relative' => 'users/',
        'path' => 'files/users',
        'full_path' => storage_path('app/users'),
    ],
    'images' => [
        'user' => [
            'folder_name' => 'public/images/users',
            'public_relative' => 'storage/images/users',
            'path' => 'app/public/images',
            'full_path' => storage_path('app/public/images/users'),
            'width' => 1080,
            'height' => 600,
            'thumb' => [
                'width' => 400,
                'height' => 350,
            ],
        ],
        'user_profile' => [
            'folder_name' => 'public/images/users',
            'public_relative' => 'storage/images/users',
            'path' => 'app/public/images',
            'full_path' => storage_path('app/public/images/users'),
            'width' => 1080,
            'height' => 600,
            'thumb' => [
                'width' => 400,
                'height' => 350,
            ],
        ],
        'dare' => [
            'folder_name' => 'public/images/dares',
            'public_relative' => 'storage/images/dares',
            'path' => 'app/public/images/dares',
            'full_path' => storage_path('app/public/images/dares'),
            'width' => 1080,
            'height' => 600,
            'thumb' => [
                'width' => 400,
                'height' => 350,
            ],
        ],
        'event' => [
            'folder_name' => 'public/images/events',
            'public_relative' => 'storage/images/events',
            'path' => 'app/public/images/events',
            'full_path' => storage_path('app/public/images/events'),
            'width' => 1080,
            'height' => 600,
            'thumb' => [
                'width' => 450,
                'height' => 375,
            ],
        ],

        'folder_name' => 'images',
        'public_relative' => 'images/',
        'path' => 'app/images',
        'full_path' => storage_path('app/images'),
        'width' => 1080,
        'height' => 600,
        'thumbnails' => [
            'width' => 360,
            'height' => 200,
        ],
    ],
    'issues' => [
        'folder_name' => 'issues',
        'public_relative' => 'issues/',
        'path' => 'files/issues',
        'full_path' => storage_path('app/issues'),
    ],
];