<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cVehiculo extends Model
{
    protected $table = 'cVehiculo';
    // Evitar que los atributos se obtenga por snake attributes
    public static $snakeAttributes = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numPlaca',
        'idcTipoVehiculo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
