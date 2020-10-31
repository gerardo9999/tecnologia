<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class listaMenu extends Model
{
    protected $table = 'listamenu';
    protected $primaryKey ='id';
    protected $fillable = [
        'estado',
        'idMenu',
        'idProducto',
    ];
    public $timestamps=false;


    static function listaMenuCategoria($categoria,$searchText){

            $fechaActual = date('Y-m-d');
            $listaMenu = listaMenu::join('menu','menu.id','=','listamenu.idMenu')
                                    ->join('producto','producto.id','listamenu.idProducto')
                                    ->join('categoria','menu.idCategoria','=','categoria.id')
                                    ->select('producto.id as idProducto',
                                            'producto.foto',
                                            'producto.nombre',
                                            'producto.precio',
                                            'listamenu.estado',
                                            'categoria.nombre as categoria',
                                            'menu.idCategoria')
                                    ->where('menu.fecha','=',$fechaActual)
                                    ->where('menu.estado','=',1)
                                    ->where('categoria.nombre','LIKE','%'.$categoria.'%')
                                    ->where('producto.nombre','LIKE','%'.$searchText.'%')
                                    ->get();

            return $listaMenu;
    }

}
