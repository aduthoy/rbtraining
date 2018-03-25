<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_trainings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cve_curso',10);
            $table->string('nombre_curso',50);
            $table->string('instructor_curso',50);
            $table->string('tema_curso',255);
            $table->string('area_imparte_curso',50);
            $table->decimal('duracionCurso');
            $table->boolean('estatus_curso');
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
        Schema::dropIfExists('general_trainings');
    }
}
