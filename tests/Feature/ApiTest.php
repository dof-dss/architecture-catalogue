<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;

use App\PersonalAccessToken;

use \Illuminate\Support\Str;

class ApiTest extends TestCase
{
    /**
     * Check API menu option appears in top nav.
     *
     * @return void
     */
    public function testApiIsShownInTopNav()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'reader');
        $response = $this->get(route('home'));
        $response->assertSee('API');
    }

    /**
     * Check reader can view API tokens page.
     *
     * @return void
     */
    public function testReaderCanViewApiTokensPage()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'reader');
        $response = $this->get('tokens');
        $response->assertSee('API integration');
        $response->assertSee('Personal Access Tokens');
        $response->assertSee('You have not created any personal access tokens');
        $response->assertSee('Create a personal access token');
    }

    /**
     * Check reader can view API integration page.
     *
     * @return void
     */
    public function testReaderCanViewCreatePersonalAccessTokenPage()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'reader');
        $response = $this->get('tokens/create');
        $response->assertSee('Create personal access token');
        $response->assertSee('Continue');
    }

    /**
     * Check contributor can create a token
     *
     * @return void
     */
    public function testReaderCanAddValidPersonalAccessToken()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(true, 'reader');

        // stops events being fired
        Event::fake();

        $token = factory(PersonalAccessToken::class)->make();
        $this->followingRedirects()
            ->from('tokens/create')
            ->post('tokens', [
                'name' =>  $token->name
                ])
            ->assertSee($token->name);
    }

    /**
     * Check that token name is not too short
     *
     * @return void
     */
    public function testEntryValidationTokenNameTooShort()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(true, 'reader');

        // stops events being fired
        Event::fake();

        $token_name = $token = str::random(2);
        $this->followingRedirects()
            ->from('tokens/create')
            ->post('tokens', [
                'name' =>  $token_name
                ])
            ->assertSee('Name must be between 3 and 40 characters.');
    }

    /**
     * Check that token name is not too long
     *
     * @return void
     */
    public function testEntryValidationTokenNameTooLong()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(true, 'reader');

        // stops events being fired
        Event::fake();

        $token_name = str::random(41);
        $this->followingRedirects()
            ->from('tokens/create')
            ->post('tokens', [
                'name' =>  $token_name
                ])
            ->assertSee('Name must be between 3 and 40 characters.');
    }

    /**
     * Check reader can't create duplicate token
     *
     * @return void
     */
    public function testReaderCannotAddDuplicateToken()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(true, 'reader');

        // stops events being fired
        Event::fake();

        $token = factory(PersonalAccessToken::class)->make();
        $this->followingRedirects()
            ->from('tokens/create')
            ->post('tokens', [
                'name' =>  $token->name
                ])
            ->assertSee($token->name);

        $this->followingRedirects()
            ->from('tokens/create')
            ->post('tokens', [
                'name' =>  $token->name
                ])
            ->assertSee('A token with this name already exists.');
    }
}
