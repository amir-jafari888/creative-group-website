<?php

declare(strict_types=1);

$config = require __DIR__ . '/app/Config/app.php';

require_once __DIR__ . '/app/Core/AssetLoader.php';

$assets = new AssetLoader($config);

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative Technology Group؛ همراه خلاق شما در طراحی، فناوری، هویت بصری و تولید محتوای دیجیتال.">
    <meta name="theme-color" content="#f1eee7">
    <title>Creative Technology Group | ایده را به تجربه تبدیل می‌کنیم</title>
    <?= $assets->renderStylesheet('assets/css/main.css') ?>
</head>
<body>
    <?php require __DIR__ . '/pages/home.php'; ?>
    <?= $assets->renderScripts('assets/js/main.js') ?>
</body>
</html>
