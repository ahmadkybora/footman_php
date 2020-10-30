<?php
/**
 * Created by PhpStorm.
 * User: kybora
 * Date: 10/23/2020
 * Time: 2:35 PM
 */

namespace App\Controllers\Auth;


use App\Controllers\Controller;
use App\Models\User;
use App\Providers\CSRFToken;
use App\Providers\Redirect;
use App\Providers\Request;
use App\Providers\Session;
use App\Providers\ValidateRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        if(isAuthenticated())
        {
            redirectTo('/');
        }
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register()
    {
        if(Request::has('post'))
        {
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token))
            {
                $rules = [
                    'username' => ['required' => true, 'maxLength' => 20, 'string' => true, 'unique' => 'users'],
                    'email' => ['required' => true, 'email' => true, 'unique' => 'users'],
                    'first_name' => ['required' => true, 'maxLength' => 20, 'string' => true, 'unique' => true],
                    'last_name' => ['required' => true, 'maxLength' => 20, 'string' => true, 'unique' => true],
                    'password' => ['required' => true, 'minLength' => 8, 'string' => true, 'unique' => true],
                    'password_confirmation' => ['required' => true, 'maxLength' => 20, 'string' => true, 'unique' => true],
                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                if($validate->hasError())
                {
                    $errors = $validate->getErrorMessages();
                    return view('register', ['errors' => $errors]);
                }

                $user = new User();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->username = $request->username;
                $user->email = $request->email;
                $user->password = password_hash($request->password, PASSWORD_BCRYPT);
                if($user->save())
                {
                    Request::refresh();
                    return view('register', ['success' => 'Account Created, please login']);
                }
                throw new \Exception('token mismach');
            }
            return null;
        }
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login()
    {
        if(Request::has('post'))
        {
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token))
            {
                $rules = [
                    'username' => ['required' => true, 'maxLength' => 20, 'string' => true, 'unique' => 'users'],
                    'password' => ['required' => true, 'minLength' => 8, 'string' => true],
                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                if($validate->hasError())
                {
                    $errors = $validate->getErrorMessages();
                    return view('login', ['errors' => $errors]);
                }

                $userCheck = User::where('username', $request->username)->orWhere('email', $request->username)->firstOrFail();
                if($userCheck)
                {
                    if(!password_verify($request->password, $userCheck->password))
                    {
                        Session::add('error', 'Incorrect Password');
                        return view('login');
                    }
                    else
                    {
                        Session::add('SESSION_USER_ID', $userCheck->id);
                        Session::add('SESSION_USER_NAME', $userCheck->username);

                        if($userCheck->role == 'admin')
                        {
                            Redirect::to('/admin');
                        }
                        else if($userCheck->role == 'user' and Session::has('user_cart'))
                        {
                            Redirect::to('/cart');
                        }
                        else
                        {
                            Redirect::to('/');
                        }
                    }
                }
                else
                {
                    Session::add('error', 'User not found');
                    return view('login');
                }
                throw new \Exception('token mismach');
            }
            return null;
        }
    }

    public function logout()
    {
        if(isAuthenticated())
        {
            Session::remove('SESSION_USER_ID');
            Session::remove('SESSION_USER_NAME');

            if(!Session::has('user_cart'))
            {
            session_destroy();
            session_regenerate_id(true);
            }
        }
        Redirect::to('/');
    }
}