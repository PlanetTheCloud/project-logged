<?php

require __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /auth/signup");
    echo __('Taking you to our signup page... If the page doesn\'t refresh automatically,') . ' <a href="/auth/signup">' . __('click here.') . '</a>';
    die;
}

$account = HostingAccount::parseResult($data);
$toMerge = (config('system.development_mode', false)) ? ['dev_raw' => $account['raw']] : [];
$response = [
    'status' => ($account['created']) ? 'success' : 'error',
    'message' => $account['details']['message'],
    'details' => Arr::only($account['details'], ['field', 'type', 'token'])
];
echo json_encode(array_merge($response, $toMerge));