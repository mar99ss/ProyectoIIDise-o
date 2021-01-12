<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    use HasFactory;

    public function nivelJerarquico() {
        return $this->hasOne(NivelJerarquico::class);
    }

    public function concreto() {
        $nivelJerarquico = $this->nivelJerarquico();
        if ($nivelJerarquico->exists())
            return $nivelJerarquico->first()->concreto();

        $miembro = $this->hasOne(Miembro::class);
        if ($miembro->exists())
            return $miembro->first();

        return null;
    }
}
