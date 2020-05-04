<?php

namespace Tests\Feature\Dependencies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;

use App\Entry;
use App\Link;

class ChangeDependenciesTest extends TestCase
{
    /**
     * Check a contributor can see change dependencies link.
     *
     * @return void
     */
    public function testContributorCanSeeChangeLink()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up an entry
        $entry = factory(Entry::class)->create();

        $response = $this->get('/entries/' . $entry->id);
        $response->assertSuccessful();
        $response->assertSee('change related entries');
    }

    /**
     * Check a contributor can view the dependencies for an entry.
     *
     * @return void
     */
    public function testContributorCanSeeDependencies()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up a link between two entries
        $link = factory(Link::class)->create();

        $response = $this->get('/entries/' . $link->item1_id . '/links');
        $response->assertSuccessful();
        $response->assertSee('Dependencies for ' . $link->child->name);
        $response->assertSee($link->child->name);
        $response->assertSee('Add dependency');
    }

    /**
     * Check a contributor can add a dependency.
     *
     * @return void
     */
    public function testContributorCanAddDependency()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up a first entry
        $entry1 = factory(Entry::class)->create([
            'name' => 'Drupal'
        ]);

        // mock up a second entry
        $entry2 = factory(Entry::class)->create([
            'name' => 'Linux'
        ]);

        // search for the second entry - disabled as elasticsearch not working with CircleCI
        // $response = $this->get('/entries/' .  $entry1->id . '/links/search?entry_id=' . $entry1->id . '&phrase=' .  $entry2->name);
        // $response->assertSee($entry2->name);

        // link to the second entry
        $this->followingRedirects()
            ->from('/entries/' . $entry1->id. '/links/search?entry_id=' . $entry1->id . '&phrase=' .  $entry2->name)
            ->post('/entries/' . $entry1->id . '/links', [
                'entry_id' => $entry1->id,
                'link-' . $entry2->id => $entry2->id
            ])
            ->assertSee('View catalogue entry')
            ->assertSee($entry1->name)
            ->assertSee($entry2->name);
    }

    /**
     * Check a contributor can remove a dependency.
     *
     * @return void
     */
    public function testContributorCanRemoveDependency()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up a link between two entries
        $link = factory(Link::class)->create();

        // remove the link between these two entries
        $this->followingRedirects()
            ->from('/entries/' . $link->item1_id . '/links')
            ->post('/entries/' . $link->item1_id . '/links/' . $link->id, [
                '_method' => 'DELETE'
            ])
            ->assertSee('View catalogue entry')
            ->assertDontSee($link->parent->name);
    }

    /**
     * Check a contributor cannot add the same dependency twice.
     *
     * @return void
     */
    public function testContributorCannotAddSameDependencyTwice()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck = 'assertSee');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // mock up a link between two entries
        $link = factory(Link::class)->create();
        $entry1 = $link->child;
        $entry2 = $link->parent;

        // try to link the two entries again
        $this->followingRedirects()
            ->from('/entries/' . $entry1->id. '/links/search?entry_id=' . $entry1->id . '&phrase=' .  $entry2->name)
            ->post('/entries/' . $entry1->id . '/links', [
                'entry_id' => $entry1->id,
                'link-' . $entry2->id => $entry2->id
            ])
            ->assertSee('There is a problem')
            ->assertSee('already exists');

    }
}
