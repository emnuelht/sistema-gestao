<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoEconomico extends Model
{
    protected $table = 'grupo_economico';

    protected $fillable = [
        'id',
        'nome',
        'created_at',
        'updated_at',
        'update_by_id',
    ];

    public function bandeiras() {
        return $this->hasMany(Bandeira::class, 'grupo_economico_id', 'id');
    }

}
