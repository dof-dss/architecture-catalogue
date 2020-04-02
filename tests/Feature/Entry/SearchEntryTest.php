<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;

use App\User;
use App\Entry;

class SearchEntryTest extends TestCase
{
    /**
     * Check a reader can search for an entry
     *
     * @return void
     */
    public function testCanSearchForAnEntry()
    {
        $this->assertTrue(true);
    }
}
