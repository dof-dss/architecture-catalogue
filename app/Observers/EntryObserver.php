<?php

namespace App\Observers;

use App\Entry;

class EntryObserver
{
    /**
     * Handle the entry "created" event.
     *
     * @param  \App\Entry  $entry
     * @return void
     */
    public function created(Entry $entry)
    {
        // add to the elasticsearch index
        $entry->addToIndex();

        // audit entry created
        $entry->auditEvent(__FUNCTION__);
    }

    /**
     * Handle the entry "updated" event.
     *
     * @param  \App\Entry  $entry
     * @return void
     */
    public function updated(Entry $entry)
    {
        // update the elasticsearch index
        $entry->updateIndex();

        // audit entry updated
        $entry->auditEvent(__FUNCTION__);
    }

    /**
     * Handle the entry "deleted" event.
     *
     * @param  \App\Entry  $entry
     * @return void
     */
    public function deleted(Entry $entry)
    {
        // delete from the elasticsearch index
        $entry->removeFromIndex();

        // audit entry deleted
        $entry->auditEvent(__FUNCTION__);
    }

    /**
     * Handle the entry "restored" event.
     *
     * @param  \App\Entry  $entry
     * @return void
     */
    public function restored(Entry $entry)
    {
        //
    }

    /**
     * Handle the entry "force deleted" event.
     *
     * @param  \App\Entry  $entry
     * @return void
     */
    public function forceDeleted(Entry $entry)
    {
        //
    }
}
