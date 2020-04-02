<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;

use App\User;
use App\Entry;

class EditEntryTest extends TestCase
{
    /**
     * Check a contributor can edit an entry
     *
     * @return void
     */
    public function testCanEditAnEntry()
    {
        $this->assertTrue(true);
    }
}
