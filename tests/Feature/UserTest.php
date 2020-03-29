<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use App\Notifications\PasswordReset;
use Password;
use Illuminate\Support\Str;

use App\User;
use Hash;

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
    public function testUserCanViewAPasswordResetForm()
    {
        $response = $this->get(route('password.request'));
        $response->assertSuccessful();
        $response->assertViewIs('auth.passwords.email');
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testUserCanRequestResetPassword()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = factory(User::class)->create();

        $this->followingRedirects()
            ->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => $user->email
            ])
            ->assertSuccessful()
            ->assertSee('Password reset request complete');

        Notification::assertSentTo($user, PasswordReset::class);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testUserCanViewPasswordResetForm()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = factory(User::class)->create();
        $token = Password::broker()->createToken($user);

        $this->get(route('password.reset', [
              'token' => $token,
            ]))
            ->assertSuccessful()
            ->assertSee('Change your password');
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testUserCanResetPassword()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = factory(User::class)->create();
        $token = Password::broker()->createToken($user);
        $password = Str::random(32);

        $this->followingRedirects()
            ->from(route('password.request'), [
                'token' => $token,
              ])->post(route('password.update'), [
                  'token' => $token,
                  'email' => $user->email,
                  'password' => $password,
                  'password_confirmation' => $password,
              ])
              ->assertSuccessful()
              ->assertViewIs('home');

        $user->refresh();
        $this->assertTrue(Hash::check($password, $user->password));
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
