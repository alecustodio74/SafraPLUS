<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustoOperacional extends Model
{
    use HasFactory;

    // Assumindo que o nome da tabela seja 'custos_operacionais'
    protected $table = 'custos_operacionais'; 

    protected $fillable = [
        'safra_id',
        'maquinario_id', // Nulo se for Mão de Obra
        'mao_de_obra_id', // Nulo se for Maquinário
        'data',
        'descricao',
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