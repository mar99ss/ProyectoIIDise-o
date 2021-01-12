<?php

namespace Database\Seeders;

use App\Models\Componente;
use App\Models\Grupo;
use App\Models\Miembro;
use App\Models\NivelJerarquico;
use App\Models\NivelPadre;
use Illuminate\Database\Seeder;

class ComponentesTableSeeder extends Seeder
{
    private function createNivelJerarquico($nombre, $tipo = null, $params = [])
    {
        $componenteId = Componente::create([])->id;

        $nivel = NivelJerarquico::create([
            "nombre" => $nombre,
            "componente_id" => $componenteId
        ]);

        if ($tipo != null)
            app($tipo)::create($params + ["nivel_jerarquico_id" => $componenteId]);

        return $nivel;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coordinacion = $this->createNivelJerarquico(
            "Coordinación CR",
            NivelPadre::class,
            ["nivel" => 1, "jefe_id" => 1]
        );

        $zona1 = $this->createNivelJerarquico(
            "Zona 1",
            NivelPadre::class,
            ["nivel" => 2, "jefe_id" => 2]
        );
        $coordinacion->hijos()->attach($zona1->componente);

        $zona2 = $this->createNivelJerarquico(
            "Zona 2",
            NivelPadre::class,
            ["nivel" => 2, "jefe_id" => 3]
        );
        $coordinacion->hijos()->attach($zona2->componente);

        $rama1 = $this->createNivelJerarquico(
            "Rama 1",
            NivelPadre::class,
            ["nivel" => 3, "jefe_id" => 4]
        );
        $zona1->hijos()->attach($rama1->componente);

        $rama2 = $this->createNivelJerarquico(
            "Rama 2",
            NivelPadre::class,
            ["nivel" => 3, "jefe_id" => 5]
        );
        $zona1->hijos()->attach($rama2->componente);

        $grupo1 = $this->createNivelJerarquico(
            "Grupo 1",
            Grupo::class,
            ["numero_grupo" => 1]
        );
        $rama1->hijos()->attach($grupo1->componente);

        $grupo2 = $this->createNivelJerarquico(
            "Grupo 2",
            Grupo::class,
            ["numero_grupo" => 2]
        );
        $rama1->hijos()->attach($grupo2->componente);

//        foreach (Miembro::where([['componente_id', '>', 10], ['componente_id', '<', 30]])->get() as $miembro)
//            $zona1->hijos()->attach($miembro->componente);

//        foreach (Miembro::where([['componente_id', '>=', 30], ['componente_id', '<=', 45]])->get() as $miembro)
//            $grupo1->hijos()->attach($miembro->componente);
//
//        foreach (Miembro::where([['componente_id', '>=', 40]])->get() as $miembro)
//            $grupo1->concreto()->jefes()->attach($miembro);

        // Zona 1
        //      - 2 jefes
        //      Rama 1
        //              - 2 jefes
        //              Grupo 1
        //                      - 1 monitor
        //                      - 5 miembros
        //              Grupo 2
        //                      - 2 jefes
        //                      - 3 miembros
        //      Rama 2
        //              - 2 jefes
        // Zona 2

        $coordinacion->hijos()->attach(
            Miembro::where(['componente_id' => 1])->first()->componente()->first()
        );

        $grupo1->concreto()->jefes()->attach(
            Miembro::where(['componente_id' => 51])->first()
        );

        $grupo1->miembros()->attach(Miembro::where('componente_id', '>=', 10)->where('componente_id', '<=', 15)->get()->map(
            function ($e) {
                return $e->componente()->first();
            })
        );

        $grupo2->concreto()->jefes()->attach(
            Miembro::where('componente_id', '=', 16)->orWhere('componente_id', '=', 17)->get()
        );

        $grupo2->miembros()->attach(Miembro::where('componente_id', '>=', 16)->where('componente_id', '<=', 20)->get()->map(
            function ($e) {
                return $e->componente()->first();
            })
        );

        $rama1->miembros()->attach(
            Miembro::where(['componente_id' => 52])->first()->componente()->first()
        );

        $rama1->miembros()->attach(
            Miembro::where(['componente_id' => 53])->first()->componente()->first()
        );

        $zona1->miembros()->attach(
            Miembro::where(['componente_id' => 54])->first()->componente()->first()
        );

        $zona1->miembros()->attach(
            Miembro::where(['componente_id' => 55])->first()->componente()->first()
        );
    }
}
