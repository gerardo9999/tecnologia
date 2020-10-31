<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    protected $table = 'pedido';
    protected $primaryKey ='id';
    protected $fillable = [
        'fecha',
        'fechaentrega',
        'hora',
        'horaentrega',
        'tiempoEntrega',
        'glosa',
        'montototal',
        'estado'
    ];
    public $timestamps=false;
}
