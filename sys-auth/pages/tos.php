<div class="body">
    <div class="msg"><?= __('Terms of Service') ?></div>
    <?php
    $contents = file_get_contents(__DIR__ . '/components/contents.tos.php');
    echo str_replace([
        '{$c}',
        '{$c_caps}',
        '{$email_abuse}',
        '{$privacy_url}',
        '{$terms_url}'
    ], [
        config('branding.name', 'We'),
        strtoupper(config('branding.name', 'We')),
        config('branding.report_abuse_email'),
        'http://' . config('system.installation_url') . '/auth/privacy',
        'http://' . config('system.installation_url') . '/auth/tos'
    ], $contents);
    ?>
</div>
