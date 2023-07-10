<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReceiveSender implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $sender;
    public $friend_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sender, $friend_id)
    {
        $this->sender = $sender;
        $this->friend_id = $friend_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('bffchatreceivesender.' . $this->friend_id);
    }
    public function broadcastWith()
    {
        return ["sender" => $this->sender];
    }
}
