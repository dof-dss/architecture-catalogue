<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;

use App\User;
use App\Entry;

class ViewEntryTest extends TestCase
{
    /**
     * Check a contributor can see a back link when viewing an entry after browsing
     *
     * @return void
     */
    public function testContributorCanSeeBreadcrumbsViewingAnEntryAfterBrowsing()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up an a number of entries
        $entry = factory(Entry::class, 125)->create();

        $this->followingRedirects()
            ->from('/entries')
            ->get('/entries/1?path=' . config('app.url') . '/entries')
            ->assertSee('Entries')
            ->assertSee('View entry');
    }

    /**
     * Check a contributor can see a back link when viewing an entry after searching
     *
     * @return void
     */
    public function testContributorCanSeeBreadcrumbsWhenViewingAnEntryAfterSearching()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up an a number of entries
        $entry = factory(Entry::class, 125)->create();

        // perform the search
        $this->followingRedirects()
            ->from('/catalogue/search?phrase=other')
            ->get('/entries/1?path=' . config('app.url') . '/catalogue/search')
            ->assertSee('Search')
            ->assertSee('Results')
            ->assertSee('View entry');
    }
}
