<?php

namespace App\Http\Livewire;

use App\listaMenu;
use App\producto;
use Livewire\Component;

class Pedido extends Component
{
    public $categoria;
    public $searchText;
    public $idProducto;

    public $ejemplo = "Ejemplo";
    public $total = 0;

    public $cantidad;
    public $arrayProducto=[];
    public function render(){
        
        $categoria = '%'.$this->categoria.'%';
        $searchText = '%'.$this->searchText.'%';

        return view('modules.pedido',[

            'menu' => listaMenu::listaMenuCategoria($categoria,$searchText)

        ]);
    }
    public function agregarIdProducto($idProducto){
        $this->idProducto = $idProducto;
    }


    public function agregarProductoDetalle($idProducto){
        
        $producto = producto::findOrFail($idProducto);
        $precio   = $producto->precio;
        $nombre   = $producto->nombre;
        $subTotal = $precio * $this->cantidad;

        $this->total = $this->total + $subTotal;
        array_push($this->arrayProducto,["producto"=>$nombre,"cantidad" => $this->cantidad,"idProducto"=> $idProducto , "subTotal"=>$subTotal]);
    }
    public function eliminarProductoDetalle( $arrayProducto){
        array_splice($this->arrayProducto,1,0);
    }


}
