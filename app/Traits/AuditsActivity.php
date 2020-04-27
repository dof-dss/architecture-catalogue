<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

use App\User;

use App\Events\ModelChanged;

use Illuminate\Support\Facades\Log;

trait AuditsActivity
{
    /**
    *--------------------------------------------------------------------------
    * AuditsActivity trait
    *--------------------------------------------------------------------------
    *
    * This trait is used to facilitate model auditing using
    * the NICS EA Audit Service. It does not support soft deletes.
    *
    * @package    architecture-cataloge
    * @author     Stephen Patterson <stephen.patterson@finance-ni.gov.uk>
    */

    /**
     * Set up model listeners for each event
     *
     * @return void
     */
    public static function bootAuditsActivity()
    {
        static::eventsToBeRecorded()->each(function ($eventName) {
            return static::$eventName(function (Model $model) use ($eventName) {
                // determine who has triggered the event (check for anonymous user i.e. not logged in)
                if (Auth::check()) {
                    $actor_id = Auth::user()->id;
                    $actor = User::class;
                } else {
                    $actor_id = 0;
                    $actor = 'anonymous';
                }
                // check if this event should be audited [tbd]

                // need to serialise the model
                $before = static::removeHiddenAttributes($model->getOriginal());
                $after = static::removeHiddenAttributes($model->getAttributes());
                event(new ModelChanged(
                    $actor_id,
                    $actor,
                    static::class,
                    $before,
                    $after,
                    $eventName
                ));
            });
        });
    }

    /**
     * Determine events to be audited.
     *
     * @return Collection $events
     */
    protected static function eventsToBeRecorded(): Collection
    {
        if (isset(static::$recordEvents)) {
            return collect(static::$recordEvents);
        }

        $events = collect([
            'created',
            'updated',
            'deleted',
        ]);

        return $events;
    }

    /**
     * Remove hidden attributes.
     *
     * @param array $attributes
     * @return array
     */
    protected static function removeHiddenAttributes($attributes): array
    {
        if (isset(static::$hiddenFromAudit)) {
            $attributes = array_diff_key($attributes, array_flip(static::$hiddenFromAudit));
        }
        return $attributes;
    }
}
