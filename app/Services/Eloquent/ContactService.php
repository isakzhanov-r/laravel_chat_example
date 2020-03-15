<?php


namespace App\Services\Eloquent;


use App\Events\Contacts\AddEvent;
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

        broadcast(new AddEvent($contact));

        return $contact;
    }
}