<?php

namespace App\Http\Controllers\Public\Api;

use Stevebauman\Location\Facades\Location;

class UsersController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Получаем реальный IP клиента.
     *
     * @return string|void
     */
    public function getIp()
    {
//        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
//            if (array_key_exists($key, $_SERVER) === true) {
//                foreach (explode(',', $_SERVER[$key]) as $ip) {
//                    $ip = trim($ip);
//                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
//                        return $ip;
//                    }
//                }
//            }
//        }
        $ipAddress = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // to get shared ISP IP address
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check for IPs passing through proxy servers
            // check if multiple IP addresses are set and take the first one
            $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($ipAddressList as $ip) {
                if (!empty($ip)) {
                    // if you prefer, you can check for valid IP address here
                    $ipAddress = $ip;
                    break;
                }
            }
        } else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        return $ipAddress;
    }

    /**
     *  Получаем месторасположение клиента.
     *
     * @return string[]|void[]
     */
    public function getUserInfo()
    {
        $location = Location::get();

        $userAgent = \request()->header('User-Agent');
        return $this->returnResponse([
            'location' => $location,
            'userAgent' => $userAgent,
        ]);
    }
}
