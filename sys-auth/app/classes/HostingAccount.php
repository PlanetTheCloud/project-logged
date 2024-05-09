<?php

# Prevent direct file access
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * Hosting Account Class
 * for LOGGED v2.x
 * 
 * @author  PlanetTheCloud <github.com/PlanetTheCloud>
 */
class HostingAccount
{


    /**
     * DEPRECATION NOTICE: Per v2.2 the IP address must match when the form is submitted.
     * Create hosting account
     * 
     * @param array $data
     * 
     * @throws HostingAccountException
     * 
     * @return array
     */
    public static function create(array $data)
    {
        $referrer = ($data['domain_type'] === 'subdomain') ? $data['extension'] : config('system.cpanel_url');
        $toMerge = ($data['domain_type'] === 'subdomain') ? ['username' => $data['subdomain']] : ['domain_name' => $data['custom_domain']];
        $param = array_merge([
            'email' => $data['email'],
            'password' => $data['password'],
            'PlanName' => config('system.default_plan', 'Starter'),
            'id' => $data['captcha_id'],
            'number' => $data['captcha_solution'],
        ], $toMerge);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://ifastnet.com/register2.php");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Referer: https://' . $referrer . '/'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS | CURLPROTO_HTTP);
        curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTPS);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new HostingAccountException('Fail to create account: ' . curl_error($ch), curl_errno($ch));
        }
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
            throw new HostingAccountException('Byet server did not respond with HTTP 200 OK');
        }
        curl_close($ch);

        return self::parseResult($result);
    }

    /**
     * Return parameters to submit to iFastNet for account creation
     * 
     * @param array $data
     * 
     * @return array
     */
    public static function getAccountCreationParamters(array $data)
    {
        $toMerge = ($data['domain_type'] === 'subdomain') ? ['username' => $data['subdomain']] : ['domain_name' => $data['custom_domain']];
        return array_merge([
            'email' => $data['email'],
            'password' => $data['password'],
            'PlanName' => config('system.default_plan', 'Starter'),
            'id' => $data['captcha_id'],
            'number' => $data['captcha_solution'],
        ], $toMerge);
    }

    /**
     * Parse account creation result
     * 
     * @param mixed $result
     * 
     * @return array
     */
    public static function parseResult($result)
    {
        $return = (function () use ($result) {
            if ($result === false) {
                return [
                    'created' => false,
                    'details' => [
                        'type' => 'ERROR',
                        'message' => __('An unknown error has occurred. Please try again.'),
                    ],
                ];
            }
            if (strpos($result, 'An activation email has now been sent to') !== false) {
                preg_match_all('/&token=(\w+)/m', $result, $matches, PREG_SET_ORDER, 0);
                if (!isset($matches[0][1])) {
                    file_put_contents(
                        APP . '/logs/missing_tokens.txt',
                        'Fail to find the token in response. Raw: ' . $result . ' Parsed: ' . json_encode($matches) . PHP_EOL,
                        FILE_APPEND
                    );
                    $matches[0][1] = 'error_please_contact_support_to_resend_email';
                }
                return [
                    'created' => true,
                    'details' => [
                        'type' => 'ACCOUNT_CREATED',
                        'message' => __('Thank you for signing up! To activate your account, please check your email and click the activation link we\'ve sent to you. If you don\'t receive the email within a few minutes, please check your spam folder.'),
                        'token' => $matches[0][1]
                    ],
                ];
            }
            if (strpos($result, 'Security Code does not match') !== false) {
                return [
                    'created' => false,
                    'details' => [
                        'type' => 'ERROR',
                        'message' => __('The captcha you entered is incorrect. Please try again.'),
                        'field' => 'captcha_solution',
                    ],
                ];
            }
            if (strpos($result, 'Account Name is already in use') !== false) {
                return [
                    'created' => false,
                    'details' => [
                        'type' => 'ERROR',
                        'message' => __('The subdomain chosen has been taken. Please choose a different subdomain.'),
                        'field' => 'subdomain',
                    ],
                ];
            }
            if (strpos($result, 'is already assigned and in use') !== false || strpos($result, 'in use, please try a different username') !== false) {
                return [
                    'created' => false,
                    'details' => [
                        'type' => 'ERROR',
                        'message' => __('The domain you entered has already been assigned to an account and cannot be used again. Please enter a different domain.'),
                        'field' => 'custom_domain'
                    ],
                ];
            }
            if (strpos($result, 'The domain name choosen') !== false) {
                return [
                    'created' => false,
                    'details' => [
                        'type' => 'ERROR',
                        'message' => __('The domain name chosen is not allowed or invalid. Please enter a different domain.'),
                        'field' => 'custom_domain',
                    ],
                ];
            }
            if (strpos($result, 'Please refresh the previous page, the captcha puzzle has') !== false) {
                return [
                    'created' => false,
                    'details' => [
                        'type' => 'ERROR',
                        'message' => __('There\'s an error with the captcha. Please refresh and try again.'),
                        'field' => 'captcha_solution',
                    ],
                ];
            }
            if (strpos($result, 'Posting Error, #') !== false) {
                return [
                    'created' => false,
                    'details' => [
                        'type' => 'ERROR',
                        'message' => __('Something went wrong with our system. Please contact our support and provide them with this ID: HA010'),
                    ],
                ];
            }
            return [
                'created' => false,
                'details' => [
                    'type' => 'ERROR',
                    'message' => __('An unknown error has occurred. Please try again.'),
                ],
            ];
        })();

        return array_merge($return, ['raw' => $result]);
    }
}
