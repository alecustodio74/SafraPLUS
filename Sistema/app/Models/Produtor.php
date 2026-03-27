<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Produtor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'produtores';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'cpf_cnpj',
        'telefone',
        'propriedade',
        'cultura_principal',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function safras()
    {
        return $this->hasMany(Safra::class, 'produtor_id');
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'produtor_id');
    }

    public function insumos()
    {
        return $this->hasMany(Insumo::class, 'produtor_id');
    }

    public function maquinarios()
    {
        return $this->hasMany(Maquinario::class, 'produtor_id');
    }

    public function maoDeObras()
    {
        return $this->hasMany(MaoDeObra::class, 'produtor_id');
    }
}