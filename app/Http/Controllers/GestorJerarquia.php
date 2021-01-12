<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\Grupo;
use App\Models\Miembro;
use App\Models\Movimiento;
use App\Models\NivelJerarquico;
use App\Models\NivelPadre;

class GestorJerarquia
{
    // Sí sirve pero al final no lo ocupamos jaja
//    public function obtenerMovimiento(NivelJerarquico $nivelJerarquico) {
//        while ($nivelJerarquico->padre()->exists())
//            $nivelJerarquico = $nivelJerarquico->padre()->first();
//
//        return Movimiento::where(['root_id', '=', $nivelJerarquico->componente_id])->first();
//    }

    public function validarNombreGrupoUnico(NivelJerarquico $padre, $nombre)
    {
        if ($padre->nombre == $nombre)
            return false;
        foreach ($padre->niveles()->get() as $hijo)
            if (!$this->validarNombreGrupoUnico($hijo->nivelJerarquico()->first(), $nombre))
                return false;

        return true;
    }

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

    public function crearNivelPadre(NivelJerarquico $nivelJerarquico, $nombre)
    {
        $nivel = $nivelJerarquico->concreto()->nivel + 1;
        $nuevoNivel = $this->createNivelJerarquico($nombre, NivelPadre::class, ['nivel' => $nivel, 'jefe_id' => 1]);
        $nivelJerarquico->hijos()->attach($nuevoNivel->componente);
    }

    public function borrar(NivelJerarquico $nivelJerarquico)
    {
        $nivelJerarquico->hijos()->detach($nivelJerarquico->hijos()->get());

        $concreto = $nivelJerarquico->concreto();

        if ($concreto instanceof Grupo) {
            $concreto->jefes()->detach($concreto->jefes()->get());
        }


        foreach ($nivelJerarquico->niveles()->get() as $hijo) {
            $this->borrar($hijo->nivelJerarquico()->first());
        }

        $concreto->delete();
        $nivelJerarquico->delete();
    }

    public function crearNombre()
    {
        $phonetics = array("Alfa", "Bravo", "Charlie", "Delta", "Echo", "Foxtrot", "Golf", "Hotel", "India", "Juliett", "Kilo", "Lima", "Mike", "November", "Oscar", "Papa", "Quebec", "Romeo", "Sierra", "Tango", "Uniform", "Victor", "Whisky", "X-ray", "Yankee", "Zulu");

        $randNum = rand(0, 26);

        $randNumGrupo = rand(0, 100);

        $randName = $phonetics[$randNum] . " " . $randNumGrupo;

        return $randName;
    }

    public function crearGrupo($datos)
    {
        $nivelJerarquico = NivelJerarquico::where(['componente_id' => $datos["nivelJerarquico"]])->first();

        if (isset($datos["nombre"])) {
            $nuevoNivel = $this->createNivelJerarquico($datos["nombre"], Grupo::class, ["numero_grupo" => $datos["numero"]]);

        } else {
            $raiz = session('movimiento')->raiz();

            do
                $nuevoNombre = $this->crearNombre();
            while (!$this->validarNombreGrupoUnico($raiz, $nuevoNombre));
            $nuevoNivel = $this->createNivelJerarquico($nuevoNombre, Grupo::class, ["numero_grupo" => $datos["numero"]]);
        }

        $monitor1 = Miembro::where(['identificacion' => $datos["monitor1"]])->first();
        $nuevoNivel->concreto()->jefes()->attach($monitor1);

        if (isset($datos["monitor2"])) {
            $monitor2 = Miembro::where(['identificacion' => $datos["monitor2"]])->first();
            $nuevoNivel->concreto()->jefes()->attach($monitor2);
        }

        $nivelJerarquico->hijos()->attach($nuevoNivel->componente()->first());
    }

    private function crearTelefonos($arrayTelefonos)
    {
        return array_map(function ($telefono) {
            return ['numero' => $telefono];
        }, $arrayTelefonos);
    }

    public function inicializarMovimiento($movimiento, $datos)
    {
        $coordinacion = $this->createNivelJerarquico(
            $datos['nombreCoordinacion'],
            NivelPadre::class,
            ["nivel" => 1, "jefe_id" => 1]
        );

        $movimiento->root_id = $coordinacion->componente_id;
        $movimiento->telefonos()->createMany($this->crearTelefonos($datos['telefonos']));

        $movimiento->save();
    }

    public function obtenerMiembrosNoAsignados($rolesAsignados)
    {
        $asignados = [];

        foreach ($rolesAsignados as $rol)
            foreach ($rol as $miembro)
                $asignados[] = $miembro->componente_id;

        return Miembro::whereNotIn('componente_id', $asignados);
    }

    private function query($filtro, $valor) {
        if ($filtro === "nombreCompleto")
            return Miembro::where($filtro, "like", "%" . $valor . "%");
        else return Miembro::where(["identificacion" => $valor]);
    }

    private function aplicarFiltroAMiembros($miembros, $filtro, $valor) {
        if (trim($filtro ?? '') != '' && trim($valor ?? '') != '')
        {
            $miembrosResult = [];

            foreach ($miembros as $rol => $submiembros)
                $miembrosResult[$rol] = $this->query($filtro, $valor)->whereIn('componente_id', $submiembros->pluck('componente_id'))->get();

            return $miembrosResult;
        }
        return [];
    }

    public function obtenerMiembros($nivelId, $incluirNoAsignados = true, $filtro = null, $valor = null)
    {
        $nivelJerarquico = NivelJerarquico::where(['componente_id' => $nivelId])->first();
        $miembros = [];
        $concreto = $nivelJerarquico->concreto();

        if ($nivelJerarquico->concreto() instanceof Grupo) {

            $miembros["miembro"] =
                    $nivelJerarquico->miembros()
                    ->whereNotIn('componente_id', $concreto->jefes()->pluck('componente_id'))

                ->get()
                ->map(function ($miembro) {
                    return $miembro->concreto();
                });

            $miembros["monitor"] =
                $concreto->jefes()->whereNotIn('componente_id', $nivelJerarquico->miembros()->pluck('componente_id'))->get();

            $miembros["jefe"] =
                $concreto->jefes()->whereIn('componente_id', $nivelJerarquico->miembros()->pluck('componente_id'))->get();

        } else {
            // Es un nivel padre

            // Un jefe es un miembro normal de su nivel jerarquico
            // Los miembros son los JEFES de todos los niveles hijos del nivel jerarquico
            // (hay que ver si, de los grupos, solamente los monitores son miembros de las ramas. En este caso, para cada nivel
            // jerárquico hijo, hay que preguntar si es un NivelPadre o un Grupo, y si es Grupo, mostrar solamente los monitores y no los jefes)

            $miembros["jefe"] =
                    $nivelJerarquico->miembros()
                    ->get()
                    ->map(function ($miembro) {
                        return $miembro->concreto();
                    });

            $miembros["miembro"] = collect([]);

            foreach ($nivelJerarquico->niveles()->get() as $subNivel) {
                $subArray = $this->obtenerMiembros($subNivel['id'], false, $filtro, $valor);
                $monitores = $subArray["monitor"] ?? collect([]);
                $jefes = $subArray["jefe"] ?? collect([]);
                $jefes = $jefes->merge($monitores);
                $miembros["miembro"] = $miembros["miembro"]->concat($jefes);
            }

        }
        if ($incluirNoAsignados) {
            $noAsignados = $this->obtenerMiembrosNoAsignados($miembros)->get();
            $miembros["ninguno"] = $noAsignados;
        }

        $miembros = $this->aplicarFiltroAMiembros($miembros, $filtro, $valor);
        return $miembros;
    }

    private function obtenerRol(Miembro $miembro, NivelJerarquico $nivelJerarquico)
    {
        $concreto = $nivelJerarquico->concreto();
        if ($concreto instanceof Grupo) {
            $esMiembro = $nivelJerarquico->miembros()->where('id', '=', $miembro->componente_id)->exists();
            $esJefe = $concreto->jefes()->where('componente_id', '=', $miembro->componente_id)->exists();

            return $esJefe ? $esMiembro ? "jefe" : "monitor" : "miembro";
        }
        return "jefe";
    }

    public function obtenerJerarquiaMismoNivel(NivelJerarquico $nivel)
    {
        $concreto = $nivel->concreto();

        $nivelesMismoNivel = collect([]);
        if ($concreto instanceof Grupo) {
            $nivelesMismoNivel = $nivelesMismoNivel->merge(
                Grupo::where('nivel_jerarquico_id', '!=', $nivel->componente_id)->get()
            );

        } else {
            $nivelesMismoNivel = $nivelesMismoNivel->merge(
                NivelPadre::where('nivel_jerarquico_id', '!=', $nivel->componente_id)->where('nivel', '=', $concreto->nivel)->get()
            );
        }

        return $nivelesMismoNivel->map(function ($e) {
            return $e->nivelJerarquico()->first();
        });
    }

    public function filtrarRoles($rolesFiltrados, $miembrosSinFiltrar) {
        $miembros = collect([]);

        if ($rolesFiltrados != null) {
            foreach ($rolesFiltrados as $rolFiltrado)
                $miembros = $miembros->merge([$rolFiltrado => $miembrosSinFiltrar[$rolFiltrado]]);
        } else
            foreach ($miembrosSinFiltrar as $key => $rol)
                $miembros = $miembros->merge([$key => $rol]);

        return $miembros;
    }
}
