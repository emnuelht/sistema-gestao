<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $fillable = [
        'tabela',
        'registro_id',
        'acao',
        'valores_anteriores',
        'valores_novos',
        'user_id',
        'update_at',
    ];

    protected $casts = [
        'valores_anteriores' => 'array',
        'valores_novos' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
