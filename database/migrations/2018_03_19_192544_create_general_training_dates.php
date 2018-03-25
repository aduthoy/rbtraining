<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralTrainingDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_training_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pesonal_id');
            $table->integer('general_training_id');
            $table->integer('user_create_id');
            $table->integer('user_update_id');
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
        Schema::dropIfExists('general_training_dates');
    }
}
