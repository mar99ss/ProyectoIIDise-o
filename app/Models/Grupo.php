<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $guarded = [];
    protected $primaryKey = "nivel_jerarquico_id";
    // Hola mundo
    public function componente() {
        return $this->belongsTo(NivelJerarquico::class);
    }

    public function nivelJerarquico() {
        return $this->belongsTo(NivelJerarquico::class, "nivel_jerarquico_id", "componente_id");
    }
    
    public function jefes() {
        return $this->belongsToMany(Miembro::class, "jefes_x_grupo", "grupo_id", "miembro_id", "nivel_jerarquico_id");
    }

    // Hola mundo
}
