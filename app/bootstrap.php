<?php
declare(strict_types=1);
$config = require __DIR__ . '/Config/app.php';
require_once __DIR__ . '/Core/SecurityHeaders.php';
require_once __DIR__ . '/Core/Session.php';
require_once __DIR__ . '/Core/Csrf.php';
require_once __DIR__ . '/Core/RateLimiter.php';
require_once __DIR__ . '/Core/Validator.php';
require_once __DIR__ . '/Core/DatabaseConnection.php';
require_once __DIR__ . '/Services/ContactService.php';
date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', $config['environment'] === 'development' ? '1' : '0');
ini_set('log_errors', '1');
SecurityHeaders::send($config);
Session::start($config);
set_exception_handler(static function (Throwable $exception) use ($config): void {
    error_log(sprintf('[CTG] %s in %s:%d', $exception::class . ': ' . $exception->getMessage(), $exception->getFile(), $exception->getLine()));
    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: text/html; charset=UTF-8');
    }
    if ($config['environment'] === 'development') {
        echo '<pre>' . htmlspecialchars((string) $exception, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</pre>';
        return;
    }
    echo '<!doctype html><html lang="fa" dir="rtl"><meta charset="utf-8"><title>خطای سرور</title><body><h1>خطای داخلی سرور</h1><p>در حال حاضر امکان پردازش درخواست وجود ندارد.</p></body></html>';
});
