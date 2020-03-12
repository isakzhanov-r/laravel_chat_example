<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableUserContacts extends Migration
{
    public function up()
    {
        \Schema::create('user_contacts', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('contact_id')->unsigned()->index();
            $table->boolean('confirmed')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        \Schema::dropIfExists('user_contacts');
    }
}
