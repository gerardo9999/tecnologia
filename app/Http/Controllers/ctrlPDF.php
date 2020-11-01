<?php

namespace App\Http\Controllers;

use App\cliente;
use App\detalleOrden;
use App\ordenAtencion;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ctrlPDF extends Controller
{
    public function generarPDF(Request $request, $id){

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
}
