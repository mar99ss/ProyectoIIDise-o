<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->string("cedulaJuridica");
            $table->string("nombre");
            $table->string("direccionWeb");
            $table->string("pais");
            $table->string("provincia");
            $table->string("canton");
            $table->string("distrito");
            $table->string("sennas");
            $table->string("logo");

            $table->unsignedBigInteger("root_id")->nullable();
            $table->foreign("root_id")->references("componente_id")->on("niveles_jerarquicos");
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
        Schema::dropIfExists('movimientos');
    }
}
