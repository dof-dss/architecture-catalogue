<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $actor_id;    // id of the entity
    public $actor;      // entity causing the model to be changed
    public $model;      // name of model being changed
    public $before;     // model before changes
    public $after;      // model after changes
    public $eventName;  // type of event
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($actor_id, $actor, $model, $before, $after, $eventName)
    {
        $this->actor_id = $actor_id;
        $this->actor = $actor;
        $this->model = $model;
        $this->before = $before;
        $this->after = $after;
        $this->eventName = $eventName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
