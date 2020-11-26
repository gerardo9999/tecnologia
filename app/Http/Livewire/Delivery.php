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
        
        return view('modules.delivery',[
            'listaMenu' => 
            listaMenu::menuDia($searchText)
        ]);
    }
}
