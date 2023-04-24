<div class="body">
    <div class="msg"><?= __('Privacy Policy') ?></div>
    <?php
    $file = file_get_contents(__DIR__ . '/components/contents.privacy.php');
    echo str_replace([
        '{$c}',
        '{$c_caps}',
        '{$email_contact}',
        '{$privacy_url}',
        '{$terms_url}'
    ], [
        config('branding.name', 'We'),
        strtoupper(config('branding.name', 'WE')),
        config('branding.contact_email'),
        'http://' . config('sys.current_domain') . '/auth/privacy',
        'http://' . config('sys.current_domain') . '/auth/tos'
    ], $file);
    ?>
</div>
