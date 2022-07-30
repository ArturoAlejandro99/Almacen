<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRibbonsTable extends Migration
{
    /**
     * Tabla de rollos
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ribbons', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('coil_product_id'); //llave fonarea de producto bobina
            //$table->unsignedBigInteger('white_ribbon_id'); //llave foranea de cintilla blanca
            $table->string('nomenclatura', 28); //identificador
            $table->float('peso', 14, 4); //peso del rollo
            $table->float('pesoNeto', 14, 4)->nullable();
            $table->float('largo', 14, 4); //metros de largo del rollo
            $table->text('observaciones')->nullable();
            $table->date('fechaInicioTrabajo'); //fecha en que se inicio a crear el rollo
            $table->date('fechaFinTrabajo'); //fecha en la que termino de crear el rollo
            $table->time('horaInicioTrabajo'); 
            $table->time('horaFinTrabajo');
            //Usuario creo
            //Usuario modifico
            /*tipo*/
            $table->float('temperatura', 14, 4)->nullable(); //temperatura de la maquina
            $table->float('velocidad', 14, 4)->nullable(); //velocidad de la maquina
            $table->string('status', 10); //disponible o terminado
            $table->float('pesoUtilizado', 14, 4);//peso que se ha comprado en bolsas relacionadas
            $table->float('pesoCinta', 14, 4)->nullable(); //peso de la cinta blanca
            $table->float('pesoCelofan', 14, 4)->nullable();
            $table->float('costoCelofan', 14, 4)->nullable();
            $table->float('costoCinta', 14, 4)->nullable();
            $table->float('costoTotal', 14,4)->nullable();
           // $table->foreign('coil_product_id')
           //     ->references('id')
           //     ->on('coils_products');
            
          /*  $table->foreign('white_ribbon_id')
                ->references('id')
                ->on('white_ribbons');*/   

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
        Schema::dropIfExists('ribbons');
    }
}
