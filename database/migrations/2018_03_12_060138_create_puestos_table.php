<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puestos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idpuestos',10);
            $table->string('nombrePuesto',50);
            $table->integer('fk_area')->unsigned();
            $table->foreign('fk_area')->references('id')->on('areas');
            $table->integer('fk_subArea');
            $table->integer('fk_user_create');
            $table->integer('fk_user_update');
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
        Schema::dropIfExists('puestos');
    }
}
