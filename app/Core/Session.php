<?php
declare(strict_types=1);
final class Session
{
    public static function start(array $config): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) return;
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');
        ini_set('session.use_trans_sid', '0');
        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? null) === '443');
        $cookiePath = (string) ($config['base_url'] ?? '/');
        if ($cookiePath === '') $cookiePath = '/';
        session_name('CTGSESSID');
        session_set_cookie_params([
            'lifetime' => 0, 'path' => $cookiePath, 'domain' => '',
            'secure' => $isHttps, 'httponly' => true, 'samesite' => 'Lax',
        ]);
        if (!session_start()) throw new RuntimeException('Unable to start a secure session.');
    }
    public static function regenerate(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) session_regenerate_id(true);
    }
}
