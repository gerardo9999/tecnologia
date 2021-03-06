<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoTable extends Migration
{
    public function up()
    {
        Schema::create('pedido', function (Blueprint $table) {
     
            
            $table->increments('id');
            $table->date('fecha');
            $table->date('fechaentrega');
            $table->time('hora')->default(date('H:i:s'));
            $table->time('horaentrega')->nullable();     
            $table->time('tiempoentrega')->nullable();
            $table->string('glosa')->nullable();
            $table->float('montototal');
            $table->integer('estado')->default;
            // 0  pendiente   //  2 entregado  //3 cancelado 
            $table->integer('idUsuario')->unsigned()->nullable();
            $table->integer('idCliente')->unsigned();
            $table->integer('idRepartidor')->unsigned()->nullable();
            $table->integer('idUbicacion')->unsigned()->nullable();

            $table->foreign('idUsuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idCliente')->references('id')->on('cliente')->onDelete('cascade');
            $table->foreign('idRepartidor')->references('id')->on('repartidor')->onDelete('cascade');
            $table->foreign('idUbicacion')->references('id')->on('ubicacion')->onDelete('cascade');
        });
    }

    public function down(){
        
        Schema::dropIfExists('pedido');
    }
}
