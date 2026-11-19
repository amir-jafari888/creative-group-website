<?php
declare(strict_types=1);
/** PDO connection factory only. No schema, SQL queries or database data live here. */
final class DatabaseConnection
{
    public static function connect(array $config): PDO
    {
        $database = $config['database'] ?? [];
        $host = (string) ($database['host'] ?? '');
        $name = (string) ($database['name'] ?? '');
        $user = (string) ($database['user'] ?? '');
        $password = (string) ($database['password'] ?? '');
        $port = (int) ($database['port'] ?? 3306);
        if ($host === '' || $name === '' || $user === '') throw new RuntimeException('Database connection settings are not configured.');
        if (!extension_loaded('pdo_mysql')) throw new RuntimeException('The PHP pdo_mysql extension is required.');
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $host, $port, $name);
        return new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
        ]);
    }
}
