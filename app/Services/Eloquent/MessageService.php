<?php


namespace App\Services\Eloquent;


use App\Events\Messages\SendEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MessageService
{
    protected $contact;

    public function setContact(int $contact)
    {
        $this->contact = User::findOrFail($contact);

        return $this;
    }

    public function getMessages()
    {
        $this->read();
        $ids = [auth()->id(), $this->contact->id];

        return Message::query()
            ->whereIn('from', $ids)
            ->whereIn('to', $ids)
            ->latest('created_at')
            ->get();
    }

    public function getUnreadMessages()
    {
        return Message::query()
            ->where('to', auth()->id())
            ->where('is_read', 0)
            ->get();
    }

    public function send(Request $request)
    {
        $data    = array_merge(
            ['to' => $this->contact->id, 'is_read' => 0],
            $request->validated());
        $message = \Auth::user()
            ->messages()
            ->create($data);

        broadcast(new SendEvent($message));

        return $message;
    }

    public function read()
    {
        return Message::query()
            ->where(['from' => $this->contact->id, 'to' => auth()->id(), 'is_read' => 0])
            ->update(['is_read' => 1]);
    }
}
