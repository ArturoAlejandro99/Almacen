<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhiteRibbonProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('white_ribbon_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('white_ribbon_id');
            $table->unsignedBigInteger('white_ribbon_product_id');
            $table->string('white_ribbon_product_type');
            
            $table->string('nomenclatura', 28);
            $table->float('peso',14,4);
            $table->float('largo', 14, 4);
            
            $table->string('status', 15);
            $table->date('fAdquisicion');

            $table->foreign('white_ribbon_id')
                ->references('id')
                ->on('white_ribbons')
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
        Schema::dropIfExists('white_ribbon_products');
    }
}
