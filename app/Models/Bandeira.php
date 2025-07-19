<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bandeira extends Model
{
    protected $table = "bandeira";

    protected $fillable = [
        'id',
        'nome',
        'grupo_economico_id',
        'created_at',
        'updated_at',
        'update_by_id',
    ];

    public function grupoEconomico() {
        return $this->belongsTo(GrupoEconomico::class, 'grupo_economico_id', 'id');
    }


    public function unidades() {
        return $this->hasMany(Unidade::class, 'bandeira_id', 'id');
    }

}
