<?php

namespace App\Http\Controllers\Admin\Api;

/**
 * Class BaseController
 * @package App\Http\Controllers\Api
 */
class BaseController extends \App\Http\Controllers\Admin\BaseController
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function returnResponse(array $response, $status_code = 200, array $headers = [], $cookie = [])
    {
        if (empty($cookie)) {
            return response()->json($response, $status_code, $headers);
        } else {
            return response()->json($response, $status_code, $headers)->withCookie(cookie($cookie['name'], $cookie['value']), $cookie['time'] ?? 980000, '/');
        }
    }
}
