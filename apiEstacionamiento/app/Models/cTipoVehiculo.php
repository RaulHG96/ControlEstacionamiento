<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cTipoVehiculo extends Model
{
    protected $table = 'cTipoVehiculo';
    // Evitar que los atributos se obtenga por snake attributes
    public static $snakeAttributes = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipoVehiculo',
        'costoEstacionamiento',
        'habilitado',
        'eliminado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
