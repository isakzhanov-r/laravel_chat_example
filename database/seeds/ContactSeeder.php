<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserContact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $users->each(function ($user) use ($users) {
            $random = $users->random(rand(3, 10))->pluck('id');
            foreach ($random as $id) {
                $user->contact()->create(['contact_id' => $id, 'confirmed' => 1]);
            }
        });
    }
}
