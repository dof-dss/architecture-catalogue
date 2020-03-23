<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class UserTest extends TestCase
{
    /**
     * Test description
     *
     * @return void
     */
    public function test_user_can_view_a_sign_up_form()
    {
        $response = $this->get('/register');
        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }

  /**
     * Test description
     *
     * @return void
     */
    public function test_user_can_create_a_valid_account()
    {
        $this->assertTrue(true);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function test_user_can_view_a_login_form()
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
    public function test_user_cannot_view_a_login_form_when_authenticated()
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
    public function test_user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($passwrod = 'digital-development'),
        ]);
        $response = $this->post('/login', [
            'email' => '$user->email',
            'password' => $password,
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAsUser($user);
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

    /**
     * Test description
     *
     * @return void
     */
    public function testSignOut()
    {
        $this->assertTrue(true);
    }
}
