<?php
    // Optimizations for the form state in case the use own domain feature is disabled.
    // Automatically selects the free subdomain option and keeps the element hidden.
    $useOwnDomainBool = (config('system.features.signup.use_own_domain', false));

    // When stub mode is enabled, signup form shall not be shown.
    $stubModeEnabled = (config('system.stub_mode', false));
    
    // Handle external signup request
    (function() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        // TODO: Validate the request
        $required = [];
        foreach ($required as $key) {
            if (!isset($_POST[$key])) {
                throw new ValidationFailedException(ucfirst($key) . ' ' . __('cannot be missing'), $key);
            }
            if (!is_string($_POST[$key])) {
                throw new ValidationFailedException(ucfirst($key) . ' ' . __('cannot be unexpected'), $key);
            }
            $_POST[$key] = htmlspecialchars($_POST[$key]);
        }
    })();
?>
<div class="body">
    <div id="a_response" class="alert alert-danger mb-3 hidden">{{MESSAGE}}</div>
    <div class="msg"><?= __('Sign up for a free account') ?></div>
    <div id="s_success" class="hidden" style="text-align: center; font-size:larger;">
        <img style="width: 25%" src="assets/checkmark.gif"><br>
        <h2><?= __('Success!') ?></h2>
        <p><?= __('Your account has been created.') ?></p>
        <p><?= __('To activate your account, please check your email and click the activation link we\'ve sent to you.') ?></p>
        <p><?= __('The activation page contains your username, which you will need to log into the control panel.') ?> <a href="/auth/login" style="font-size: inherit;"><?= __('Click here to login.') ?></a></p>
        <p><span class="col-pink"><?= __('If you don\'t receive the email within a few minutes, please check your spam folder.') ?></span> <a id="a_success_link" href="{{RESEND}}" style="font-size: inherit;" target="_blank"><?= __('Click here to resend the email.') ?></a></p>
        <div class="m-t-25 m-b-5 align-center">
            <a href="/"><?= __('Go back to our website') ?></a>
        </div>
    </div>
    <div id="s_processing" class="<?= (!$stubModeEnabled) ? 'hidden' : '' ?>">
        <p style="text-align:center;font-size:larger">
            <img style="width: 25%" src="assets/loader.gif"><br>
            <?= __('Processing your request...') ?>
        </p>
    </div>
    <form id="s_signup_form" class="<?= ($stubModeEnabled) ? 'hidden' : '' ?>" method="post" onsubmit="return handleInitialSubmit();">
        <div class="form-group form-float">
            <i class="material-icons tooltip_icon-signup" data-toggle="tooltip" data-placement="right" title="<?= __('Each email address is limited to 3 accounts') ?>">info</i>
            <div class="form-line">
                <input type="email" id="i_email" name="email" class="form-control">
                <label class="form-label"><?= __('Email Address') ?></label>
            </div>
            <small class="col-pink hidden" id="warn_email">{{WARNING}}</small>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="password" id="i_password" name="password" class="form-control">
                <label class="form-label"><?= __('Password') ?></label>
            </div>
            <small class="col-pink hidden" id="warn_password">{{WARNING}}</small>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="password" id="i_password_confirm" name="password_confirm" class="form-control">
                <label class="form-label"><?= __('Confirm Password') ?></label>
            </div>
            <small class="col-pink hidden" id="warn_password_confirm">{{WARNING}}</small>
        </div>

        <div class="form-group <?= (!$useOwnDomainBool) ? 'hidden' : '' ?>" style="margin-bottom: 10px;">
            <i class="material-icons" style="position: absolute;z-index:10;margin-top:14px;margin-left:425px;" data-toggle="tooltip" data-placement="right" data-html="true" data-template="<div class='tooltip' role='tooltip'><div class='arrow'></div><div class='tooltip-inner' style='max-width: 250px;max-height:300px;'></div></div>" title="<?= __('If you already have a domain that you want to use with us, please select \'I have my own domain\'.<br><br>If you don\'t have a domain right now, you can choose \'I want to use a free subdomain\'.<br><br>Don\'t worry, you can always add more domains (including your own domain) later on from the Control Panel.') ?>">help</i>
            <input type="radio" name="domain_type" value="custom" class="with-gap radio-col-<?= config('branding.accent_color'); ?>" id="i_domain_type_own">
            <label for="i_domain_type_own"><?= __('I have my own domain') ?></label>
            <br>
            <input type="radio" name="domain_type" value="subdomain" class="with-gap radio-col-<?= config('branding.accent_color'); ?>" id="i_domain_type_sub" <?= (!$useOwnDomainBool) ? 'checked="checked"' : '' ?>>
            <label class="p-l-20" for="i_domain_type_sub"><?= __('I want to use a free subdomain') ?></label>
        </div>
        <small class="col-pink hidden" id="warn_domain_type">{{WARNING}}</small>

        <div id="s_custom_domain" class="hidden">
            <div class="infobox">
                <?= __('To use your domain with us, point it to these nameservers:') ?><br>
                <ul style="margin-bottom: 0px;">
                    <li>ns1.<?= config('system.cpanel_url') ?></li>
                    <li>ns2.<?= config('system.cpanel_url') ?></li>
                </ul>
            </div>
            <div class="form-group form-float">
                <i class="material-icons tooltip_icon-signup" data-toggle="tooltip" data-placement="right" title="<?= __('Exclude the protocol (http:// or https://) and the trailing slash.') ?>">info</i>
                <div class="form-line">
                    <input type="text" id="i_custom_domain" name="custom_domain" class="form-control">
                    <label class="form-label"><?= __('Domain Name') ?></label>
                </div>
                <small class="col-pink hidden" id="warn_custom_domain">{{WARNING}}</small>
            </div>
        </div>

        <div id="s_subdomain" class="<?= ($useOwnDomainBool) ? 'hidden' : '' ?>">
            <div class="infobox" id="infobox_subdomain">
                <?= __('Choose a subdomain and extension') ?>
            </div>
            <div class="row">
                <div class="col-sm-6" style="margin-bottom:0px">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" id="i_subdomain" name="subdomain" class="form-control">
                            <label class="form-label"><?= __('Subdomain') ?></label>
                        </div>
                        <small class="col-pink hidden" id="warn_subdomain">{{WARNING}}</small>
                    </div>
                </div>
                <div class="col-sm-6" style="margin-bottom:0px">
                    <select class="form-control" name="extension" id="i_extension">
                        <?php
                        $domains = config('system.domain_selection');
                        foreach ($domains as $domain) {
                            echo '<option value="' . $domain . '">.' . $domain . '</option>' . PHP_EOL;
                        }
                        unset($domains);
                        ?>
                        <!-- TODO: TEMPORARY REMEMBER TO REMOVE -->
                        <option value="test">test</option>
                    </select>
                </div>
            </div>
        </div>
        <div id="s_others" class="<?= ($useOwnDomainBool) ? 'hidden' : '' ?>">
            <div class="form-group form-float">
                <div style="margin-bottom: 20px;">
                    <img width="50%" src="https://ifastnet.com/image.php?id=<?= Page::param('captcha_id') ?>">
                </div>
                <div class="form-line">
                    <input type="text" id="i_captcha_solution" name="captcha_solution" class="form-control" autocomplete="off">
                    <input type="hidden" name="captcha_id" value="<?= Page::param('captcha_id') ?>">
                    <label class="form-label"><?= __('Captcha') ?></label>
                </div>
                <small class="col-pink hidden" id="warn_captcha">{{WARNING}}</small>
            </div>
            <input type="hidden" name="_token" value="<?= Page::param('_token') ?>">
            <p><?= __('By signing up, you acknowledge that you have read and agree to be bound by our') ?> <a href="/auth/tos" target="_blank"><?= __('terms of service') ?></a> <?= __('and') ?> <a href="/auth/privacy" target="_blank"><?= __('privacy policies') ?></a>.</p>
            <button class="btn btn-lg btn-block bg-<?= config('branding.accent_color'); ?> waves-effect"><?= __('SIGN UP') ?></button>
        </div>
        <div class="m-t-25 m-b-5 align-center">
            <a href="/auth/login"><?= __('Sign in to your account(s)') ?></a>
        </div>
    </form>
</div>