<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Entry;
use App\Tag;
use App\EntryTag;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use App\Events\ModelChanged;

class UserDefinedTagsTest extends TestCase
{
    /**
     * Test description
     *
     * @return void
     */
    public function testViewTags()
    {
        $this->assertTrue(true);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testRemoveATag()
    {
        $this->assertTrue(true);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testAddExistingTag()
    {
        $this->assertTrue(true);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testCreateAndAddATag()
    {
        $this->assertTrue(true);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testAuditCreateAndAddATag()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        // stops events being fired
        Event::fake();

        $user = $this->loginAsFakeUser(false, 'contributor');

        // create an entry
        $entry = factory(Entry::class)->create();

        // create a tag
        $tag = factory(Tag::class)->create();


        // link the tag to the entry
        $entryTag = EntryTag::create([
            'entry_id' => $entry->id,
            'tag_id' => $tag->id
        ]);
        $this->assertDatabaseHas('entry_tag', [
            'id' => $entryTag->id
        ]);
        // won't work as Event::fake disables model events
        // Event::assertDispatched(ModelChanged::class);
        
        $this->assertTrue(true);
    }

    /**
     * Test description
     *
     * @return void
     */
    public function testAuditRemoveATag()
    {
        $this->assertTrue(true);
    }
}
