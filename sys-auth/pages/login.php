<div class="body">
    <div class="msg"><?= __('Login to your account') ?></div>
    <form method="POST" action="https://cpanel.<?= config('system.cpanel_url'); ?>/login.php" onsubmit="return handleSubmit();" >
        <div class="form-group form-float">
            <i class="material-icons tooltip_icon-login" data-toggle="tooltip" data-placement="right" title="<?= __('To locate your cpanel username, check the email we sent you after verifying your email address') ?>">help</i>
            <div class="form-line">
                <input type="text" id="i_username" name="username" class="form-control" autocomplete="username">
                <label class="form-label"><?= __('cPanel Username') ?></label>
            </div>
            <small class="col-pink hidden" id="warn_username">{{WARNING}}</small>
        </div>
        <div class="form-group form-float">
            <i class="material-icons tooltip_icon-login" id="i_password_icon" onclick="toggleVisibility('i_password')">visibility</i>
            <div class="form-line">
                <input type="password" id="i_password" name="password" class="form-control">
                <label class="form-label"><?= __('Password') ?></label>
            </div>
            <small class="col-pink hidden" id="warn_password">{{WARNING}}</small>
        </div>
        <?php
        if (config('system.features.login.language_selector')) {
            require 'components/language_selector.login.php';
        }
        ?>
        <div class="row">
            <div class="col-xs-8 p-t-5">
                <?php
                if (config('system.features.login.remember_me')) {
                    include 'components/remember_me.login.php';
                }
                ?>
            </div>
            <div class="col-xs-4">
                <button class="btn btn-lg btn-block bg-<?= config('branding.accent_color'); ?> waves-effect"><?= __('SIGN IN') ?></button>
            </div>
        </div>
        <div class="row m-t-15 m-b--20">
            <div class="col-xs-6">
                <a href="/auth/signup"><?= __('Create an account') ?></a>
            </div>
            <div class="col-xs-6 align-right">
                <a href="https://cpanel.<?= config('system.cpanel_url'); ?>/lostpassword.php" target="_blank"><?= __('Forgot your password?') ?></a>
            </div>
        </div>
    </form>
</div>
