<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteBagsTable extends Migration
{
    /**
     * Merma de bolsas
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_bags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bag_mesure_id')->nullable(); //llave foranea del catalogo de la medida de la bolsa
            $table->date('fechaInicioTrabajo');  //fecha de inicio en la que se trabajo la merma
            $table->date('fechaFinTrabajo');//fecha de fin en la que se trabajo la merma
            $table->time('horaIncioTrabajo')->nullable();
            $table->time('horaFinTrabajo')->nullable();
            $table->float('peso', 14, 4); //peso de la merma
            $table->float('largo', 14, 4); //cantidad en metros
            $table->float('temperatura', 14, 4)->nullable(); //temperatura de la maquina
            $table->float('velocidad', 14, 4)->nullable();  //velocidad de la maquina
            $table->string('observaciones')->nullable();
            $table->string('status', 15); //disponible o terminada
            $table->float('cantidad', 14, 4); //cantidad de mermas generadas
            $table->string('tipoUnidad', 10); //millares o cientos
            $table->string('nomenclatura', 28);
            $table->float('costo', 14, 4)->nullable();

    
            $table->foreign('bag_mesure_id')
                ->references('id')
                ->on('bag_measures');

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
        Schema::dropIfExists('waste_bags');
    }
}
