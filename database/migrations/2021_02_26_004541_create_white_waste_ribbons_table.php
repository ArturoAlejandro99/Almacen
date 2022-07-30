<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhiteWasteRibbonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('white_waste_ribbons', function (Blueprint $table) {
            $table->id(); //llave foranea del catalogo de la medida de la bolsa
            $table->date('fAlta');  //fecha de inicio en la que se trabajo la merma
            $table->float('peso', 14, 4); //peso de la merma
            $table->float('largo', 14, 4); //cantidad en metros
            $table->string('observaciones')->nullable();
            $table->string('status', 15); //disponible o terminada
            $table->string('nomenclatura', 28);
            $table->float('costo', 14, 4);

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
        Schema::dropIfExists('white_waste_ribbons');
    }
}
