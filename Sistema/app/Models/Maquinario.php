<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquinario extends Model
{
    use HasFactory;

    protected $table = 'maquinarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'produtor_id',
        'nome',
        'marca',
        'modelo',
        'ano',
        'descricao_atividade',
        'custo_hora',
    ];

    /**
     * Get the produtor that owns the maquinario.
     */
    public function produtor()
    {
        return $this->belongsTo(Produtor::class, 'produtor_id');
    }
}