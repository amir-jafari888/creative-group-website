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
    <meta name="description" content="Creative Technology Group">
    <meta name="theme-color" content="#f1eee7">

    <title>Creative Technology Group</title>

    <?= $assets->renderStylesheet('assets/css/main.css') ?>
</head>
<body>
    <main id="app">
        <!-- Page content will be integrated here. -->
    </main>

    <?= $assets->renderScripts('assets/js/main.js') ?>
</body>
</html>
