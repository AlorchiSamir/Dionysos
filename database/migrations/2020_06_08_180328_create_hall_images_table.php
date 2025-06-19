<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hall_images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->integer('order');
            $table->integer('hall_id')->unsigned();
            $table->foreign('hall_id')
                  ->references('id')
                  ->on('halls')
                  ->onDelete('restrict')
                  ->onUpdate('restrict'); 
            $table->boolean('active');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hall_images');
    }
}
