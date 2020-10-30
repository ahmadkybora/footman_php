<?php

namespace App\Providers;


class CSRFToken extends ServiceProvider
{
    /**
     * CSRFToken constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        return static::generate_token();
    }

    /**
     * Generate Token
     *
     * @return mixed
     * @throws \Exception
     */
    public static function generate_token()
    {
        if (!Session::has('token')) {
            $random_token = base64_encode(openssl_random_pseudo_bytes(32));
            Session::add('token', $random_token);
        }

        return Session::get('token');
    }

    /**
     * verify CSRF Token
     *
     * @param $requestToken
     * @return bool
     * @throws \Exception
     */
    public static function verifyCSRFToken($requestToken)
    {
        if(Session::has('token') and Session::get('token') === $requestToken)
        {
//            dd(Session::remove('token'));
            return true;
        }

        return false;
    }
}