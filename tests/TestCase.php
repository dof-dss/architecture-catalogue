<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loginAsFakeUser($persistUser)
    {
        // create a user and login
        if ($persistUser) {
            $user = factory(User::class)->create();
        } else {
            $user = factory(User::class)->make();
        }
        $this->actingAs($user);

        $line = __FUNCTION__ . ': ';
        if (Auth::check()) {
            $line = $line . 'User "' . $user->name . '" is authenticated';
        } else {
            $line = $line . 'User "' . $user->name . '" is not authenticated';
        }
        Log::debug($line);
    }
}
