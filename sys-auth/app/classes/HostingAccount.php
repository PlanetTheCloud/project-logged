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
     * @return boolean|array
     */
    public static function create(array $param)
    {
        $referrer = ($param['domain_type'] === 'subdomain') ? $param['extension'] : config('system.cpanel_url');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://ifastnet.com/register2.php");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Referer: https://'. $referrer .'/'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
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

        return $result;
    }

    public static function parseResult($result)
    {
        if ($result === false) {
            return false;
        }
        // string contains
    }
}
