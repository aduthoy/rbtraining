<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idEmpleado')->unique();
            $table->string('nombreEmpleado');
            $table->string('apellidoPaterno');
            $table->string('apellidoMaterno');
            $table->boolean('activo');
            $table->integer('fk_Area');
            $table->integer('fk_Puesto')->default(0);
            $table->integer('user_create');
            $table->integer('user_update');
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
        Schema::dropIfExists('personals');
    }
}
