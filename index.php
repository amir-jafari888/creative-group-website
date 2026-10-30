<?php
declare(strict_types=1);
$config=require __DIR__.'/app/Config/app.php';
require_once __DIR__.'/app/Core/AssetLoader.php';
$assets=new AssetLoader($config);
$lang=($_GET['lang']??'fa')==='en'?'en':'fa';$isEn=$lang==='en';$dir=$isEn?'ltr':'rtl';
$t=static fn(string $fa,string $en):string=>$isEn?$en:$fa;
$languageUrl=static function(string $target):string{$q=$_GET;$q['lang']=$target;return '?'.http_build_query($q);};
$pageTitle=$t('Creative Technology Group | ایده را به تجربه تبدیل می‌کنیم','Creative Technology Group | Ideas into meaningful experiences');
$pageDescription=$t('همراه خلاق شما در طراحی، فناوری، هویت بصری و تولید محتوای دیجیتال.','A creative partner for digital experiences, technology, brand identity and content production.');
?><!DOCTYPE html><html lang="<?= $lang ?>" dir="<?= $dir ?>"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= htmlspecialchars($pageDescription,ENT_QUOTES,'UTF-8') ?>"><meta name="theme-color" content="#f1eee7">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle,ENT_QUOTES,'UTF-8') ?>"><meta property="og:description" content="<?= htmlspecialchars($pageDescription,ENT_QUOTES,'UTF-8') ?>">
<title><?= htmlspecialchars($pageTitle,ENT_QUOTES,'UTF-8') ?></title><?= $assets->renderStylesheet('assets/css/main.css') ?></head>
<body class="<?= $isEn?'lang-en':'lang-fa' ?>"><?php require __DIR__.'/pages/home.php'; ?><?= $assets->renderScripts('assets/js/main.js') ?></body></html>