<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AcceptSubUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $acceptsubuser;
    public $friend_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($acceptsubuser, $friend_id)
    {
        $this->acceptsubuser = $acceptsubuser;
        $this->friend_id = $friend_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('bffchatacceptsubuser.' . $this->friend_id);
    }

    public function broadcastWith()
    {
        return ["acceptsubuser" => $this->acceptsubuser];
    }
}
