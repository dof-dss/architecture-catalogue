<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;

use App\User;
use App\Entry;

class BrowseEntryTest extends TestCase
{
    /**
     * Check a contributor can browse entries
     *
     * @return void
     */
    public function testContributorCanSeePagedListOfEntries()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up an a number of entries
        $entry = factory(Entry::class, 75)->create();

        // now browse the list
        $response = $this->get('/entries');
        $response->assertSuccessful();
        $response->assertSee('Browse catalogue')
          ->assertSee('Showing 1 - 50 of 75 entries');
    }

    /**
     * Check a contributor can browse entries
     *
     * @return void
     */
    public function testContributorCanSeeNextPageOfEntries()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up an a number of entries
        $entry = factory(Entry::class, 125)->create();

        // now browse the list
        $response = $this->get('/entries?page=2');
        $response->assertSuccessful();
        $response->assertSee('Browse catalogue')
          ->assertSee('Showing 51 - 100 of 125 entries');
    }

    /**
     * Check a contributor can browse entries
     *
     * @return void
     */
    public function testContributorCanSeePreviousPageOfEntries()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up an a number of entries
        $entry = factory(Entry::class, 125)->create();

        // simulate clicking Next
        $response = $this->get('/entries?page=2');
        $response->assertSuccessful();

        // simulate clicking Previous
        $response = $this->get('/entries?page=1');
        $response->assertSuccessful();
        $response->assertSee('Browse catalogue')
          ->assertSee('Showing 1 - 50 of 125 entries');
    }

    /**
     * Check a contributor can filter entries by status
     *
     * @return void
     */
    public function testContributorCanFilterByStatus()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up an a number of entries
        $entry = factory(Entry::class, 125)->create([
            'name' => 'Approved entry',
            'status' => 'approved'
        ]);
        $entry = factory(Entry::class)->create([
            'name' => 'Prohibited entry',
            'status' => 'prohibited'
        ]);

        $response = $this->get('/entries?status=prohibited');
        $response->assertSuccessful();
        $response->assertDontSee('Approved entry');
    }

    /**
     * Check a contributor can filter entries by category / subcategory
     *
     * @return void
     */
    public function testContributorCanFilterByCategorySubcategory()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up an a number of entries
        $entry = factory(Entry::class, 125)->create([
            'name' => 'Uncategorised entry',
            'category' => 'Other',
            'sub_category' => 'Not categorised'
        ]);
        $entry = factory(Entry::class)->create([
            'category' => 'Business Applications',
            'sub_category' => 'Information Consumer Applications'
        ]);

        $response = $this->get('/entries?category_subcategory=Business Applications-Information Consumer Applications');
        $response->assertSuccessful();
        $response->assertDontSee('Uncategorised entry');
    }

    /**
     * Check a contributor can view a catalogue entry in the list
     *
     * @return void
     */
    public function testContributorCanViewAnEntryInTheList()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up an a number of entries
        $entry = factory(Entry::class, 50)->create();

        // now browse the list
        $response = $this->get('/entries');
        $response->assertSuccessful();
        $response->assertSee('/entries/50');
    }
}
