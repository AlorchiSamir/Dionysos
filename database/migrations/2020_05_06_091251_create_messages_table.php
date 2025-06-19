<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id')->unsigned()->nullable();
            $table->foreign('sender_id')->references('id')
                        ->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
            $table->integer('recipient_id')->unsigned()->nullable();
            $table->foreign('recipient_id')->references('id')
                        ->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
            $table->integer('message_id')->unsigned()->nullable();
            $table->foreign('message_id')->references('id')
                        ->on('messages')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
            $table->string('email');
            $table->string('title');
            $table->text('content');
            $table->dateTime('send_time');
            $table->dateTime('response_time')->nullable();
            $table->dateTime('view_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
