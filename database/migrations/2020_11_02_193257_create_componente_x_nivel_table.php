<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponenteXNivelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('componente_x_nivel', function (Blueprint $table) {
            $table->id();
            $table->foreignId("componente_id")->constrained();
            $table->foreignId("nivel_jerarquico_id")->constrained("niveles_jerarquicos", "componente_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('componente_x_nivel');
    }
}
