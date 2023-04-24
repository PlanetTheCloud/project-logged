<div class="body">
    <div class="msg"><?= __('Privacy Policy') ?></div>
    <?php
    $contents = file_get_contents(__DIR__ . '/components/contents.privacy.php');
    echo str_replace([
        '{$c}',
        '{$email_contact}',
    ], [
        config('branding.name', 'We'),
        config('branding.contact_email'),
    ], $contents);
    ?>
</div>
