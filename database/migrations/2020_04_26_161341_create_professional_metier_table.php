<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalMetierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_metier', function (Blueprint $table) {
            $table->integer('professional_id')->unsigned();
            $table->integer('metier_id')->unsigned();
            $table->foreign('professional_id')->references('id')
                        ->on('professionals')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');

            $table->foreign('metier_id')->references('id')
                        ->on('metiers')
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
        Schema::dropIfExists('professional_metier');
    }
}
