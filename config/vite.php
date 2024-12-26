<?php

$publicPath = '/home/u521981000/domains/derroce.com/public_html/cinetech';

return [
    'paths' => [
        'build' => '/cinetech/build',
        'manifest' => $publicPath . '/build/.vite/manifest.json',
    ],
    
    'dev_server' => [
        'enabled' => env('VITE_DEV_SERVER_ENABLED', false),
        'url' => env('VITE_DEV_SERVER_URL', 'http://localhost:5173'),
    ],

    'manifest_path' => $publicPath . '/build/.vite/manifest.json',
    'public_path' => $publicPath,
];