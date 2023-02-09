<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AcceptUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $acceptuser;
    public $user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($acceptuser, $user_id)
    {
        $this->acceptuser = $acceptuser;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('bffchatacceptuser.' . $this->user_id);
    }

    public function broadcastWith()
    {
        return ["acceptuser" => $this->acceptuser];
    }
}
