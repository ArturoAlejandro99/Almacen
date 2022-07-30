<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);  //nombre del empleado
            $table->date('fNacimiento'); 
            $table->date('fIngreso'); //fecha de ingreso a la empresa
            $table->integer('antiguedad'); //años de antiguedad
            $table->float('sueldoHora', 14, 4); //sueldo que gana por hora
            $table->string('telefono', 15);
            $table->string('status', 7); //activo o de baja
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
        Schema::dropIfExists('employees');
    }
}
