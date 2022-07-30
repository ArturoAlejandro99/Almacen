<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhiteRibbonsTable extends Migration
{
    /**
     * Cintilla
     *
     * @return void
     */
    public function up()
    {
        Schema::create('white_ribbons', function(Blueprint $table){
            $table->id();

            //idBobina con CintillaRollo???

            $table->float('peso', 14, 4);
            $table->float('pesoUtilizado', 14, 4);
            $table->string('status', 10);
            $table->float('largo', 14, 4);
            $table->string('nomenclatura', 28);
            $table->date('fArribo');
            $table->string('observaciones')->nullable();
            $table->float('pesoNeto', 14, 4)->nullable();
            $table->float('kiloMetro',14,4)->nullable();
            $table->float('costo')->nullable();

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
        Schema::dropIfExists('white_ribbons');
    }
}
