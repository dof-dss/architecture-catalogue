<?php

namespace App\Listeners;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\ModelChanged;
use App\Services\Audit as AuditLogger;

class AuditModelChanges implements ShouldQueue
{
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
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ModelChanged  $event
     * @return void
     */
    public function handle(ModelChanged $event)
    {
        if ($this->auditDisabled()) {
            return;
        }

        // audit the event on this model
        $audit = new AuditLogger();

        $audit->recordEvent(
            $event->eventName,
            $event->after['id'],
            $event->model,
            $event->actor_id,
            $event->actor,
            $this->getAuditPayload($event->eventName, $event->before, $event->after)
        );
    }

    /**
     * Get old and original values following a change in a model.
     *
     * @param string $event
     * @param array $before
     * @param array $after
     * @return string
     */
    private function getAuditPayload($event, $before, $after)
    {
        $payload = "{";
        if ($event == "updated") {
            $payload .= '"old":' . json_encode($before). ',';
        }
        $payload .= '"attributes": ' . json_encode($after);
        $payload .=  "}";
        return $payload;
    }
}
