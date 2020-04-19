<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
// used to generate GUID
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

use App\User;
use App\Services\Audit as AuditLogger;

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
     * Determine if auditing is enabled.
     *
     * @return void
     */
    protected function auditEnabled()
    {
        return config('eaaudit.enabled') == true;
    }

    /**
     * Determine if auditing is disabled.
     *
     * @return void
     */
    protected function auditDisabled()
    {
        return config('eaaudit.enabled') == false;
    }

    /**
     * Set up model listeners for each event
     *
     * @return void
     */
    public static function bootAuditsActivity()
    {
        static::eventsToBeRecorded()->each(function ($eventName) {
            return static::$eventName(function (Model $model) use ($eventName) {
                $model->auditEvent($eventName);
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
     * Audit changes in a model.
     *
     * @param string $event
     * @return void
     */
    public function auditEvent($event)
    {
        if ($this->auditDisabled()) {
            return;
        }

        // check if this event should be audited [tbd]

        // determine who has triggered the event (check for anonymous user i.e. not logged in)
        if (Auth::check()) {
            $causer_id = Auth::user()->id;
            $causer_type = User::class;
        } else {
            $causer_id = 0;
            $causer_type = 'anonymous';
        }

        // audit the event on this model
        $audit = new AuditLogger();
        $audit->recordEvent(
            $event,
            $this->id,
            get_class($this),
            $causer_id,
            $causer_type,
            $this->getAuditPayload($event)
        );
    }

    /**
     * Get old and original values following a change in a model.
     *
     * @param string $event
     * @return string
     */
    private function getAuditPayload($event)
    {
        $payload = "{";
        if ($event == 'updated') {
            $payload = $payload . '"old": ' . $this->getOriginalValues() . ', ';
        }
        $payload = $payload . '"attributes": ' . $this->getNewValues();
        $payload = $payload . "}";
        return $payload;
    }


    /**
     * Get original attribute values before an update.
     *
     * @param string $event
     * @return string
     */
    private function getOriginalValues()
    {
        $attributes = $this->getOriginal();
        // use the $hidden array to identitify which attributes to remove
        if ($this->hidden) {
            foreach ($attributes as $attribute => $value) {
                if (in_array($attribute, $this->hidden)) {
                    // remove from this attribute from the array
                    unset($attributes[$attribute]);
                }
            }
        }
        // this does not give exaclty the same results as ->toJson
        return json_encode($attributes);
    }

    /**
     * Get new attribute values afer an update or create.
     *
     * @return string
     */
    private function getNewValues()
    {
        return $this->toJson();
    }

    /**
     * Get the set of attributes to be logged.
     *
     * @return array
     */
    private function getLoggedAttributes()
    {
        //
    }

    /**
     * Generate a UUID.
     *
     * @return string
     */
    public function getUuid()
    {
        return str::uuid()->toString();
    }
}
