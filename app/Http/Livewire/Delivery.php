<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\listaMenu;
use Livewire\WithPagination;

class Delivery extends Component
{
    public $searchText ;
    public $title = "Nuestro Menu";
    public $subtitle ="Realiza tu pedido";
    use WithPagination;
    public function render(){

        $searchText = '%'.$this->searchText.'%';
        $fechaActual =  date('Y-m-d');
        return view('modules.delivery',[
            'listaMenu' => 
            listaMenu::join('menu','menu.id','=','listamenu.idMenu')
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
            ->orWhere('producto.nombre','LIKE','%'.$searchText.'%')
            ->where('menu.estado','=',1)->paginate(4)
        ]);
    }
}
