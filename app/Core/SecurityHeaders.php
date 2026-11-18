<?php
declare(strict_types=1);
final class SecurityHeaders
{
    public static function send(array $config): void
    {
        if (headers_sent()) return;
        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? null) === '443');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');
        header('Cross-Origin-Opener-Policy: same-origin');
        $scriptSources = ["'self'"];
        $connectSources = ["'self'"];
        if (($config['environment'] ?? 'production') === 'development') {
            $vite = rtrim((string) ($config['vite_dev_server'] ?? ''), '/');
            if ($vite !== '') {
                $scriptSources[] = $vite;
                $connectSources[] = $vite;
                $connectSources[] = 'ws://localhost:5173';
            }
        }
        $policy = [
            "default-src 'self'", "base-uri 'self'", "object-src 'none'", "frame-ancestors 'none'",
            "form-action 'self'", "img-src 'self' data: https:", "font-src 'self' data:",
            "style-src 'self' 'unsafe-inline'", 'script-src ' . implode(' ', $scriptSources),
            'connect-src ' . implode(' ', $connectSources),
        ];
        header('Content-Security-Policy: ' . implode('; ', $policy));
        if ($isHttps) header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
}
