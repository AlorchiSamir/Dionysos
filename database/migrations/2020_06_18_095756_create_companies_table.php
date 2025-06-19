<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
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
            $table->integer('metier_id')->unsigned();
            $table->foreign('metier_id')
                  ->references('id')
                  ->on('metiers')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->string('name');
            $table->string('slug');
            $table->string('tva_number')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
