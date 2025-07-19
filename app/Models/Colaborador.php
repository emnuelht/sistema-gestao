<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $table = 'colaborador';

    protected $fillable = [
        'id',
        'nome',
        'email',
        'cpf',
        'unidade_id',
        'created_at',
        'updated_at',
        'update_by_id',
    ];

    public function unidade() {
        return $this->belongsTo(Unidade::class, 'unidade_id', 'id');
    }
}
