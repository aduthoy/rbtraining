<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeingKeysToPersonal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personals', function (Blueprint $table) {
            $table->integer('fk_area')->unsigned()->change();
            $table->foreign('fk_area')->references('id')->on('areas');
            $table->integer('fk_puesto')->nullable()->unsigned()->change();
            $table->foreign('fk_puesto')->references('id')->on('puestos');

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
