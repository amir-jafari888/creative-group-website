<?php
declare(strict_types=1);
$env = static function (string $key, string $default = ''): string {
    $value = getenv($key);
    return $value === false ? $default : $value;
};
$environment = $env('APP_ENV', 'production');
return [
    'environment' => in_array($environment, ['development', 'production'], true) ? $environment : 'production',
    'base_url' => rtrim($env('APP_BASE_URL', '/my-project'), '/'),
    'vite_dev_server' => $env('VITE_DEV_SERVER', 'http://localhost:5173'),
    'manifest_path' => dirname(__DIR__, 2) . '/assets/build/manifest.json',
    'database' => [
        'host' => $env('DB_HOST'), 'port' => $env('DB_PORT', '3306'),
        'name' => $env('DB_NAME'), 'user' => $env('DB_USER'), 'password' => $env('DB_PASSWORD'),
    ],
    'contact' => ['recipient' => $env('CONTACT_TO_EMAIL'), 'sender' => $env('CONTACT_FROM_EMAIL')],
];
