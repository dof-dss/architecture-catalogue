<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;

use App\User;
use App\Entry;
use App\Tag;
use App\EntryTag;
use App\Link;

class CopyEntryTest extends TestCase
{
    /**
     * Check a contributor can copy an entry
     *
     * @return void
     */
    public function testConributorCanCopyAnEntry()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        // stops events being fired
        Event::fake();

        $user = $this->loginAsFakeUser(true, 'contributor');

        // create an entry
        $entry1 = factory(Entry::class)->create([
            'name' => 'Entry 1'
        ]);

        // create two other entries
        $entry2 = factory(Entry::class)->create([
            'name' => 'Entry 2'
        ]);
        $entry3 = factory(Entry::class)->create([
            'name' => 'Entry 3'
        ]);

        // create the last two entries as dependencies of the first entry
        Link::create([
            'item1_id' => $entry1->id,
            'item2_id' => $entry2->id,
            'relationship' => 'composed_of'
        ]);
        Link::create([
            'item1_id' => $entry1->id,
            'item2_id' => $entry3->id,
            'relationship' => 'composed_of'
        ]);

        // create two user defined tags
        $tag1 = Tag::create([
            'name' => 'tag1'
        ]);
        $tag2 = Tag::create([
            'name' => 'tag2'
        ]);

        // link the two user defined tags to the first entry
        EntryTag::create([
            'entry_id' => $entry1->id,
            'tag_id' => $tag1->id
        ]);
        EntryTag::create([
            'entry_id' => $entry1->id,
            'tag_id' => $tag2->id
        ]);

        // now copy it
        $this->followingRedirects()
            ->from('/entries/' . $entry1->id)
            ->get('/entries/' . $entry1->id . '/copy')
            ->assertSuccessful()
            ->assertSee(' Entry 1 - COPY')
            ->assertSee('tag1')
            ->assertSee('tag2')
            ->assertSee('Entry 2')
            ->assertSee('Entry 3');
    }
}
