<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $captchas = json_decode(file_get_contents('captchas.json'), true);
    $count = count($_POST['captcha_id']);
    for ($i = 0; $i < $count; $i++) {
        $captchas['captcha_id'][] = $_POST['captcha_id'][$i];
        $captchas['captcha_answer'][] = $_POST['captcha_answer'][$i];
    }
    file_put_contents('captchas.json', json_encode($captchas));
    echo 'SAVED ' . time();
}

?>
<html>

<head>
    <title>Solve these captchas for ...</title>
</head>

<body>
    <form action="" method="POST">
        <?php
        for ($i = 0; $i < 5; $i++) {
            $id = md5(mt_rand(6000, PHP_INT_MAX));
            echo '<img width="250px" src="https://ifastnet.com/image.php?id=' . $id . '"><br>' . PHP_EOL;
            echo '<input type="hidden" name="captcha_id[]" value="' . $id . '">' . PHP_EOL;
            echo '<input type="text" name="captcha_answer[]">' . PHP_EOL;
            echo '<br><br>' . PHP_EOL;
        }
        ?>
        <button type="submit">Submit</button>
    </form>
</body>

</html>