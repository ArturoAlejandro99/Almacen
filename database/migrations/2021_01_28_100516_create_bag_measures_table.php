<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBagMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bag_measures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coil_type_id');
            
            $table->float('ancho', 14, 4);
            $table->float('largo', 14, 4);
            //Usuario creo
            //Usuario modifico

            $table->foreign('coil_type_id')
                ->references('id')->on('coil_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');;   

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
        Schema::dropIfExists('bag_measures');
    }
}
