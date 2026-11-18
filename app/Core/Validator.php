<?php
declare(strict_types=1);
final class Validator
{
    public static function string(mixed $value, int $maxLength): ?string
    {
        if (!is_string($value)) return null;
        $value = trim($value);
        if ($value === '') return null;
        $length = preg_match_all('/./us', $value, $matches);
        if ($length === false || $length > $maxLength) return null;
        return $value;
    }
    public static function email(mixed $value): ?string
    {
        $email = self::string($value, 254);
        if ($email === null || filter_var($email, FILTER_VALIDATE_EMAIL) === false) return null;
        return $email;
    }
}
