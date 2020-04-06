<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;

use App\User;
use App\Entry;

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

        $user = $this->loginAsFakeUser(true, 'contributor');

        // stops events being fired (i.e. will prevent audit)
        Event::fake();

        // create an entry
        $entry = factory(Entry::class)->create([
            'name' => 'AWS S3'
        ]);

        // now copy it
        $this->followingRedirects()
            ->from('/entries/' . $entry->id)
            ->get('/entries/' . $entry->id . '/copy')
            ->assertSuccessful()
            ->assertSee(' AWS S3 - COPY');
    }
}
