<?php
$flashMessages = [
    'sent' => $t('پیام شما ثبت و برای ما ارسال شد. از ارتباط شما سپاسگزاریم.', 'Your message has been submitted. Thank you for reaching out.'),
    'invalid' => $t('اطلاعات واردشده معتبر نیست. لطفاً فیلدها را بررسی کنید.', 'Some details are invalid. Please review the form and try again.'),
    'csrf' => $t('درخواست منقضی یا نامعتبر است. صفحه را تازه‌سازی و دوباره ارسال کنید.', 'Your request expired or is invalid. Refresh the page and try again.'),
    'rate' => $t('تعداد درخواست‌ها بیش از حد مجاز است. کمی بعد دوباره تلاش کنید.', 'Too many submissions. Please try again later.'),
    'mail_config' => $t('سامانه ارسال ایمیل هنوز روی سرور پیکربندی نشده است. لطفاً از ایمیل مستقیم استفاده کنید.', 'Email delivery is not configured on the server yet. Please use the direct email link.'),
    'send_error' => $t('ارسال پیام انجام نشد. لطفاً از ایمیل مستقیم استفاده کنید.', 'The message could not be sent. Please use the direct email link.'),
];
?>
<section class="inner-hero section"><div class="container"><h1><?= $t('از یک گفتگو<br><span>شروع می‌شود.</span>', 'It starts<br><span>with a conversation.</span>') ?></h1><p><?= $t('درباره ایده، نیاز یا چالشی که می‌خواهید حل کنید برایمان بنویسید.', 'Tell us about your idea, the need or the challenge you want to solve.') ?></p></div></section>
<section class="section contact-page-content"><div class="container contact-page-grid">
<div>
<h2><?= $t('راه ارتباطی', 'Get in touch') ?></h2>
<p><?= $t('برای شروع، شرح کوتاهی از پروژه و راه ارتباطی مناسب را ارسال کنید.', 'To get started, send a short project brief and the best way to reach you.') ?></p>
<a class="contact-email" href="mailto:hello@creativetechnology.group">hello@creativetechnology.group <span>↗</span></a>
</div>
<div class="contact-note-panel">
<h3><?= $t('برای گفتگوی مفیدتر', 'To make the first conversation useful') ?></h3>
<?php if (is_string($contactFlash) && isset($flashMessages[$contactFlash])): ?>
<p class="form-feedback form-feedback-<?= $contactFlash ?>" role="status" aria-live="polite"><?= $flashMessages[$contactFlash] ?></p>
<?php endif; ?>
<form class="contact-form" id="contact-form" method="post" action="<?= htmlspecialchars($pageUrl('contact'), ENT_QUOTES, 'UTF-8') ?>">
<input type="hidden" name="_csrf" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
<div class="form-trap" aria-hidden="true"><label for="contact-website">Website</label><input id="contact-website" type="text" name="website" tabindex="-1" autocomplete="off"></div>
<label for="contact-name"><?= $t('نام و نام خانوادگی', 'Your name') ?></label>
<input id="contact-name" name="name" type="text" maxlength="100" autocomplete="name" required>
<label for="contact-email"><?= $t('ایمیل', 'Email address') ?></label>
<input id="contact-email" name="email" type="email" maxlength="254" autocomplete="email" required>
<label for="contact-subject"><?= $t('موضوع', 'Subject') ?></label>
<input id="contact-subject" name="subject" type="text" maxlength="150" required>
<label for="contact-message"><?= $t('شرح کوتاه پروژه', 'Project details') ?></label>
<textarea id="contact-message" name="message" rows="5" maxlength="5000" required></textarea>
<button class="button button-light contact-submit" type="submit"><?= $t('ارسال پیام', 'Send message') ?> <span aria-hidden="true">↗</span></button>
</form>
<p><?= $t('ارسال فرم به پیکربندی سرویس ایمیل روی سرور نیاز دارد. در صورت اختلال می‌توانید مستقیماً ایمیل بزنید.', 'Form delivery requires a working mail service on the server. If it is unavailable, contact us directly by email.') ?></p>
</div>
</div></section>
