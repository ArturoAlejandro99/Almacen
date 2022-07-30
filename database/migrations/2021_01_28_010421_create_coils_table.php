<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coils', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('coil_type_id')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();

            $table->string('nomenclatura', 28);
            $table->string('status', 10);
            $table->date('fArribo');
            $table->float('pesoBruto',14 ,4);
            $table->float('pesoNeto',14 ,4)->nullable();
            $table->text('observaciones')->nullable();
            $table->float('diametroBobina',14 ,4)->nullable();
            $table->float('diametroInterno',14 ,4)->nullable();
            $table->float('diametroExterno',14 ,4)->nullable();
            $table->float('largoM',14 ,4);
            $table->float('pesoUtilizado',14 ,4)->nullable();
            $table->float('costo',14 ,4);
            $table->float('metrosUtilizados', 14,4)->nullable();

            $table->foreign('coil_type_id')
                ->references('id')->on('coil_types')
                ->onDelete('set null');
                
            $table->foreign('provider_id')
                ->references('id')->on('providers')
                ->onDelete('set null');
           
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
        Schema::dropIfExists('coils');
    }
}
