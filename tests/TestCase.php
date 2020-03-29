<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function loginAsFakeUser($persistUser)
    {
        // create a user and login
        if ($persistUser) {
            $user = factory(User::class)->create();
        } else {
            $user = factory(User::class)->make();
        }
        $this->actingAs($user);
        return $user;
    }
}
