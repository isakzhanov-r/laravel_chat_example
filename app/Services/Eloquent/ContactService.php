<?php


namespace App\Services\Eloquent;


use App\Models\User;

class ContactService
{
    public function getAll(User $user)
    {
        $user
            ->load('contacts');

        return $user->contacts;
    }
}