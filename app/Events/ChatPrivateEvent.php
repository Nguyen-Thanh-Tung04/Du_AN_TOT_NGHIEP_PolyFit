<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
class ChatPrivateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    /**
     * Create a new event instance.
     */
    public $idUserSend;
    public $idUserReciever;
    public $message;
    public function __construct(User $idUserSend,User $idUserReciever,$message)
    {
        $this -> idUserSend = $idUserSend;
        $this -> idUserReciever = $idUserReciever;
        $this -> message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.private.'.$this->idUserSend->id .".".$this->idUserReciever->id),
        ];
    }
}
