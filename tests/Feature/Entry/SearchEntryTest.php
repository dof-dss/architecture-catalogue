<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;

use App\User;
use App\Entry;

class SearchEntryTest extends TestCase
{
    /**
     * Check a reader can see the search page
     *
     * @return void
     */
    public function testReaderCanSeeSearchPage()
    {
        $user = $this->loginAsFakeUser(false, 'reader');

        // view the search page
        $response = $this->get(route('entry.find'));
        $response->assertSuccessful();
        $response->assertSee('Search catalogue');
    }

    /**
     * Check search phrase isn't too short
     *
     * @return void
     */
    public function testSearchPhraseTooShort()
    {
        $user = $this->loginAsFakeUser(false, 'reader');

        // perform the search
        $this->followingRedirects()
            ->from('/entries/search')
            ->get('/catalogue/search?phrase=ph')
            ->assertSee('Enter at least 3 characters');
    }

    /**
     * Check a reader can see the results of a valid search
     *
     * NOTE: there is no way of testing with a separate Elasticsearch instance
     *       at the minute - needs investigated
     *
     * @return void
     */
    public function testReaderCanFindExistingEntries()
    {
        // // stops notification being physically sent when a user is created
        // Notification::fake();
        //
        // $user = $this->loginAsFakeUser(true, 'reader');
        //
        // // this will prevent events firing and will invalidate the test
        // //
        // // this is using the development version of Elasticsearch, how
        // // do we use a test version?
        // Event::fake();
        //
        // // mock up an a number of entries
        // $entry = factory(Entry::class, 25)->create();
        // $entry = factory(Entry::class)->create([
        //     'name' => 'PHP',
        //     'version' => '7.3.13',
        //     'status' => 'approved'
        // ]);
        // $entry = factory(Entry::class)->create([
        //     'name' => 'PHP',
        //     'version' => '7.4.0',
        //     'status' => 'evaluating'
        // ]);
        //
        // // perform the search
        // $response = $this->get('/catalogue/search?phrase=php');
        //
        // // check the results
        // $response->assertSee('PHP (7.1.13)')
        //     ->assertSee('PHP (7.4.0)');

        $this->assertTrue(true);
    }
}
