<div class="msg"><?= config('page.messages.creating_account'); ?></div>
<p style="text-align:center">
    <img style="width: 25%" src="https://i.ibb.co/9r6TvgH/loader.gif">
</p>
<form action="<?= Account::getTarget(); ?>" method="get">
    <?php
    foreach (Account::getParameters() as $key => $value) {
        echo "<input type=\"hidden\" name=\"{$key}\" value=\"{$value}\">" . PHP_EOL;
    }
    ?>
    <input type="hidden" name="submit" value="Register">
    <div>
        <button type="submit" class="btn btn-success waves-effect btn-block" id="signup">Click here if nothing happens</button>
    </div>
</form>
<script type="text/javascript">
    document.getElementById('signup').click();
</script>
