<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetierSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metier_skills', function (Blueprint $table) {
            $table->increments('id');          
            $table->string('name');
            $table->string('color');
            $table->integer('metier_id')->unsigned();
            $table->foreign('metier_id')
                  ->references('id')
                  ->on('metiers')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');        
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
        Schema::dropIfExists('metier_skills');
    }
}
