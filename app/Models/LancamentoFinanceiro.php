<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LancamentoFinanceiro extends Model
{
    use HasFactory;

    /**
     * Define o nome da tabela
     */
    protected $table = 'lancamentos_financeiros';

    /**
     * Campos que podem ser preenchidos em massa (Mass Assignment)
     * ESTA É A CORREÇÃO IMPORTANTE
     */
    protected $fillable = [
        'safra_id',
        'categoria_id',
        'tipo_receita_custo',
        'descricao',
        'valor_total',
        'data_lancamento',
    ];

    /**
     * Define o relacionamento: Um lançamento pertence a uma Safra.
     */
    public function safra()
    {
        return $this->belongsTo(Safra::class);
    }

    /**
     * Define o relacionamento: Um lançamento pertence a uma Categoria.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}