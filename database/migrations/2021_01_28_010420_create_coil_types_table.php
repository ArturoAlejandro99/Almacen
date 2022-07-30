<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoilTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coil_types', function(Blueprint $table){
            $table->id();
            $table->string('alias', 25);
            $table->float('anchoCm', 8, 4);
            $table->float('largoM', 8, 4);
            $table->float('densidad', 8,4);
            $table->string('material', 15);
            $table->float('calibre', 8,4);
            $table->string('tipo', 10);
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('coil_types');
    }
}
