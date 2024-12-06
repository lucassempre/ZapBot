<?php

return [

    's3' => [
        'credentials' => [
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
        ],
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'bucket' => env('AWS_BUCKET', 'files'),
        'endpoint' => env('AWS_S3_ENDPOINT', 'http://aws:4566/'),
        'use_path_style_endpoint' => env('AWS_S3_PATH_STYLE', true),
        'version' => env('AWS_S3_VERSION', 'latest')
    ]
];
