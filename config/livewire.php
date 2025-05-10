<?php

return [
    'class_namespace' => 'App\\Http\\Livewire',
    'view_path' => resource_path('views/livewire'),
    'asset_url' => null,
    'middleware_group' => ['web', 'jwt.web'],
    'temporary_file_upload' => [
        'disk' => null,
        'rules' => ['file', 'max:12288'], // 12MB
        'directory' => 'livewire-tmp',
    ],
    'manifest_path' => null,
];