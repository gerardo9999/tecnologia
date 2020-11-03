<?php

namespace App\Http\Controllers;

use App\cliente;
use App\detalleOrden;
use App\detallePedido;
use App\ordenAtencion;
use App\pedido;
use App\bitacora;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ctrlPDF extends Controller
{
    public function generarPDFOrden(Request $request, $id){

        $ordenatencion = ordenAtencion::join('cliente','cliente.id','ordenatencion.idCliente')
        ->where('ordenatencion.id','=',$id)->get();
       // [{}]

        $orden = ordenAtencion::findOrFail($id);
        $idCliente = $orden->idCliente;
        //{}

        $cliente = cliente::findOrFail($idCliente);
      

        $detalle =  detalleOrden::join('producto','producto.id','detalleorden.idProducto')
        ->where('detalleorden.idOrdenAtencion','=',$id)->get();

        $data = ["ordenAtencion" => $ordenatencion,
                 "detalle"       => $detalle,
                 "cliente"       => $cliente,
                 "orden"         => $orden
                ];
          
                
        $pdf = PDF::loadView('pdf.orden',$data);
        
        return $pdf->download('orden-atencion.pdf');
    }
    public function generarPDFPedido(Request $request, $id){

        $ordenPedido = pedido::join('cliente','cliente.id','pedido.idCliente')
        ->where('pedido.id','=',$id)->get();
       // [{}]

        $pedido = pedido::findOrFail($id);
        $idCliente = $pedido->idCliente;
        //{}

        $cliente = cliente::findOrFail($idCliente);
      

        $detalle =  detallePedido::join('producto','producto.id','detallepedido.idProducto')
        ->where('detallepedido.idPedido','=',$id)->get();

        $data = ["ordenPedido" => $ordenPedido,
                 "detalle"       => $detalle,
                 "cliente"       => $cliente,
                 "pedido"         => $pedido
                ];
          
                
        $pdf = PDF::loadView('pdf.pedido',$data);
        
        return $pdf->download('pedido-atencion.pdf');
    }
}
