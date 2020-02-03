<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // validation

        // update admin and role if present in the request and if not reset to default value
        if ($request->has('admin')) {
            $user->admin = true;
        } else {
            $user->admin = false;
        }
        if ($request->has('role')) {
            $user->role = 'contributor';
        } else {
            $user->role = 'reader';
        }
        $user->save();
        return redirect('/users');
    }
}
