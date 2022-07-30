<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoilProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coil_product', function (Blueprint $table) {
            $table->id();
            $table->string('nomenclatura', 28);
            //folio va a ver un folio
            $table->float('peso', 14, 4);
            $table->float('metros', 14, 4);
            $table->text('observaciones')->nullable;
            //quien elaboro
            $table->date('fechaInicioTrabajo');
            $table->date('fechaFinTrabajo')->nullable;
            $table->time('horaInicioTrabajo');
            $table->time('horaFinTrabajo')->nullable;
            //Usuario creo
            //Usuario modifico
            /*tipo*/
            $table->float('temperatura', 14, 4);
            $table->float('velocidad', 14, 4);
            $table->string('status', 15);
            $table->float('pesoUtilizado', 14, 4);//?
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
        Schema::dropIfExists('coil_product');
    }
}
