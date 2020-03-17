<?php

namespace App\Events\Messages;

use App\Http\Resources\Messages\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendEvent implements ShouldBroadcast
{
    protected $message;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(Message $message)
    {
        $this->message = $message
            ->load('user');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('new_messages.' . $this->message->to);
    }

    public function broadcastWith()
    {
        return ['message' => MessageResource::make($this->message)];
    }
}
