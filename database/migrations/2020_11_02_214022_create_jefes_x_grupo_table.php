<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJefesXGrupoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jefes_x_grupo', function (Blueprint $table) {
            $table->id();
            $table->foreignId("miembro_id")->constrained("miembros", "componente_id");
            $table->foreignId("grupo_id")->constrained("grupos", "nivel_jerarquico_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jefes_x_grupo');
    }
}
