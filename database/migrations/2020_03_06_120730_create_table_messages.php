<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableMessages extends Migration
{
    public function up()
    {
        \Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('from');
            $table->bigInteger('to');
            $table->text('message');
            $table->boolean('is_read');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        \Schema::dropIfExists('messages');
    }
}
