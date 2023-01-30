<?php

require __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /auth/signup");
    echo __('Taking you to our signup page... If the page doesn\'t refresh automatically, <a href="/auth/signup">click here.</a>');
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
            throw new ValidationFailedException(__('Invalid email address given'), 'email');
        }

        // Password
        $l = strlen($data['password']);
        if ($l < 6 || $l > 20) {
            throw new ValidationFailedException(__('Password must be between 6 and 20 in length'), 'password');
        }
        unset($l);
        if ($data['password'] !== $data['password_confirm']) {
            throw new ValidationFailedException(__('Password confirmation must match the password given'), 'password_confirm');
        }

        // Domain
        if (!in_array($data['domain_type'], ['subdomain', 'custom_domain'])) {
            throw new ValidationFailedException(__('Invalid domain type given'), 'domain_type');
        }
        if ($data['domain_type'] === 'subdomain') {
            $data['subdomain'] = strtolower($data['subdomain']);
            if (!in_array($data['extension'], config('system.domain_selection'))) {
                throw new ValidationFailedException(__('Unable to find the given extension'), 'extension');
            }
            if (!preg_match('/^[A-Za-z0-9-]{4,16}$(?<!-)/', $data['subdomain'])) {
                throw new ValidationFailedException(__('Invalid subdomain given'), 'subdomain');
            }
        }
        if ($data['domain_type'] === 'custom_domain') {
            $data['custom_domain'] = strtolower($data['custom_domain']);
            if (!preg_match('/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/', $data['custom_domain'])) {
                throw new ValidationFailedException(__('Invalid custom domain given'), 'custom_domain');
            }
            // Check TLD blacklist
            $tld = explode('.', $data['custom_domain']);
            $tld = $tld[count($tld) - 1];
            if (in_array($tld, config('system.blacklisted_tld'))) {
                throw new ValidationFailedException(__('Unsupported custom domain TLD given', 'custom_domain'));
            }
            // Check DNS is pointed at us
            $dns = dns_get_record($data['custom_domain'], DNS_NS);
            if (!$dns) {
                throw new ValidationFailedException(__('Domain not registered, or not propagated yet'), 'custom_domain');
            }
            $ns = [];
            foreach ($dns as $record) {
                if ($record['type'] === 'NS' && $record['host'] === $data['custom_domain']) {
                    $ns[$record['target']] = true;
                }
            }
            $ns = array_keys($ns);
            if (count($ns) < 2) {
                throw new ValidationFailedException(__('Domain\'s nameservers are not pointed properly', 'custom_domain'));
            }
            $valid_ns = [];
            foreach (['ns1', 'ns2', /*'ns3', 'ns4'*/] as $n) {
                $valid_ns[] = $n . '.' . config('system.cpanel_url');
            }
            foreach ($ns as $r) {
                if (!in_array($r, $valid_ns)) {
                    throw new ValidationFailedException(__('Domain is not pointed to our servers'), 'custom_domain');
                }
            }
            unset($tld, $dns, $ns, $valid_ns);
        }

        // Captcha
        if (strlen($data['captcha_solution']) !== 5) {
            // Consideration: Store captcha ID in session so it can't be tampered with
            // but that might be too far fetched, especially when the captcha can be easily solved.
            // Add a captcha provider in later versions instead.
            throw new ValidationFailedException(__('Incorrect captcha solution given'), 'captcha_solution');
        }
    })();
} catch (ValidationFailedException $e) {
    apiErrorResponse($e->getMessage(), [
        'type' => 'VALIDATION_FAILED',
        'field' => $e->getField()
    ], true);
    die;
} catch (CsrfProtectTokenMismatchException $e) {
    apiErrorResponse('CSRF token mismatched. Please refresh the page.', [
        'type' => 'CSRF_MISMATCHED',
    ], true);
    die;
}

die('done');

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

$account = HostingAccount::create($data);
if ($account['created'] === false) {
    return 'error';
}

echo $result;
