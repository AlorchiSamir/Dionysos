<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->double('price', 8, 2);
            $table->string('type');
            $table->integer('professional_id')->unsigned()->nullable();
            $table->foreign('professional_id')
                  ->references('id')
                  ->on('professionals')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->integer('hall_id')->unsigned()->nullable();
            $table->foreign('hall_id')
                  ->references('id')
                  ->on('halls')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->boolean('active');
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
        Schema::dropIfExists('prices');
    }
}
