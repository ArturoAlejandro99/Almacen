<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoilProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coil_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coil_id');
            $table->unsignedBigInteger('coil_product_id');
            $table->string('coil_product_type');
            
            $table->string('nomenclatura', 28)->nullable();
            $table->string('status', 10);
            $table->date('fAdquisicion');
            $table->float('peso', 14,4);

            $table->foreign('coil_id')
                ->references('id')
                ->on('coils')
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
        Schema::dropIfExists('coil_product');
    }
}
