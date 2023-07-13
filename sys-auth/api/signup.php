<?php

require __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /auth/signup");
    echo __('Taking you to our signup page... If the page doesn\'t refresh automatically,') . ' <a href="/auth/signup">' . __('click here.') . '</a>';
    die;
}

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
                if ($key === 'subdomain' || $key === 'custom_domain') {
                    // These may be empty as it is validated later on below
                    continue;
                }
                throw new ValidationFailedException(ucfirst($key) . ' ' . __('cannot be empty'), $key);
            }
            $data[$key] = htmlspecialchars($data[$key]);
        }

        // CSRF
        $protect = new CsrfProtect();
        $protect->validate($data['_token'], 'signup');

        // Email
        $data['email'] = strtolower($data['email']);
        if (!preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $data['email'])) {
            throw new ValidationFailedException(__('The email address you provided is invalid. Please enter a valid email address and try again.'), 'email');
        }

        // Password
        $l = strlen($data['password']);
        if ($l < 6 || $l > 20) {
            throw new ValidationFailedException(__('The password you entered must be between 6 and 20 characters in length. Please try again.'), 'password');
        }
        unset($l);
        if ($data['password'] !== $data['password_confirm']) {
            throw new ValidationFailedException(__('The password confirmation you entered does not match the password you provided. Please try again.'), 'password_confirm');
        }

        // Domain
        if (!in_array($data['domain_type'], ['subdomain', 'custom'])) {
            throw new ValidationFailedException(__('The domain type you provided is invalid. Please enter a valid domain type and try again.'), 'domain_type');
        }
        if ($data['domain_type'] === 'subdomain') {
            $data['subdomain'] = strtolower($data['subdomain']);
            if (!in_array($data['extension'], config('system.domain_selection'))) {
                throw new ValidationFailedException(__('The extension you provided is not recognized. Please enter a valid extension and try again.'), 'extension');
            }
            if (!preg_match('/^[A-Za-z0-9-]{4,16}$(?<!-)/', $data['subdomain'])) {
                throw new ValidationFailedException(__('The subdomain you provided is invalid. Please enter a valid subdomain and try again.'), 'subdomain');
            }
        }
        if ($data['domain_type'] === 'custom') {
            if (!config('system.features.signup.use_own_domain', false)) {
                throw new ValidationFailedException(__('Signups using custom domains are currently disabled. Please use a free subdomain and try again.'), 'custom_domain');
            }

            $data['custom_domain'] = strtolower($data['custom_domain']);
            if (!preg_match('/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/', $data['custom_domain'])) {
                throw new ValidationFailedException(__('The custom domain you provided is invalid. Please enter a valid custom domain and try again.'), 'custom_domain');
            }
            // Check TLD blacklist
            $tld = explode('.', $data['custom_domain']);
            $tld = $tld[count($tld) - 1];
            if (in_array($tld, config('system.blacklisted_tld'))) {
                throw new ValidationFailedException(__('The custom domain TLD you provided is not supported. Please enter a valid TLD and try again.'), 'custom_domain');
            }
            // Check DNS is pointed at us
            $dns = dns_get_record($data['custom_domain'], DNS_NS);
            if (!$dns) {
                throw new ValidationFailedException(__('Domain not registered, or not propagated yet. Please check your input and try again later.'), 'custom_domain');
            }
            $ns = [];
            foreach ($dns as $record) {
                if ($record['type'] === 'NS' && $record['host'] === $data['custom_domain']) {
                    $ns[$record['target']] = true;
                }
            }
            $ns = array_keys($ns);
            $valid_ns = ['ns1.byet.org', 'ns2.byet.org', 'ns3.byet.org', 'ns4.byet.org', 'ns5.byet.org', 'ns1.' . config('system.cpanel_url'), 'ns2.' . config('system.cpanel_url')];
            $present_ns = [];
            foreach ($ns as $r) {
                if (in_array($r, $valid_ns)) {
                    $present_ns[$r] = true;
                }
            }
            if (count(array_keys($present_ns)) < 2) {
                throw new ValidationFailedException(__('The domain\'s nameservers are not pointed properly. Please update the domain\'s DNS settings and try again.'), 'custom_domain');
            }
            unset($tld, $dns, $ns, $valid_ns, $present_ns);
        }

        // Captcha
        if (strlen($data['captcha_solution']) !== 5) {
            // Consideration: Store captcha ID in session so it can't be tampered with
            // but that might be too far fetched, especially when the captcha can be easily solved.
            // Add a captcha provider in later versions instead.
            throw new ValidationFailedException(__('The captcha solution you entered is incorrect. Please try again.'), 'captcha_solution');
        }
    })();
} catch (ValidationFailedException $e) {
    apiErrorResponse($e->getMessage(), [
        'type' => 'VALIDATION_FAILED',
        'field' => $e->getField(),
    ], true);
    die;
} catch (CsrfProtectException $e) {
    apiErrorResponse(__('CSRF token mismatched. Please refresh the page and try again.'), [
        'type' => 'CSRF_MISMATCHED',
    ], true);
    die;
}

$account = HostingAccount::create($data);
$toMerge = (SYSTEM_CONFIG['development_mode']) ? ['dev_raw' => $account['raw']] : [];
$response = [
    'status' => ($account['created']) ? 'success' : 'error',
    'message' => $account['details']['message'],
    'details' => Arr::only($account['details'], ['field', 'type', 'token'])
];
echo json_encode(array_merge($response, $toMerge));
die;
