<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\Grupo;
use App\Models\Miembro;
use App\Models\NivelJerarquico;
use Illuminate\Http\Request;

class GestorMiembro
{

    public function obtenerCatalogo($filtro = null)
    {
        if ($filtro == null)
            return Miembro::where(['enabled' => 1])->orderBy('created_at', 'DESC');
        else {
            $query = Miembro::where(['enabled' => 1]);
            if ($filtro["filtro"] === "identificacion")
                $query = $query->where(["identificacion" => $filtro["valor"]]);
            else
                $query = $query->where($filtro["filtro"], "like", "%" . $filtro["valor"] . "%");

            return $query->orderBy('created_at', 'DESC');
        }
    }

    public function deleteMiembro(Miembro $miembro)
    {
        $miembro->enabled = false;
        $miembro->save();

        return redirect()->route('miembros.index');
    }

    public function crearMiembro($data)
    {
        $componenteId = Componente::create([])->id;
        Miembro::create($data + ["componente_id" => $componenteId]);
    }

    public function actualizarDatosPersonales($idMiembro, $nuevosDatosPersonales)
    {
        $miembro = Miembro::where(['componente_id' => $idMiembro])->first();
        foreach ($nuevosDatosPersonales as $dato => $nuevoValor)
            $miembro[$dato] = $nuevoValor;
        $miembro->save();
    }

    public function posicionesMiembroJerarquia(Miembro $miembro)
    {
        $posicionesJerarquia = [];

        $componentes = $miembro->niveles()->get();

        $gruposACargo = $miembro->gruposACargo()->get()->map(function ($e) {
            return $e->nivelJerarquico()->first();
        });

        $idsGruposACargo = $gruposACargo->pluck('componente_id')->toArray();

        foreach ($componentes as $componente)
            if ($componente->nivelJerarquico()->first()->concreto() instanceof Grupo)
                if (in_array($componente->id, $idsGruposACargo))
                    $posicionesJerarquia[] = [$componente->nivelJerarquico()->first(), "jefe"];
                else
                    $posicionesJerarquia[] = [$componente->nivelJerarquico()->first(), "miembro"];
            else
                $posicionesJerarquia[] = [$componente->nivelJerarquico()->first(), "jefe"];

        $idsJerarquia = $componentes->pluck('id')->toArray();
        foreach ($idsGruposACargo as $key => $idGrupo)
            if (!in_array($idGrupo, $idsJerarquia))
                $posicionesJerarquia[] = [$gruposACargo[$key], "monitor"];

        return $posicionesJerarquia;
    }

    private function removerDeRol($nivelJerarquico, $miembro, $rol)
    {

        $concreto = $nivelJerarquico->concreto();

        switch ($rol) {
            case "monitor":
                throw_if(!($concreto instanceof Grupo), "Rol inválido");
                $concreto->jefes()->detach($miembro);
                break;
            case "jefe":
                if ($concreto instanceof Grupo) {
                    $concreto->jefes()->detach($miembro);
                }
                // echo($nivelJerarquico->miembros());

                $nivelJerarquico->miembros()->detach($miembro->componente()->first());
                break;
            default:
                $nivelJerarquico->miembros()->detach($miembro->componente()->first());
                break;
        }
    }

    private function agregarARol($nivelJerarquico, $miembro, $rol)
    {

        $concreto = $nivelJerarquico->concreto();

        switch ($rol) {
            case "monitor":
                throw_if(!($concreto instanceof Grupo), "Nuevo rol inválido");
                $concreto->jefes()->attach($miembro);
                break;
            case "jefe":
                if ($concreto instanceof Grupo) {
                    $concreto->jefes()->attach($miembro);
                }
                $nivelJerarquico->miembros()->attach($miembro->componente()->first());
                break;
            case "miembro":
                $nivelJerarquico->miembros()->attach($miembro->componente()->first());
                break;
        }
    }

    public function trasladarMiembro($viejoNivelId, $nuevoNivelId, $miembroId, $rol, $rolViejo = null)
    {
        if ($rolViejo === null)
            $rolViejo = $rol;

        $viejoNivel = NivelJerarquico::where(['componente_id' => $viejoNivelId])->first();
        $nuevoNivel = NivelJerarquico::where(['componente_id' => $nuevoNivelId])->first();
        $miembro = Miembro::where(['componente_id' => $miembroId])->first();


        $this->removerDeRol($viejoNivel, $miembro, $rolViejo);
        $this->agregarARol($nuevoNivel, $miembro, $rol);


        return true;
    }

    public function asignarRol($nivelJerarquicoId, $miembroId, $viejoRol, $nuevoRol)
    {
        $nivelJerarquico = NivelJerarquico::where(['componente_id' => $nivelJerarquicoId])->first();

        $miembro = Miembro::where(['componente_id' => $miembroId])->first();
        //dd($nivelJerarquico,$miembro,$viejoRol,$nuevoRol);
        $this->removerDeRol($nivelJerarquico, $miembro, $viejoRol);
        $this->agregarARol($nivelJerarquico, $miembro, $nuevoRol);

        return true;
    }

}
