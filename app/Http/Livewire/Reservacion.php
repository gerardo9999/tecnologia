<?php

namespace App\Http\Livewire;

use App\bitacora;
use App\cliente;
use App\reserva;
use App\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;


class Reservacion extends Component{
    
    

    public $nombre;
    public $apellidos;
    public $empresa;
    public $telefono;
    public $direccion;

    public $login;
    public $password;
    public $email;


    public $comensales;
    public $fecha;
    public $hora;
    public $observacion;
    
    
    public $cliente = 1;
    public $usuario = 0;
    public $reserva = 0;
    public $exito   = 0;


    public $reservacion = 1;
    public $searchText;

    public function render()
    {
        $searchText = '%'.$this->searchText.'%';
        return view('modules.reservacion',[

            'reservaciones' => reserva::join('cliente','cliente.id','=','reserva.idCliente')
            ->where('cliente.nombres','LIKE','%'.$searchText.'%')
            ->orWhere('cliente.apellidos','LIKE','%'.$searchText.'%')
            ->paginate(10)
            
        ]);
    }



    public function guardarDatosCliente(){
        
        $this->validate([
            'nombre'    => 'required',
            'apellidos' => 'required',
            'empresa'   => 'required',
            'telefono'  => 'required',
            'direccion' => 'required'
        ]);
        
        $this->ocultarFormularioCliente();
        $this->ocultarExito();
        $this->mostrarFormularioUsuario();
        $this->ocultarFormularioReserva();
    }
    public function guardarDatosUsuario(){
        
        $this->validate([
            'login'    =>'required',
            'email'    =>'required',
            'password' =>'required'
        ]);
        
        $this->ocultarFormularioCliente();
        $this->ocultarFormularioUsuario();
        $this->ocultarExito();
        $this->mostrarFormularioReserva();
    }

    public function authGuardarReserva( $usuario_id ){
        
        $this->validate([
            'comensales'  => 'required',
            'hora'        => 'required',
            'fecha'       => 'required',
            'observacion' => 'required'
        ]);


        // try {
            // DB::beginTransaction();
            $usuario         = cliente::findOrFail($usuario_id);
            $this->nombre    = $usuario->nombre;
            $this->apellidos = $usuario->apellidos;
            $telefono        = $usuario->telefono;

            $reserva = new reserva();
            $reserva->comensales  = $this->comensales;
            $reserva->fecha       = $this->fecha;
            $reserva->hora        = $this->hora;
            $reserva->telefono    = $telefono;
            $reserva->observacion = $this->observacion;
            $reserva->estado   = 1;
            $reserva->idCliente   = $usuario_id;
            $reserva->save();

            $bitacora = bitacora::guardar('reserva','guardar', $reserva->id);
        //     DB::commit();
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        // }
        
        $this->ocultarFormularioCliente();
        $this->ocultarFormularioReserva();
        $this->mostrarExito();

        $this->comensales = null;
        $this->fecha = null;
        $this->hora = null;
        $this->observacion = null;

    }
    public function guardarDatosReserva(){

        $this->validate([
            'comensales'  => 'required',
            'hora'        => 'required',
            'fecha'       => 'required',
            'observacion' => 'required'
        ]);

        try {

            DB::beginTransaction();
            $usuario            = new User();
            $usuario->name      = $this->login;
            $usuario->username      = $this->login;
            $usuario->email     = $this->email;
            $usuario->password  = Hash::make($this->password);
            $usuario->nombre    = $this->nombre;
            $usuario->apellidos = $this->apellidos;
            $usuario->save();


            $usuario->assignRole('cliente');

            $cliente            = new cliente();
            $cliente->nombres   = $this->nombre;
            $cliente->id        = $usuario->id;
            $cliente->apellidos = $this->apellidos;
            $cliente->empresa   = $this->empresa;
            $cliente->telefono  = $this->telefono;
            $cliente->direccion = $this->direccion;
            $cliente->login     = $this->login;
            $cliente->email     = $this->email;
            $cliente->estado    = 0;
            $cliente->password  = Hash::make($this->password);
            $cliente->save();

            $reserva              = new reserva();
            $reserva->comensales  = $this->comensales;
            $reserva->fecha       = $this->fecha;
            $reserva->telefono    = $this->telefono;
            $reserva->hora        = $this->hora;
            $reserva->observacion = $this->observacion;
            $reserva->estado    = 1;
            $reserva->idCliente   = $cliente->id;
            $reserva->save();

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
        }

        $this->ocultarFormularioCliente();
        $this->ocultarFormularioReserva();
        $this->ocultarFormularioUsuario();
        $this->mostrarExito();
    
    }
    public function borrarDatosReserva(){
        $this->ocultarFormularioReserva();
        $this->ocultarFormularioCliente();
        $this->ocultarExito();
        $this->mostrarFormularioUsuario();

        $this->comensales  = null;
        $this->fecha       = null;
        $this->hora        = null;
        $this->observacion = null;
    }
    public function borrarDatosUsuario(){
        $this->ocultarFormularioReserva();
        $this->ocultarFormularioUsuario();
        $this->ocultarExito();
        $this->mostrarFormularioCliente();

        $this->login    =null;
        $this->password =null;
        $this->email    =null;
    }

    public function mostrarFormularioCliente(){
        $this->cliente = 1;
    }
    public function mostrarFormularioUsuario(){
        $this->usuario = 1;
    }
    public function mostrarFormularioReserva(){
        $this->reserva = 1;
    }
    public function mostrarExito(){
        $this->exito = 1;
    }

    public function ocultarFormularioCliente(){
        $this->cliente = 0;
    }
    public function ocultarFormularioUsuario(){
        $this->usuario = 0;
    }
    public function ocultarFormularioReserva(){
        $this->reserva = 0;
        $this->reservacion = 0;
    }
    public function ocultarExito(){
        $this->exito = 0;
    }

    public function cerrarFormularioReserva(){
        
        $this->ocultarExito();
        $this->reservacion=1;


        $this->fecha        = null;
        $this->hora         = null;
        $this->observacion  = null;
        $this->comensales   = null;

    }




}
