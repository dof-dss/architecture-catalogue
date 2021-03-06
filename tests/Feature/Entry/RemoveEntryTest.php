<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;

use App\User;
use App\Entry;
use App\Link;

class RemoveEntryTest extends TestCase
{
    /**
     * Check a contributor is challenged when removing an entry
     *
     * @return void
     */
    public function testConributorRemoveEntryConfirmationStep()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        // stops events being fired
        Event::fake();

        $user = $this->loginAsFakeUser(true, 'contributor');

        // create an entry
        $entry = factory(Entry::class)->create([
            'name' => 'AWS S3'
        ]);
        $this->assertDatabaseHas('entries', [
            'name' => $entry->name
        ]);

        // now delete it
        $this->followingRedirects()
            ->from('/entries/' . $entry->id)
            ->get('/entries/' . $entry->id . '/delete')
            ->assertSuccessful()
            ->assertSee('Are you sure');
    }

    /**
     * Check a contributor cannot remove an entry with dependencies
     *
     * @return void
     */
    public function testConributorCannotRemoveEntryWithDependencies()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        // stops events being fired
        Event::fake();

        $user = $this->loginAsFakeUser(true, 'contributor');

        // create an entry
        $entry1 = factory(Entry::class)->create([
            'name' => 'Architecture Catalogue'
        ]);
        // create a second entry
        $entry2 = factory(Entry::class)->create([
            'name' => 'GOV.UK PaaS'
        ]);
        // make entry1 dependent upon entry2
        Link::create([
            'item1_id' => $entry1->id,
            'item2_id' => $entry2->id,
            'relationship' => 'composed_of'
        ]);

        // now try to delete it
        $this->followingRedirects()
            ->from('/entries/' . $entry2->id)
            ->get('/entries/' . $entry2->id . '/delete')
            ->assertSuccessful()
            ->assertSee('This entry cannot be deleted');
    }

    /**
     * Check a contributor can remove an entry
     *
     * @return void
     */
    public function testConributorCanRemoveAnEntry()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        // stops events being fired
        Event::fake([
            'App\Events\AccountCreated'
        ]);

        $user = $this->loginAsFakeUser(true, 'contributor');

        // create an entry
        $entry = factory(Entry::class)->create([
            'name' => 'AWS S3'
        ]);
        $this->assertDatabaseHas('entries', [
            'name' => $entry->name
        ]);

        // now delete it
        $this->followingRedirects()
            ->from('/entries/' . $entry->id . '/delete')
            ->post('/entries/' . $entry->id, [
                '_method' => 'DELETE',
            ]);
        $this->assertDatabaseMissing('entries', [
            'name' => 'AWS S3'
        ]);
    }
}
