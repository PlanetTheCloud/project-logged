<?php

// Javascript request will come to this file. CSRF MUST be verified before processing

require __DIR__ . '/../app/bootstrap.php';

// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     //header("Location: /auth/signup");
//     echo __('Taking you to our signup page... If the page doesn\'t refresh automatically, <a href="/auth/signup">click here.</a>');
//     die;
// }

# Validate parameters
$required = ['username', 'email', 'password', 'password_confirm', 'id', 'number', 'token', 'action'];
$data = $_POST;
try {
    (function () use ($data, $required) {
        foreach ($required as $key) {
            if (!isset($data[$key])) {
                throw new ValidationFailedException($key . ' ' . __('cannot be missing!'));
            }
            if (!is_string($data[$key])) {
                throw new ValidationFailedException($key . ' ' . __('cannot be unexpected!'));
            }
            if (empty(trim($data[$key]))) {
                throw new ValidationFailedException($key . ' ' . __('cannot be empty!'));
            }
            $data[$key] = htmlspecialchars($data[$key]);
        }
        if ($data['password'] !== $data['password_confirm']) {
            throw new ValidationFailedException(__('Confirm Password does not match!'));
        }
    })();
} catch (ValidationFailedException $e) {
    apiErrorResponse($e->getMessage());
    die;
}

/**
 * TESTING
 */
$data = [
    'email' => 'a@g.co',
    'username' => 'awiourhpq3',
    'password' => 'asdfasdf',
    'PlanName' => 'Starter',
    'number' => '61499',
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ifastnet.com/register2.php");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'Referer: https://10-99.ml/'
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// SECURITY
curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS | CURLPROTO_HTTP);
curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTPS);
curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

echo $result;
