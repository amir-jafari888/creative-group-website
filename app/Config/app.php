<?php

declare(strict_types=1);

$environment = getenv('APP_ENV');

return [
    'environment' => $environment !== false ? $environment : 'development',

    // Local XAMPP project URL: http://localhost/my-project/
    'base_url' => '/my-project',

    'vite_dev_server' => 'http://localhost:5173',

    'manifest_path' => dirname(__DIR__, 2) . '/assets/build/manifest.json',
];
