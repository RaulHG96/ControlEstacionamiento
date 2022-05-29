<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class viewCostos extends Model
{
    protected $table = 'viewCostos';
    // Evitar que los atributos se obtenga por snake attributes
    public static $snakeAttributes = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'NUMERO_PLACA',
        'TIEMPO_ESTACIONADO_MIN',
        'TOTAL_PAGAR'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
