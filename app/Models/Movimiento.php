<?php

namespace App\Models;

use App\Http\Controllers\GestorJerarquia;
use App\Http\Controllers\GestorMiembro;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $gMiembros;
    protected $gJerarquia;

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
        $this->gMiembros = new GestorMiembro();
        $this->gJerarquia = new GestorJerarquia();
    }

    public function gestorMiembros() {
        return $this->gMiembros;
    }

    public function telefonos() {
        return $this->hasMany(Telefono::class);
    }

    public function gestorJerarquia() {
        return $this->gJerarquia;
    }

    public function raiz() {
        return $this->hasOne(NivelJerarquico::class, "componente_id", "root_id")->first();
    }
    
    public function inicializar($datos) {
        $this->gestorJerarquia()->inicializarMovimiento($this, $datos);
    }
}
