<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CronologiaVotazioni extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CronologiaVotazioni', function (Blueprint $table) {
            $table->id();
            $table->date("Data")->default(date("Y-m-d"));      
            $table->unsignedBigInteger('ChiusaDa');
            $table->json("Risultati");


            $table->foreign('ChiusaDa')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CronologiaVotazioni');
    }
}
