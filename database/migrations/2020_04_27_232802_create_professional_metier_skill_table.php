<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalMetierSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_metier_skill', function (Blueprint $table) {
            $table->integer('professional_id')->unsigned();
            $table->integer('skill_id')->unsigned();
            $table->foreign('professional_id')->references('id')
                        ->on('professional')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');

            $table->foreign('skill_id')->references('id')
                        ->on('metiers_skills')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professional_metier_skill');
    }
}
