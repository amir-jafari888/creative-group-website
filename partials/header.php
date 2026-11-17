<?php
$navItems=[
['home',$t('خانه','Home'),'#top'],
['services',$t('خدمات','Services'),'#services'],
['portfolio',$t('نمونه‌کارها','Work'),'#work'],
['about',$t('درباره ما','About'),'#about'],
['contact',$t('تماس','Contact'),'#contact'],
];
$navHref=static function(string $target,string $anchor)use($page,$pageUrl):string{return $page==='home'&&$anchor!==''?$anchor:$pageUrl($target);};
?>
<header class="site-header"><div class="container header-inner">
<a class="brand" href="<?= $pageUrl('home') ?>#top" aria-label="Creative Technology Group"><span class="brand-mark" aria-hidden="true">C<span>+</span></span><span class="brand-name">CREATIVE <strong>TECHNOLOGY</strong><small>GROUP</small></span></a>
<nav class="main-nav" aria-label="<?= $t('ناوبری اصلی','Main navigation') ?>"><?php foreach($navItems as [$target,$label,$anchor]): ?><a href="<?= htmlspecialchars($navHref($target,$anchor),ENT_QUOTES,'UTF-8') ?>" <?= $page===$target?'aria-current="page"':'' ?>><?= $label ?></a><?php endforeach; ?></nav>
<div class="header-actions"><a class="language-switch" href="<?= htmlspecialchars($languageUrl($isEn?'fa':'en'),ENT_QUOTES,'UTF-8') ?>" lang="<?= $isEn?'fa':'en' ?>" aria-label="<?= $t('تغییر زبان','Switch language') ?>"><?= $isEn?'FA':'EN' ?></a><a class="header-cta" href="<?= $pageUrl('contact') ?>"><?= $t('شروع گفتگو','Start a project') ?> <span class="icon-arrow" aria-hidden="true">↗</span></a><button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-nav" aria-label="<?= $t('باز کردن منو','Open menu') ?>" data-open-label="<?= $t('باز کردن منو','Open menu') ?>" data-close-label="<?= $t('بستن منو','Close menu') ?>"><span></span><span></span></button></div></div>
<nav class="mobile-nav" id="mobile-nav" aria-label="<?= $t('ناوبری موبایل','Mobile navigation') ?>" hidden><?php foreach($navItems as [$target,$label,$anchor]): ?><a href="<?= htmlspecialchars($navHref($target,$anchor),ENT_QUOTES,'UTF-8') ?>" <?= $page===$target?'aria-current="page"':'' ?>><?= $label ?></a><?php endforeach; ?><a class="mobile-language" href="<?= htmlspecialchars($languageUrl($isEn?'fa':'en'),ENT_QUOTES,'UTF-8') ?>"><?= $isEn?'فارسی':'English' ?></a></nav></header>
