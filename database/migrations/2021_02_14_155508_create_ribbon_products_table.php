<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRibbonProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ribbon_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ribbon_id');
            $table->unsignedBigInteger('ribbon_product_id');
            $table->string('ribbon_product_type');
            
            $table->string('nomenclatura', 28);
            $table->float('peso',14,4);
            $table->string('medidaBolsa', 25)->nullable();
            $table->float('cantidad', 14,4)->nullable();
            $table->string('unidad', 15)->nullable();
            
            $table->string('status', 10);
            $table->date('fAdquisicion');

            $table->foreign('ribbon_id')
                ->references('id')
                ->on('ribbons')
                ->onDelete('cascade');


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
        Schema::dropIfExists('ribbon_products');
    }
}
