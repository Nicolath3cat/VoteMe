<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Settings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Settings', function (Blueprint $table) {
            $table->id();
            $table->string('Nome',100);
            $table->string('Valore',100);
            $table->string('Descrizione',100);
            $table->UnsignedBigInteger('ModificatoDa')->default(0);

            $table->foreign('ModificatoDa')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::dropIfExists('Settings');
    }
}
