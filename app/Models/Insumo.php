<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'insumos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'produtor_id',
        'nome',
        'estoque_atual',
    ];

    /**
     * Get the produtor that owns the insumo.
     */
    public function produtor()
    {
        return $this->belongsTo(Produtor::class, 'produtor_id');
    }
}