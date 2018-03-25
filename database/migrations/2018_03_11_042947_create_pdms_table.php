<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cveActualpdm');
            $table->string('cveAnteriorPmd')->nullable();
            $table->string('tituloPdm');
            $table->integer('fk_statusPmd')->nullable();
            $table->date('fechaEfectivaPdm');
            $table->string('duenoDocPdm');
            $table->string('nombreProcesoPdm')->nullable();
            $table->integer('fk_areaPdm');
            $table->integer('fk_estatusPdm');
            $table->boolean('activo');
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
        Schema::dropIfExists('pdms');
    }
}
