<?php
declare(strict_types=1);
final class RateLimiter
{
    public static function allow(string $key, int $limit, int $windowSeconds): bool
    {
        $limit = max(1, $limit);
        $windowSeconds = max(1, $windowSeconds);
        $file = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'ctg-rate-' . hash('sha256', $key) . '.json';
        if (is_link($file)) return false;
        $handle = @fopen($file, 'c+');
        if ($handle === false) return false;
        @chmod($file, 0600);
        $locked = false;
        try {
            $locked = flock($handle, LOCK_EX);
            if (!$locked) return false;
            $stat = fstat($handle);
            if ($stat === false || (($stat['mode'] & 0170000) !== 0100000)) return false;
            rewind($handle);
            $raw = stream_get_contents($handle);
            $timestamps = json_decode($raw !== false && $raw !== '' ? $raw : '[]', true);
            if (!is_array($timestamps)) $timestamps = [];
            $now = time();
            $timestamps = array_values(array_filter($timestamps, static fn ($timestamp): bool => is_int($timestamp) && $timestamp > ($now - $windowSeconds)));
            if (count($timestamps) >= $limit) return false;
            $timestamps[] = $now;
            rewind($handle);
            ftruncate($handle, 0);
            if (fwrite($handle, json_encode($timestamps, JSON_THROW_ON_ERROR)) === false) return false;
            fflush($handle);
            return true;
        } finally {
            if ($locked) flock($handle, LOCK_UN);
            fclose($handle);
        }
    }
}
