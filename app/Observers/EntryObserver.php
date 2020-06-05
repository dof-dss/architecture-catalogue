<?php

namespace App\Observers;

use App\Entry;

class EntryObserver
{

    /**
     * Handle the entry "creating" event.
     *
     * @param  \App\Entry  $entry
     * @return void
     */
    public function creating(Entry $entry)
    {
        $entry->href = $this->injectScheme($entry->href);
    }

    /**
     * Handle the entry "updating" event.
     *
     * @param  \App\Entry  $entry
     * @return void
     */
    public function updating(Entry $entry)
    {
        $entry->href = $this->injectScheme($entry->href);
    }


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

    /**
     * Add in a default scheme automatically if it is missing
     *
     * @param  string  $url
     * @return string
     */
    protected function injectScheme($url)
    {
        if ($ret = parse_url($url)) {
            if (!isset($ret["scheme"])) {
                $url = "http://{$url}";
            }
        }
        return $url;
    }
}
