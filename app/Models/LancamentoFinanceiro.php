<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LancamentoFinanceiro extends Model
{
    use HasFactory;
    protected $table = 'lancamentos_financeiros';

    protected $fillable = [
        'safra_id',
        'categoria_id',
        'tipo_receita_custo',
        'descricao',
        'valor_total',
        'data_lancamento',
    ];

    public function safra()
    {
        return $this->belongsTo(Safra::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}