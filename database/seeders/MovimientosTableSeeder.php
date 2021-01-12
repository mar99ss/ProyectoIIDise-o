<?php

namespace Database\Seeders;

use App\Models\Movimiento;
use App\Models\NivelJerarquico;
use Illuminate\Database\Seeder;

class MovimientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movimiento::create([
            "cedulaJuridica" => "3-TTT-CCCCCC",
            "nombre" => "Movimiento TreeGarden",
            "direccionWeb" => "www.treegarden.org",
            "pais" => "Costa Rica",
            "provincia" => "Cartago",
            "canton" => "Paraíso",
            "distrito" => "Orosi",
            "sennas" => "De la iglesia colonial, 500 metros norte y 50 oeste",
            "logo" => "/img/logoTreeGarden.png",
            "root_id" => NivelJerarquico::first()->componente_id
        ]);
    }
}
