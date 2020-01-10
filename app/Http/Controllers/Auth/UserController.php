<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function request()
    {
        return view('admin.request');
    }
}
