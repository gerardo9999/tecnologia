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
        'tiempoentrega',
        'glosa',
        'montototal',
        'estado'
    ];
    public $timestamps=false;
}
