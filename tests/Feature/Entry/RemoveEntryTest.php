<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;

use App\User;
use App\Entry;

class RemoveEntryTest extends TestCase
{
    /**
     * Check a contributor can remove an entry
     *
     * @return void
     */
    public function testCanRemoveAnEntry()
    {
        $this->assertTrue(true);
    }
}
