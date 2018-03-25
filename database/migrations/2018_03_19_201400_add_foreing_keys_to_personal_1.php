<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeingKeysToPersonal1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personals', function (Blueprint $table) {
            $table->integer('general_training_id')->unsigned();
            $table->foreign('general_training_id')->references('id')->on('general_trainings');
            $table->integer('specific_training_id')->unsigned();
            $table->foreign('specific_training_id')->references('id')->on('specific_trainings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personals', function (Blueprint $table) {
            //
        });
    }
}
