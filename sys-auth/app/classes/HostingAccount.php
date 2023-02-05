<?php

# Prevent direct file access
if (!defined('APP')) {
    die(header("HTTP/1.1 403 Forbidden"));
}

/**
 * Hosting Account Class
 * for LOGGED v2.x
 * 
 * @author     PlanetTheCloud <github.com/PlanetTheCloud>
 */
class HostingAccount
{
    /**
     * Create hosting account
     * 
     * @param array $param
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
     * Parse account creation result
     * 
     * @param mixed $result
     * 
     * @return array
     */
    public static function parseResult($result)
    {
        if ($result === false) {
            return [
                'created' => false,
                'raw' => $result,
                'details' => [
                    'type' => 'ERROR',
                ]
            ];
        }
        if (strpos($result, 'An activation email has now been sent to') !== false) {
            return [
                'created' => true,
                'raw' => $result
            ];
        }
        if (strpos($result, 'Security Code does not match') !== false) {
            return [
                'created' => false,
                'raw' => $result,
                'details' => [
                    'type' => 'REJECTION',
                    'field' => 'captcha_solution'
                    // add message field
                ]
            ];
        }
        if (strpos($result, 'is already assigned and in use') !== false) {
            return [
                'created' => false,
                'raw' => $result,
                'details' => [
                    'type' => 'REJECTION',
                    'field' => 'custom_domain'
                ]
            ];
        }
        if (strpos($result, 'The domain name choosen') !== false) {
            return [
                'created' => false,
                'raw' => $result,
                'details' => [
                    'type' => 'REJECTION',
                    'field' => 'custom_domain'
                    // domain not allowed or invalid
                ]
            ];
        }
        if (strpos($result, 'Please refresh the previous page, the captcha puzzle has') !== false) {
            return [
                'created' => false,
                'raw' => $result,
                'details' => [
                    'type' => 'REJECTION',
                    'field' => 'captcha_solution'
                ]
            ];
        }
        return [
            'created' => false,
            'raw' => $result,
            'details' => [
                'type' => 'ERROR',
            ]
        ];
    }
}
