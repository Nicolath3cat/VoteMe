<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CodiciVoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Codici', function (Blueprint $table) {
            $table->id();
            $table->string('Nome',50);
            $table->string('Cognome',50);
            $table->string('Email',50);
            $table->string('Tipo',7);
            $table->string('Codice',10);
            $table->boolean('Usato')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Codici');
    }
}
