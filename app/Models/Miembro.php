<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = "componente_id";
    public $incrementing = false;

    public function componente() {
        return $this->belongsTo(Componente::class, "componente_id");
    }

    public function gruposACargo() {
        return $this->belongsToMany(Grupo::class, "jefes_x_grupo", "miembro_id", "grupo_id");
    }

    public function niveles() {
        return $this->belongsToMany(Componente::class, "componente_x_nivel", "componente_id", "nivel_jerarquico_id");
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'rol_x_miembro');
    }
}
