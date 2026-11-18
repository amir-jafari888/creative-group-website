<?php
declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/Core/AssetLoader.php';

$assets = new AssetLoader($config);
$lang = ($_GET['lang'] ?? 'fa') === 'en' ? 'en' : 'fa';
$isEn = $lang === 'en';
$dir = $isEn ? 'ltr' : 'rtl';
$t = static fn (string $fa, string $en): string => $isEn ? $en : $fa;

$allowedPages = ['home', 'services', 'about', 'portfolio', 'contact'];
$requestedPage = $_GET['page'] ?? 'home';
$pageIsValid = is_string($requestedPage) && in_array($requestedPage, $allowedPages, true);
$page = $pageIsValid ? $requestedPage : 'home';
if (!$pageIsValid) {
    http_response_code(404);
}

$pageUrl = static function (string $target) use ($lang): string {
    return '?' . http_build_query(['page' => $target, 'lang' => $lang]);
};
$languageUrl = static function (string $target) use ($page): string {
    return '?' . http_build_query(['page' => $page, 'lang' => $target]);
};

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if ($page !== 'contact') {
        http_response_code(405);
        header('Allow: GET, HEAD');
        exit;
    }

    $flash = 'invalid';
    if (!Csrf::verify($_POST['_csrf'] ?? null)) {
        $flash = 'csrf';
    } elseif (!RateLimiter::allow('contact:' . (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown'), 5, 900)) {
        $flash = 'rate';
    } elseif (Validator::string($_POST['website'] ?? '', 200) !== null) {
        // Honeypot: silently accept bot submissions without sending them.
        $flash = 'sent';
    } else {
        $payload = [
            'name' => Validator::string($_POST['name'] ?? null, 100),
            'email' => Validator::email($_POST['email'] ?? null),
            'subject' => Validator::string($_POST['subject'] ?? null, 150),
            'message' => Validator::string($_POST['message'] ?? null, 5000),
        ];

        if (in_array(null, $payload, true)) {
            $flash = 'invalid';
        } else {
            try {
                $flash = ContactService::send($payload, $config) ? 'sent' : 'mail_config';
            } catch (Throwable $exception) {
                error_log('[CTG] Contact delivery failed: ' . $exception->getMessage());
                $flash = 'send_error';
            }
        }
    }

    $_SESSION['contact_flash'] = $flash;
    header('Location: ' . $pageUrl('contact') . '#contact-form', true, 303);
    exit;
}

$contactFlash = $_SESSION['contact_flash'] ?? null;
unset($_SESSION['contact_flash']);
$csrfToken = Csrf::token();

$pageMeta = [
    'home' => [$t('Creative Technology Group | ایده را به تجربه تبدیل می‌کنیم', 'Creative Technology Group | Ideas into meaningful experiences'), $t('همراه خلاق شما در طراحی، فناوری، هویت بصری و تولید محتوای دیجیتال.', 'A creative partner for digital experiences, technology, brand identity and content production.')],
    'services' => [$t('خدمات | Creative Technology Group', 'Services | Creative Technology Group'), $t('چهار حوزه تخصصی برای تبدیل ایده به تجربه و محصول.', 'Four connected disciplines for turning ideas into meaningful experiences.')],
    'about' => [$t('درباره ما | Creative Technology Group', 'About | Creative Technology Group'), $t('رویکرد و شیوه همکاری Creative Technology Group.', 'The thinking and collaborative approach behind Creative Technology Group.')],
    'portfolio' => [$t('نمونه‌کارها | Creative Technology Group', 'Work | Creative Technology Group'), $t('فضایی برای پروژه‌های واقعی و مطالعات موردی مجموعه.', 'A home for verified projects and case studies.')],
    'contact' => [$t('تماس | Creative Technology Group', 'Contact | Creative Technology Group'), $t('برای شروع یک همکاری خلاقانه با ما در ارتباط باشید.', 'Start a conversation about your next project.')],
];
[$pageTitle, $pageDescription] = $pageMeta[$page];
?><!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
<meta name="theme-color" content="#0e0e10">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
<meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></title>
<?= $assets->renderStylesheet('assets/css/main.css') ?>
</head>
<body class="<?= $isEn ? 'lang-en' : 'lang-fa' ?> page-<?= htmlspecialchars($page, ENT_QUOTES, 'UTF-8') ?>">
<div class="site-shell">
<?php require __DIR__ . '/partials/header.php'; ?>
<main id="main-content">
<?php
if ($page === 'home') {
    require __DIR__ . '/pages/home.php';
} else {
    require __DIR__ . '/pages/' . $page . '.php';
}
?>
</main>
<?php require __DIR__ . '/partials/footer.php'; ?>
</div>
<?= $assets->renderScripts('assets/js/main.js') ?>
</body>
</html>
