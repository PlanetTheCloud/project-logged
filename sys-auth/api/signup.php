<?php

// Javascript request will come to this file. CSRF MUST be verified before processing

require __DIR__ . '/../app/bootstrap.php';

// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     //header("Location: /auth/signup");
//     echo __('Taking you to our signup page... If the page doesn\'t refresh automatically, <a href="/auth/signup">click here.</a>');
//     die;
// }

# Validate parameters
$required = ['email', 'password', 'password_confirm', 'domain_type', 'custom_domain', 'subdomain', 'extension', 'captcha_id', 'captcha_solution', '_token'];
$data = $_POST;
try {
    (function () use ($data, $required) {
        foreach ($required as $key) {
            if (!isset($data[$key])) {
                throw new ValidationFailedException(ucfirst($key) . ' ' . __('cannot be missing'), $key);
            }
            if (!is_string($data[$key])) {
                throw new ValidationFailedException(ucfirst($key) . ' ' . __('cannot be unexpected'), $key);
            }
            if (empty(trim($data[$key]))) {
                throw new ValidationFailedException(ucfirst($key) . ' ' . __('cannot be empty'), $key);
            }
            $data[$key] = htmlspecialchars($data[$key]);
        }
        if ($data['password'] !== $data['password_confirm']) {
            throw new ValidationFailedException(__('Confirm Password does not match!'), 'password_confirm');
        }
        if (!in_array($data['domain_type'], ['subdomain', 'custom_domain'])) {
            throw new ValidationFailedException(__('Invalid domain type given'), 'domain_type');
        }
        if ($data['domain_type'] === 'subdomain' && !in_array($data['extension'], config('system.domain_selection'))) {
            throw new ValidationFailedException(__('Unable to find the given extension'), $key);
        }
        // domain validation
        // tld filter
        // captcha and CSRF checks
    })();
} catch (ValidationFailedException $e) {
    apiErrorResponse($e->getMessage(), [
        'type' => 'VALIDATION_FAILED',
        'field' => $e->getField()
    ], true);
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

$account = Account::create($data);
if($account['created'] === false) {
    return 'error';
}

echo $result;
