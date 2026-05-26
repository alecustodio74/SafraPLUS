<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustoOperacional extends Model
{
    use HasFactory;

    protected $table = 'custos_operacionais';

    protected $fillable = [
        'safra_id',
        'categoria',
        'maquinario_id',
        'mao_de_obra_id',
        'data',
        'descricao',
        'quantidade',
        'preco_unitario',
        'valor',
    ];

    public function safra()
    {
        return $this->belongsTo(Safra::class, 'safra_id');
    }

    public function maquinario()
    {
        return $this->belongsTo(Maquinario::class, 'maquinario_id');
    }

    public function maoDeObra()
    {
        return $this->belongsTo(MaoDeObra::class, 'mao_de_obra_id');
    }
}
