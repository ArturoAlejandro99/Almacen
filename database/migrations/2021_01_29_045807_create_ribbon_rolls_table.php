<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRibbonRollsTable extends Migration
{
    /**
     * Tabla Cintilla rollo
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ribbon_rolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('white_ribbon_id'); // id de la cinta blanca
            $table->unsignedBigInteger('coil_product_id')->nullable(); // id del producto bobina
            $table->float('peso', 14, 4); //peso que se uso en el rollo de celofan
            $table->float('largo', 14, 4); //largo en metros del rollo de celofan

            $table->foreign('white_ribbon_id')
                ->references('id')
                ->on('white_ribbons');
            
            $table->foreign('coil_product_id')
                ->references('id')
                ->on('coil_products');    

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
        Schema::dropIfExists('ribbon_rolls');
    }
}
