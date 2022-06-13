<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Presenze extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Presenze', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nome');
            $table->string('Cognome');
            $table->string('Email');
            $table->time('Entrata');
            $table->time('Uscita')->nullable();
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
        Schema::dropIfExists('Presenze');
    }
}
