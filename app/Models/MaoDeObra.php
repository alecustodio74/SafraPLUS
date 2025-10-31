<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaoDeObra extends Model
{
    use HasFactory;

    protected $table = 'mao_de_obra';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'produtor_id',
        'nome_ou_tipo',
        'custo_diario_hora',
    ];

    /**
     * Get the produtor that owns the mao de obra.
     */
    public function produtor()
    {
        return $this->belongsTo(Produtor::class, 'produtor_id');
    }
}