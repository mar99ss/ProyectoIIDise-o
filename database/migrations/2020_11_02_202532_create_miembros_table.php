<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiembrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miembros', function (Blueprint $table) {
            $table->foreignId("componente_id")->constrained();
            $table->primary("componente_id");
            $table->string("identificacion");
            $table->string("distrito");
            $table->string("canton");
            $table->string("provincia");
            $table->text("sennas");
            $table->string("nombreCompleto");
            $table->string("email");
            $table->string("telefono");
            $table->boolean("enabled")->default(true);
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
        Schema::dropIfExists('miembros');
    }
}
