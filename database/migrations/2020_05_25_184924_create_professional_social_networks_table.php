<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionalSocialNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_social_networks', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('network');
            $table->integer('order');
            $table->integer('professional_id')->unsigned();
            $table->foreign('professional_id')
                  ->references('id')
                  ->on('professionals')
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
        Schema::dropIfExists('professional_social_networks');
    }
}
