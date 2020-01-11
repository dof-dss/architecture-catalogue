<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function request()
    {
        return view('admin.request');
    }

    public function create()
    {
        // not implemented so just show page not found
        abort(404);
    }
}
