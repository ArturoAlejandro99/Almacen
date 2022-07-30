<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');

            $table->string('correoElectronico', 76);
            $table->string('telefono', 20);
            $table->string('nombre', 40);
            $table->string('apellidos', 40);
            //UsuarioCreo
            //UsuarioModifico
            $table->timestamps();

            $table->foreign('provider_id')
                ->references('id')->on('providers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
