<?php
declare(strict_types=1);
final class Csrf
{
    public static function token(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) throw new LogicException('A session is required before creating a CSRF token.');
        if (!isset($_SESSION['_csrf']) || !is_string($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        return $_SESSION['_csrf'];
    }
    public static function verify(mixed $submittedToken): bool
    {
        return is_string($submittedToken) && isset($_SESSION['_csrf']) && is_string($_SESSION['_csrf'])
            && hash_equals($_SESSION['_csrf'], $submittedToken);
    }
}
