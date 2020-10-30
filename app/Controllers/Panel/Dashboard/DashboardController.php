<?php

namespace App\Controllers\Panel\Dashboard;

use App\Controllers\Controller;
use App\Layer\Middleware;
use App\Models\User;
use App\Providers\Mail;
use App\Providers\Redirect;
use App\Providers\Request;
use App\Providers\Session;

class DashboardController extends Controller
{
    public function __construct()
    {
        if(!Middleware::middleware('admin'))
        {
            Redirect::to('/login');
        }
    }

    public function index()
    {
//        $mail = new Mail();
//        $data = [
//            'to' => 'amontazeri53@gmail.com',
//            'subject' => 'welcome to',
//            'view' => 'user-activision',
//            'name' => 'John Doe',
//            'body' => 'Testing mail',
//        ];
//        if($mail->send($data))
//            echo "Email send successfully";
//        else
//            echo "Email sending failed";

//        echo "hello world";
//        $user = User::where('id', 1)->firstOrFail();
//        return $user;
//        $a = Session::add('admin', 'you are welcome');
//        dd($a);
        return view('panel/dashboard/home');
    }

    public function create()
    {
        
    }

    public function store()
    {
        $request = Request::input('post');
        dd($request);
    }
    
    public function show()
    {
        
    }

    public function edit()
    {
        
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}