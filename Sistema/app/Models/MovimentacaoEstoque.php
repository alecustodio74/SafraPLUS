<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoEstoque extends Model
{
    use HasFactory;

    protected $table = 'movimentacoes_estoque';

    protected $fillable = [
        'insumo_id',
        'safra_id',
        'tipo_movimentacao',
        'quantidade',
        'valor_unitario',
    ];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }

    public function safra()
    {
        return $this->belongsTo(Safra::class, 'safra_id');
    }
}