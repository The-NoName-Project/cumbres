<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('personone');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('persontwo');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsigjnedBigInteger('sport');
            $table->foreign('sport_id')->references('id')->on('sports');
            $table->unsignedBigInteger('visor');
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('scoreone');
            $table->bigInteger('scoretwo');
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
        Schema::dropIfExists('activities');
    }
}
