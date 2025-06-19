<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professionals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('restrict'); 
            $table->integer('address_id')->unsigned()->nullable();
            $table->foreign('address_id')
                  ->references('id')
                  ->on('address')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');           
            $table->string('surname');
            $table->string('slug');
            $table->string('email');  
            $table->string('tel');
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->integer('status');            
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
        Schema::dropIfExists('professionals');
    }
}
