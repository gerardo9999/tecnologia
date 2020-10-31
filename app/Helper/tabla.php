<?php

use App\listaMenu;
use App\menu;
use App\producto;
use App\pedido;
use App\reserva;
    function productos(){
        $productos = producto::all();
        return $productos;
    }

    function menu($categoria){

        $fechaActual = date('Y-m-d');

        $menu = listaMenu::join('menu','menu.id','=','listamenu.idMenu')
        ->join('producto','producto.id','listamenu.idProducto')
        ->join('categoria','menu.idCategoria','=','categoria.id')
        ->select('producto.id as idProducto',
                 'producto.foto',
                 'producto.nombre',
                 'producto.precio',
                 'listamenu.estado',
                 'menu.idCategoria')
        ->where('menu.fecha','=',$fechaActual)
        ->where('menu.estado','=',1)
        ->where('menu.idCategoria','=',$categoria)
        ->get(); 
        
        return $menu;
    }


    function listaMenu(){
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
                                ->get();

        return $listaMenu;
    }

    function menuCategoria(){
        $menuCategoria = menu::join('categoria','categoria.id','=','menu.idCategoria')
                                ->where('menu.fecha',date('Y-m-d'))
                                ->paginate(10);
        return $menuCategoria;
    }

    function ubicacion($id){
        $ubicacion = ubicacion::join('ubicacion','ubicacion.idUbicacion','=','ubicacion.id')
        ->join('cliente','pedido.idCliente','=','cliente.id')
         ->select('ubicacion.latitud',
                'ubicacion.longitud',
                'ubicacion.idCliente'
                 )
        ->where('cliente.id','=',$id)
       ->paginate(10);

    return $ubicacion;
    }

    function cantidadPedido(){
        $cliente =  Auth::id();
        $pedido = pedido::where('idCliente','=',$cliente)->orWhere('pedido.estado','=',1)
        
        ->get();
        $count = count($pedido);
        return $count;
    }

    function cantidadReserva(){
        $cliente =  Auth::id();
        $pedido = reserva::where('idCliente','=',$cliente)
        ->get();
        $count = count($pedido);
        return $count;
    }
?>