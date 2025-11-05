<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'produtor_id',
        'nome',
        'tipo_receita_despesa',
    ];

    public function produtor()
    {
        return $this->belongsTo(Produtor::class, 'produtor_id');
    }
}