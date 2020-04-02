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

    /**
     * Helper function
     *
     * @param boolean $persistUser
     * @param string $role
     * @param boolean $admin
     * @return void
     */
    public function loginAsFakeUser($persistUser, $role = 'reader', $admin = false)
    {
        // create a user and login
        if ($persistUser) {
            $user = factory(User::class)->create([
                'role' => $role,
                'admin' => $admin
            ]);
        } else {
            $user = factory(User::class)->make([
                'role' => $role,
                'admin' => $admin
            ]);
        }
        $this->actingAs($user);
        return $user;
    }
}
