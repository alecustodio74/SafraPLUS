<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Safra extends Model
{
    use HasFactory;

    protected $table = 'safras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'produtor_id',
        'cultura',
        'area_plantada',
        'data_inicio',
        'data_fim',
        'localizacao',
    ];

    /**
     * Get the produtor that owns the safra.
     */
    public function produtor()
    {
        return $this->belongsTo(Produtor::class, 'produtor_id');
    }

    /**
     * Get the lancamentos financeiros for the safra.
     */
    public function lancamentosFinanceiros()
    {
        return $this->hasMany(LancamentoFinanceiro::class, 'safra_id');
    }
}