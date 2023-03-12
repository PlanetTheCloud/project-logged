<div class="body">
    <div class="msg"><?= __('Sign up for a free account') ?></div>
    <form method="post" onsubmit="return handleSubmit();">
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

        <div class="form-group" style="margin-bottom: 10px;">
            <i class="material-icons" style="position: absolute;z-index:10;margin-top:14px;margin-left:425px;" data-toggle="tooltip" data-placement="right" data-html="true" data-template="<div class='tooltip' role='tooltip'><div class='arrow'></div><div class='tooltip-inner' style='max-width: 250px;max-height:300px;'></div></div>" title="<?= __('If you already have a domain that you want to use with us, please select \'I have my own domain\'.<br><br>If you don\'t have a domain right now, you can choose \'I want to use a free subdomain\'.<br><br>Don\'t worry, you can always add more domains (including your own domain) later on from the Control Panel.') ?>">help</i>
            <input type="radio" name="domain_type" value="custom" class="with-gap radio-col-<?= config('branding.accent_color'); ?>" id="i_domain_type_own">
            <label for="i_domain_type_own"><?= __('I have my own domain') ?></label>
            <br>
            <input type="radio" name="domain_type" value="subdomain" class="with-gap radio-col-<?= config('branding.accent_color'); ?>" id="i_domain_type_sub">
            <label class="p-l-20" for="i_domain_type_sub"><?= __('I want to use a free subdomain') ?></label>
        </div>

        <div id="s_custom_domain" class="hidden">
            <div class="infobox">
                <?= __('To use your domain with us, point it to these nameservers:') ?><br>
                <ul style="margin-bottom: 0px;">
                    <li>ns1.<?= config('system.cpanel_url') ?></li>
                    <li>ns2.<?= config('system.cpanel_url') ?></li>
                </ul>
            </div>
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" id="i_custom_domain" name="custom_domain" class="form-control">
                    <label class="form-label"><?= __('Domain Name') ?></label>
                </div>
                <small class="col-pink hidden" id="warn_custom_domain">{{WARNING}}</small>
            </div>
        </div>

        <div id="s_subdomain" class="hidden">
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
                    </select>
                </div>
            </div>
        </div>

        <div id="s_others" class="hidden">
            <div class="form-group form-float">
                <div style="margin-bottom: 20px;">
                    <img width="50%" src="https://ifastnet.com/image.php?id=<?= Page::param('captcha_id') ?>">
                </div>
                <div class="form-line">
                    <input type="text" id="i_captcha" name="captcha_solution" class="form-control" autocomplete="off">
                    <input type="hidden" name="captcha_id" value="<?= Page::param('captcha_id') ?>">
                    <label class="form-label"><?= __('Captcha') ?></label>
                </div>
                <small class="col-pink hidden" id="warn_captcha">{{WARNING}}</small>
            </div>
            <p><?= __('By signing up, you acknowledge that you have read and agree to be bound by our <a href="/auth/read/tos">terms of service</a> and <a href="/auth/read/privacy">privacy policies</a>.') ?></p>
            <button class="btn btn-lg btn-block bg-<?= config('branding.accent_color'); ?> waves-effect"><?= __('SIGN UP') ?></button>
        </div>

        <div class="m-t-25 m-b-5 align-center">
            <a href="/auth/login"><?= __('Sign in to your account(s)') ?></a>
        </div>
    </form>
    <script src="assets/signup.js"></script>
</div>