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
            $table->unsignedBigInteger('peopleone');
            $table->foreign('peopleone')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('peopletwo');
            $table->foreign('peopletwo')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('sport');
            $table->foreign('sport')->references('id')->on('sports')->onDelete('cascade');
            $table->unsignedBigInteger('visor');
            $table->foreign('visor')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('scoreone');
            $table->bigInteger('scoretwo');
            //fecha y hora del partido
            $table->text('date');
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
