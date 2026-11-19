<?php
declare(strict_types=1);
final class ContactService
{
    public static function send(array $payload, array $config): bool
    {
        $recipient = (string) ($config['contact']['recipient'] ?? '');
        $sender = (string) ($config['contact']['sender'] ?? '');
        if (!filter_var($recipient, FILTER_VALIDATE_EMAIL) || !filter_var($sender, FILTER_VALIDATE_EMAIL)) return false;
        $name = trim((string) $payload['name']);
        $email = (string) $payload['email'];
        $subject = trim((string) $payload['subject']);
        $message = trim((string) $payload['message']);
        $mailSubject = '=?UTF-8?B?' . base64_encode('درخواست جدید وب‌سایت: ' . $subject) . '?=';
        $body = implode("\r\n", ['نام: ' . $name, 'ایمیل: ' . $email, 'موضوع: ' . $subject, '', 'متن پیام:', $message]);
        $headers = [
            'MIME-Version: 1.0', 'Content-Type: text/plain; charset=UTF-8',
            'From: Creative Technology Group <' . $sender . '>', 'Reply-To: ' . $email,
            'X-Mailer: PHP/' . PHP_VERSION,
        ];
        return mail($recipient, $mailSubject, $body, implode("\r\n", $headers));
    }
}
