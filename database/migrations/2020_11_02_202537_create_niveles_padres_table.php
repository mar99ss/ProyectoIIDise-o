<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNivelesPadresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveles_padre', function (Blueprint $table) {
            $table->foreignId("nivel_jerarquico_id")->constrained("niveles_jerarquicos", "componente_id");
            $table->primary("nivel_jerarquico_id");

            $table->foreignId("jefe_id")->constrained("miembros", "componente_id");
            $table->bigInteger("nivel");
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
        Schema::dropIfExists('nivel_padres');
    }
}
