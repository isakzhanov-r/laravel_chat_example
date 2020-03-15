<?php

namespace App\Events\Contacts;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddEvent implements ShouldBroadcast
{
    protected $contact;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(User $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('new_contacts.' . $this->contact->id);
    }

    public function broadcastWith()
    {
        return ['contact' => UserResource::make($this->contact)];
    }
}