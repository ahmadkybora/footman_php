<?php

namespace App\Layer;

use App\Providers\Session;

class Middleware
{
    public static function middleware($role)
    {
        $message = '';
        switch ($role)
        {
            case 'admin':
                $message = 'you are not authorized to view admin panel';
                break;

            case 'user':
                $message = 'you are not authorized to view this page';
                break;
        }

        if(isAuthenticated())
        {
            if(user()->role != $role);
            {
                Session::add('error', $message);
                return false;
            }
        }
        else
        {
            Session::add('error', $message);
            return false;
        }

        return true;
    }
}