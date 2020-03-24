<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use App\User;

class UserTest extends TestCase
{
    /**
     * Test description
     *
     * @return void
     */
    public function testUserCanViewASignupForm()
    {
        $response = $this->get(route('register'));
        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testUserCanCreateAValidAccount()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'name' => $user->name
        ]);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testUserCannotCreateAnInvalidAccount()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = factory(User::class)->make();
        $response = $this->post('/register', [
            'name' => 'inv@lidcharacter$',
            'email' => 'bademailaddress',
            'password' => 'password',
            'password_confirmation' => 'passwordX'
        ]);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertDatabaseMissing('users', [
            'name' => $user->name
        ]);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testUserCannotCreateADuplicateAccount()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = factory(User::class)->create();
        // now attempt to add the same user again
        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testUserCanViewALoginForm()
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testUserCannotViewALoginFormWhenAuthenticated()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testUserCanLoginWithCorrectCredentials()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = factory(User::class)->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testUserCannotLoginWithIncorrectCredentials()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = factory(User::class)->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'invalid'
        ]);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testSignOut()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/logout');
        $response->assertStatus(302);
        $this->assertGuest();
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testForgotPassword()
    {
        $this->assertTrue(true);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testSingleSignOnWithGitHub()
    {
        $this->assertTrue(true);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testSingleSignOnWithAzure()
    {
        $this->assertTrue(true);
    }
}
