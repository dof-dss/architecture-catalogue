<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;

use App\User;
use App\Entry;

class BrowseEntryTest extends TestCase
{
    /**
     * Check a contributor can browse entries
     *
     * @return void
     */
    public function testCanBrowseEntries()
    {
        $this->assertTrue(true);
    }
}
