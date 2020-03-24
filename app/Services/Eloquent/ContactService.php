<?php


namespace App\Services\Eloquent;


use App\Events\Contacts\AddEvent;
use App\Events\Contacts\ConfirmEvent;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Http\Request;

class ContactService
{
    public function find($id)
    {
        return User::find($id);
    }

    public function getAll(User $user)
    {
        $user
            ->load('contacts');

        return $user->contacts;
    }

    public function addContact(User $user, Request $request): User
    {
        $user_contact = $user->contact()
            ->create($request->validated());
        $contact      = $this->find($user_contact->contact_id);

        broadcast(new AddEvent($user,$contact));

        return $contact;
    }

    public function confirmContact(User $user, Request $request)
    {
        UserContact::query()
            ->where('contact_id', $user->id) // id == 48
            ->where('user_id', $request->contact_id) // id == 16
            ->update(['confirmed' => 1]);

        $user_contact = $user->contact()
            ->create(['contact_id' => $request->contact_id, 'confirmed' => 1]);

        $contact = $this->find($user_contact->contact_id);

        broadcast(new ConfirmEvent($user, $contact));

        return $contact;
    }
}
