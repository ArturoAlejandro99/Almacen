<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhiteCoilProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('white_coil_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('white_coil_id');
            $table->unsignedBigInteger('white_coil_product_id');
            $table->string('white_coil_product_type');
            
            $table->string('nomenclatura', 28)->nullable();
            $table->string('status', 10);
            $table->date('fAdquisicion');
            $table->float('peso', 14,4);

            $table->foreign('white_coil_id')
                ->references('id')
                ->on('white_coils')
                ->onDelete('cascade')
                ->onUpdate('cascade');


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
        Schema::dropIfExists('white_coil_products');
    }
}
