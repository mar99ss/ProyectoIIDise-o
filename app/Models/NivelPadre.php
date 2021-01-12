<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelPadre extends Model
{
    use HasFactory;
    public $guarded = [];
    protected $primaryKey = "nivel_jerarquico_id";
    protected $table = "niveles_padre";

    public $incrementing = false;

    public function nivelJerarquico() {
        return $this->belongsTo(NivelJerarquico::class, "nivel_jerarquico_id");
    }
}
