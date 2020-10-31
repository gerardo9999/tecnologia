<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reserva extends Model
{
    protected $table='reserva';
    protected $primarykey='id';
    protected $fillable=[
        'comensales',
        'telefono',
        'fecha',
        'hora',
        'observacion',
        'estado',
        'idCliente'
    ];

    public $timestamps=false;
}
