<?php

namespace App\Http\Controllers;

use App\cliente;
use Illuminate\Http\Request;
use App\ubicacion;
use App\pedido;
use App\detallePedido;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ctrlPedido extends Controller
{      
    public function guardar(Request $request){
        $hora1= date('H:i:s'); 
        
        if (empty($request->hora_entrega)) {
            $hora = $this->sumarHoras($hora1,$request->tiempo);
            // return [
            //     "horaActual"=>$hora1, "horaCalculada"=>$hora, $request->tiempo
            // ];
        }else{
            $hora =$request->hora_entrega;
            // return [
            //     "horaActual"=>$hora1  , "hora"=>$hora, $request->tiempo
            // ];
        }

        if($request->guardar =='auth'){
            
            $idUsuario = Auth::id();
        
            $ubicacion = new ubicacion();
            $ubicacion->referencia = $request->referencia;
            $ubicacion->latitud    = $request->textlatitud;
            $ubicacion->longitud   = $request->textlongitud;
            $ubicacion->url        = $request->textlink;
            $ubicacion->save();

            $pedido = new pedido();
            $pedido->fecha = date('Y-m-d');
            $pedido->fechaentrega = $request->fecha_entrega;
            $pedido->horaentrega = $hora;
            $pedido->montototal = $request->montoTotal;
            $pedido->estado = 0;    //pendiente
            $pedido->idUsuario = null;
            $pedido->idCliente = Auth::id();
            $pedido->idUbicacion = $ubicacion->id;
            $pedido->save();

            $count = count($request->precio);

            for ($i=0; $i < $count; $i++) { 

                $subtotal = $request->cantidad[$i] * $request->precio[$i];

                $detalle = new detallepedido();
                $detalle->cantidad = $request->cantidad[$i];
                $detalle->subTotal = $subtotal;
                $detalle->idPedido = $pedido->id;
                $detalle->idProducto = $request->idproducto[$i];
                $detalle->save();
            }
            $pedidoUser = pedido::findOrFail($pedido->id);
            $pedidoUser->idUsuario = Auth::id();
            $pedidoUser->update();

        }else{

            $usuario            = new User();
            $usuario->name      = $request->name;
            $usuario->email     = $request->email;
            $usuario->password  = Hash::make($request->contraseña);
            $usuario->nombre    = $request->nombre;
            $usuario->apellidos = $request->apellidos;
            $usuario->save();


            $usuario->assignRole('cliente');

            $cliente            = new cliente();
            $cliente->nombres   = $request->nombre;
            $cliente->id        = $usuario->id;
            $cliente->apellidos = $request->apellidos;
            $cliente->empresa   = $request->empresa;
            $cliente->telefono  = $request->telefono;
            $cliente->direccion = $request->direccion;
            $cliente->login     = $request->name;
            $cliente->email     = $request->email;
            $cliente->estado    = 0;
            $cliente->password  = Hash::make($request->constraseña);
            $cliente->save();            



            $ubicacion = new ubicacion();
            $ubicacion->referencia = $request->referencia;
            $ubicacion->latitud    = $request->textlatitud;
            $ubicacion->longitud   = $request->textlongitud;
            $ubicacion->url        = $request->textlink;
            $ubicacion->save();

            $pedido = new pedido();
            $pedido->fecha = date('Y-m-d');
            $pedido->fechaentrega = $request->fecha_entrega;
            $pedido->horaentrega = $hora;
            $pedido->montototal = $request->montoTotal;
            $pedido->estado = 0;    //pendiente
            $pedido->idUsuario = $cliente->id;
            $pedido->idCliente = $cliente->id;
            $pedido->idUbicacion = $ubicacion->id;
            $pedido->save();

            $count = count($request->precio);

            for ($i=0; $i < $count; $i++) { 

                $subtotal = $request->cantidad[$i] * $request->precio[$i];

                $detalle = new detallepedido();
                $detalle->cantidad = $request->cantidad[$i];
                $detalle->subTotal = $subtotal;
                $detalle->idPedido = $pedido->id;
                $detalle->idProducto = $request->idproducto[$i];
                $detalle->save();
            }

        }

    
        return Redirect::to('/')->with('create','su pedido fue realizado con exito!');

    }

    public function sumarHoras($hora1,$hora2){
        $hora1=explode(":",$hora1);
        $hora2=explode(":",$hora2);
        $temp=0;
    
        //sumo segundos 
        $segundos=(int)$hora1[2]+(int)$hora2[2];
        while($segundos>=60){
            $segundos=$segundos-60;
            $temp++;
        }
    
        //sumo minutos 
        $minutos=(int)$hora1[1]+(int)$hora2[1]+$temp;
        $temp=0;
        while($minutos>=60){
            $minutos=$minutos-60;
            $temp++;
        }
    
        //sumo horas 
        $horas=(int)$hora1[0]+(int)$hora2[0]+$temp;
    
        if($horas<10)
            $horas= '0'.$horas;
    
        if($minutos<10)
            $minutos= '0'.$minutos;
    
        if($segundos<10)
            $segundos= '0'.$segundos;
    
        $sum_hrs = $horas.':'.$minutos.':'.$segundos;
    
        return ($sum_hrs);
    
    }
    public function mostrarPedidoAdmin(Request $request){
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if($buscar==''){
             $pedido= pedido::join('cliente','cliente.id','=','pedido.idCliente')
             ->join('ubicacion','ubicacion.id','=','pedido.idUbicacion') 
             ->select('pedido.idCliente',
             'pedido.id',
             'cliente.nombres',
             'cliente.apellidos',
             DB::raw('CONCAT(nombres," ",apellidos) as nombreCompleto'),
             'cliente.login',
             'cliente.password',
             'cliente.empresa',
             'cliente.telefono',
             'cliente.direccion',
             'cliente.email',
             'cliente.estado',
             'pedido.glosa',
             'ubicacion.referencia',
             'pedido.montototal',
             'pedido.fecha',
             'pedido.fechaEntrega',
             'pedido.horaEntrega',
             'pedido.montoTotal'
             
             )
             ->orderBy('pedido.id','desc')


            //  "usuario"=> $usuario , "role"=>$usuario->roles[0]->name
             ->paginate(10);
         }
         else{
            $pedido= pedido::join('cliente','cliente.id','=','pedido.idCliente')
            ->join('ubicacion','ubicacion.id','=','pedido.ubicacion')
            ->select('cliente.id as idCliente',
            'pedido.id',
            'cliente.nombres',
            'cliente.apellidos',
            DB::raw('CONCAT(nombres," ",apellidos) as nombreCompleto'),
            'cliente.login',
            'cliente.password',
            'cliente.empresa',
            'cliente.telefono',
            'cliente.direccion',
            'cliente.email',
            'cliente.estado',
            'pedido.glosa',
            'pedido.montototal',
            'pedido.fecha',
            'pedido.fechaEntrega',
            'pedido.horaEntrega',
            'pedido.montoTotal'
            )

             ->where($criterio.'.nombres', 'like', '%'.$buscar.'%')
             ->orderBy('cliente.id','desc')->paginate(10);            
         }


         
         return [
             'pagination' => [
                 'total'        => $pedido->total(),
                 'current_page' => $pedido->currentPage(),
                 'per_page'     => $pedido->perPage(),
                 'last_page'    => $pedido->lastPage(),
                 'from'         => $pedido->firstItem(),
                 'to'           => $pedido->lastItem(),
             ],
             'pedido' => $pedido
            ];
    }
    public function mostrar(){
        // if (!$request->ajax()) return redirect('/');

        $cliente= Auth::id();
        
        $pedido = pedido::join('ubicacion','pedido.idUbicacion','=','ubicacion.id')
         ->join('cliente','pedido.idCliente','=','cliente.id')
          ->select('pedido.id',
                 'pedido.idUbicacion',
                 'pedido.idCliente',
                 'pedido.fechaEntrega',
                 'pedido.horaEntrega',
                 'pedido.montoTotal',
                 'ubicacion.referencia',
                 'cliente.nombres as cliente',
                 'pedido.estado'
                  )
                  ->where('cliente.id','=',$cliente)
        ->orderBy('pedido.id', 'desc')->paginate(10);
        
        return [
            'pagination' => [
                'total'        => $pedido->total(),
                'current_page' => $pedido->currentPage(),
                'per_page'     => $pedido->perPage(),
                'last_page'    => $pedido->lastPage(),
                'from'         => $pedido->firstItem(),
                'to'           => $pedido->lastItem(),
            ],
            'pedido' => $pedido,
        ];
    }
public function mostrarPedidoRepartidor(Request $request){

        $repartidor = Auth::id();
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if($buscar==''){


             $pedido= pedido::join('cliente','cliente.id','=','pedido.idCliente')
             ->join('ubicacion','ubicacion.id','=','pedido.idUbicacion') 
             ->select('pedido.idCliente',
             'pedido.id',
             'cliente.nombres',
             'cliente.apellidos',
             DB::raw('CONCAT(nombres," ",apellidos) as nombreCompleto'),
             'cliente.login',
             'cliente.password',
             'cliente.empresa',
             'cliente.telefono',
             'cliente.direccion',
             'cliente.email',
             'cliente.estado',
             'pedido.fecha',
             'pedido.fechaEntrega',
             'pedido.horaEntrega',
             'ubicacion.referencia',
             'pedido.montoTotal',
             'pedido.estado'
             )->where('pedido.idRepartidor','=',$repartidor)
             ->orderBy('pedido.id','desc')


            //  "usuario"=> $usuario , "role"=>$usuario->roles[0]->name
             ->paginate(10);
         }
         else{
            $pedido= pedido::join('cliente','cliente.id','=','pedido.idCliente')
            ->join('ubicacion','ubicacion.id','=','pedido.ubicacion')
            ->select('cliente.id as idCliente',
            'pedido.id',
            'cliente.nombres',
            'cliente.apellidos',
            DB::raw('CONCAT(nombres," ",apellidos) as nombreCompleto'),
            'cliente.login',
            'cliente.password',
            'cliente.empresa',
            'cliente.telefono',
            'cliente.direccion',
            'cliente.email',
            'cliente.estado',
            'pedido.fecha',
            'pedido.fechaEntrega',
            'pedido.horaEntrega',
            'ubicacion.referencia',
            'pedido.montoTotal',
            'pedido.estado'
            )
             ->where('pedido.idRepartidor','=',$repartidor)
             ->where($criterio.'.nombres', 'like', '%'.$buscar.'%')
             ->orderBy('cliente.id','desc')->paginate(10);            
         }


         
         return [
             'pagination' => [
                 'total'        => $pedido->total(),
                 'current_page' => $pedido->currentPage(),
                 'per_page'     => $pedido->perPage(),
                 'last_page'    => $pedido->lastPage(),
                 'from'         => $pedido->firstItem(),
                 'to'           => $pedido->lastItem(),
             ],
             'pedido' => $pedido
            ];
    }




    public function entregado(Request $request){
        $pedido= pedido::findOrFail($request->id);
        $pedido->estado = 1;
        $pedido->update();

        return ["pedido"=>$pedido];

    }


}



        // if (!$request->ajax()) return redirect('/');

        // $idRepartidor = Auth::id();     
        // if($buscar==""){
//             // $pedido = pedido::join('repartidor','pedido.idRepartidor','=','repartidor.id')
//             ->join('cliente','cliente.id','=','pedido.idCliente')
//             ->join('ubicacion','ubicacion.id','=','pedido.ubicacion')
//             ->select('cliente.id as idCliente',
//             'cliente.nombres',
//             'cliente.apellidos',
//             DB::raw('CONCAT(nombres," ",apellidos) as cliente'),
//                 "pedido.fecha",
//                 "pedido.fechaEntrega",
//                 "pedido.horaEntrega",
//                 "pedido.ubicacion",
//                 "ubicacion.referencia",
//                 "pedido.montoTotal",
//                 "pedido.estado"
//             )
//             ->orderBy('pedido.id','desc')
//             ->where('idRepartidor','=',$idRepartidor)
//             ->paginate(10);
//         }else{
//             $pedido = pedido::join('repartidor','pedido.idRepartidor','=','repartidor.id')
//             ->join('cliente','cliente.id','=','pedido.idCliente')
//             ->join('ubicacion','ubicacion.id','=','pedido.ubicacion')
//             ->select(
//                 'cliente.nombres',
//                 'cliente.apellidos',
//                  DB::raw('CONCAT(nombres," ",apellidos) as cliente'),
//                 "pedido.fecha",
//                 "pedido.horaEntrega",
//                 "pedido.ubicacion",
//                 "pedido.referencia",
//                 "pedido.montoTotal",
//                 "pedido.estado"
//             )
//             ->orderBy('pedido.id','desc')
//             ->where('pedido.'.$criterio, '=',$buscar)
//             ->where('idRepartidor','=',$idRepartidor)
//             ->paginate(10);
//         }

//         return [

//             'pagination' => [
//                 'total'        => $pedido->total(),
//                 'current_page' => $pedido->currentPage(),
//                 'per_page'     => $pedido->perPage(),
//                 'last_page'    => $pedido->lastPage(),
//                 'from'         => $pedido->firstItem(),
//                 'to'           => $pedido->lastItem(),
//             ],
//             'pedido' => $pedido,
//         ];
//     }
//  }