<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $table = 'unidade';

    protected $fillable = [
        'id',
        'nome_fantasia',
        'razao_social',
        'cnpj',
        'bandeira_id',
        'created_at',
        'updated_at',
        'update_by_id',
    ];

    public function bandeira() {
        return $this->belongsTo(Bandeira::class, 'bandeira_id', 'id');
    }

    public function colaboradores() {
        return $this->hasMany(Colaborador::class, 'unidade_id', 'id');
    }
}
