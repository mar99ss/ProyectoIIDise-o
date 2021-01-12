<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelJerarquico extends Model
{
    use HasFactory;
    protected $table = "niveles_jerarquicos";
    protected $primaryKey = "componente_id";
    public $incrementing = false;
    public $guarded = [];

    public function hijos() {
        return $this->belongsToMany(Componente::class, "componente_x_nivel", "nivel_jerarquico_id", "componente_id", "componente_id", "id");
    }

    public function componente() {
        return $this->belongsTo(Componente::class, "componente_id");
    }

    public function concreto() {
        $grupo = $this->hasOne(Grupo::class, "nivel_jerarquico_id", "componente_id");
        if ($grupo->exists())
            return $grupo->first();

        $nivelPadre = $this->hasOne(NivelPadre::class, "nivel_jerarquico_id", "componente_id");
        if ($nivelPadre->exists())
            return $nivelPadre->first();

        return null;
    }

    public function padre() {
        return $this->belongsToMany(NivelJerarquico::class, "componente_x_nivel", "componente_id", "nivel_jerarquico_id", "componente_id", "componente_id");
    }

    public function niveles() {
        return $this->hijos()->whereIn('componente_id', NivelJerarquico::all()->pluck('componente_id'));
    }

    public function miembros() {
        return $this->hijos()->whereNotIn('componente_id', NivelJerarquico::all()->pluck('componente_id'));
    }
}
