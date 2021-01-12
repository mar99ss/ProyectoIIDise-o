<?php

namespace Database\Seeders;

use App\Models\Miembro;
use Illuminate\Database\Seeder;

class MiembrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Miembro::factory()->count(50)->create();
        Miembro::factory()->create([
            'nombreCompleto' => 'Kendall Tames Fernández',
            'identificacion' => '305210230'
        ]);
        Miembro::factory()->create([
            'nombreCompleto' => 'Steven Quesada Jimenez',
            'identificacion' => '117260675'
        ]);
        Miembro::factory()->create([
            'nombreCompleto' => 'Marlen Solano Solano'
        ]);
        Miembro::factory()->create([
            'nombreCompleto' => 'Carlos Vega Núñez',
            'identificacion' => '117920740'
        ]);
        Miembro::factory()->create([
            'nombreCompleto' => 'Elras Cabuches'
        ]);
    }
}
