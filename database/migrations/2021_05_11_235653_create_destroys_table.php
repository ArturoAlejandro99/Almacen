<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestroysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destroys', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->string('nomenclatura', 29)->nullable();
            $table->date('fArribo')->nullable();
            $table->float('peso' ,14 , 4)->nullable();
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destroys');
    }
}
