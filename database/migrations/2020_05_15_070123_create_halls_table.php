<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('halls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('professional_id')->unsigned();
            $table->foreign('professional_id')
                  ->references('id')
                  ->on('professionals')
                  ->onDelete('restrict')
                  ->onUpdate('restrict'); 
            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')
                  ->references('id')
                  ->on('address')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');           
            $table->string('name');   
            $table->string('slug');          
            $table->text('description')->nullable(); 
            $table->integer('capacity')->nullable(); 
            $table->string('parking')->nullable(); 
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
        Schema::dropIfExists('halls');
    }
}
