<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhiteWastesTable extends Migration
{
    /**
     * Merma de cinta blanca de bobina
     *
     * @return void
     */
    public function up()
    {
        Schema::create('white_wastes', function (Blueprint $table) {
            $table->id();
            $table->float('peso', 14, 4); //peso de la cinta
            $table->float('largo', 14, 4); //largo que mide el rollo en metros
            $table->string('nomenclatura', 28);
            $table->string('status', 9);
            $table->string('observaciones')->nullable();
            $table->date('fAlta');
            $table->float('costo', 14, 4)->nullable(); //Fecha en la que llego
        
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
        Schema::dropIfExists('white_wastes');
    }
}
