<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;

class HomePageTest extends TestCase
{
    /**
     * Check a contributor can see the 'Find an entry' and 'Add a new entry' button
     *
     * @return void
     */
    public function testAContributorCanViewButtons()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor');
        $response = $this->get(route('home'));
        $response->assertSuccessful();
        $response->assertSee('Find an entry');
        $response->assertSee('Add a new entry');
    }
}
