<div id="rc">
</div>

<script>
   
  setTimeout(() => {
      grecaptcha.render('rc', {
            'sitekey' : ' <?php echo config("system.features.signup.recaptcha_key_public")?>',
            'theme' : 'light'
          });
  }, 1000);
        </script>