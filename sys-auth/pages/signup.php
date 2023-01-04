<div class="body">
    <div class="msg"><?= __('Sign up for a free account') ?></div>
    <?php
    if (isset($_SESSION['gMsg'])) {
        if ($_SESSION['gMsg'] && is_array($_SESSION['gMsg'])) {
            foreach ($_SESSION['gMsg'] as $key => $value) {
                echo "<div class=\"alert alert-{$value['type']}\">{$value['msg']}</div>" . PHP_EOL;
            }
            $_SESSION['gMsg'] = [];
        }
    }
    ?>
    <form method="post" action="/api/signup.php" onsubmit="return handleSubmit();">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="email" id="input_email" name="email" class="form-control">
                <label class="form-label">Email Address</label>
            </div>
            <small class="col-pink hidden" id="warn_email">{{WARNING}}</small>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="password" id="input_password" name="password" class="form-control">
                <label class="form-label">Password</label>
            </div>
            <small class="col-pink hidden" id="warn_password">{{WARNING}}</small>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="password" id="input_confirm_password" name="password_confirm" class="form-control">
                <label class="form-label">Confirm Password</label>
            </div>
            <small class="col-pink hidden" id="warn_confirm_password">{{WARNING}}</small>
        </div>

        <div class="form-group form-float">
            <div style="margin-bottom: 20px;">
                <img width="50%" src="https://ifastnet.com/image.php?id=CAPTCHA_ID">
            </div>
            <div class="form-line">
                <input type="text" id="input_captcha" name="number" class="form-control">
                <input type="hidden" name="id" value="CAPTCHA_ID">
                <label class="form-label">Captcha</label>
            </div>
            <small class="col-pink hidden" id="warn_captcha">{{WARNING}}</small>
        </div>
        <input type="checkbox" id="remember_me_2" class="filled-in">
        <label for="remember_me_2">Remember Me</label>
        <br>
        <button type="button" class="btn btn-primary m-t-15 waves-effect">LOGIN</button>
    </form>
    <script type="text/javascript">
        function toggleVisibility(e) {
            let x = document.getElementById(e),
                y = document.getElementById(`${e}_icon`),
                show = (x.type === "password");
            (show) ? y.innerText = "visibility_off": y.innerText = "visibility";
            (show) ? x.type = "text": x.type = "password";
        }
    </script>
    <script src="assets/signup.js"></script>
</div>