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
    public function testContributorCanSeeBackLinkWhenViewingAnEntryAfterBrowsing()
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
            ->get('/entries/1')
            ->assertSee('Back to browse catalogue');
    }

    /**
     * Check a contributor can see a back link when viewing an entry after searching
     *
     * @return void
     */
    public function testContributorCanSeeBackLinkWhenViewingAnEntryAfterSearching()
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
            ->get('/entries/1')
            ->assertSee('Back to search results');
    }


    /**
     * Check a contributor can't see a back link when viewing an entry editing
     *
     * @return void
     */
    public function testContributorCantSeeBackLinkWhenViewingAnEntryAfterEditing()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up an a number of entries
        factory(Entry::class, 125)->create();
        // fetch the entry with an id of 1
        $entry = Entry::find(1);

        $this->followingRedirects()
          ->from('/entries/' . $entry->id . '/edit')
          ->post('/entries/' . $entry->id, [
              '_method' => 'PUT',
              'id' => $entry->id,
              'name' => 'UPDATED',
              'version' => $entry->version,
              'description' => $entry->description,
              'href' => $entry->href,
              // category and sub_category are sent through from the UI like this
              'category_subcategory' => $entry->category . "-" . $entry->sub_category,
              'status' => $entry->status,
              'functionality' => $entry->functionality,
              'service_levels' => $entry->service_levels,
              'interfaces' => $entry->interfaces
          ])
          ->assertSuccessful()
          ->assertDontSee('Back to browse catalogue')
          ->assertDontSee('Back to search results');
    }
}
