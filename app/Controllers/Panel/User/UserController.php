<?php

namespace App\Controllers\Panel\User;

use App\Models\User;

class UserController
{
    public function index()
    {
        $users = User::all();
        var_dump("ok");
        die();
        return $users;
        return view('panel/users/index', compact('users'));
    }

    public function create()
    {

    }

    public function store()
    {

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