<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descripcion')->nullable();
            $table->string('foto');
            $table->string('nombre',50);
            $table->float('precio');

            $table->integer('idCategoria')->unsigned();
            $table->foreign('idCategoria')->references('id')->on('categoria')->onDelete('cascade');
        });
        

        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Pollo1.png','nombre'=>'Pollo a la Brasa','precio'=>10,'idCategoria'=>1));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Pollo2.png','nombre'=>'Pollo a la Broaster','precio'=>10,'idCategoria'=>1));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Pollo3.png','nombre'=>'Alitas de Pollo','precio'=>10,'idCategoria'=>1));


        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Carne1.png','nombre'=>'Parrillada de Vegetales','precio'=>10,'idCategoria'=>2));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Carne2.png','nombre'=>'Asado de Carne','precio'=>10,'idCategoria'=>2));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Carne3.png','nombre'=>'Carne a la Parrillada','precio'=>10,'idCategoria'=>2));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Carne4.png','nombre'=>'Carne a la Parrillada con Papas Fritas','precio'=>10,'idCategoria'=>2));



        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/PlatoE1.png','nombre'=>'Sapchipapas','precio'=>10,'idCategoria'=>3));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/PlatoE2.png','nombre'=>'Pescado','precio'=>10,'idCategoria'=>3));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/PlatoE3.png','nombre'=>'Lazaña','precio'=>10,'idCategoria'=>3));


        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Bebida1.png','nombre'=>'Cocacola','precio'=>10,'idCategoria'=>4));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Bebida2.png','nombre'=>'Sprit','precio'=>10,'idCategoria'=>4));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Bebida3.png','nombre'=>'Pepsi','precio'=>15,'idCategoria'=>4));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Bebida4.png','nombre'=>'Fanta','precio'=>10,'idCategoria'=>4));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Bebida5.png','nombre'=>'Del Valle','precio'=>15,'idCategoria'=>4));


        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/postre1.png','nombre'=>'Helado de Chocolate','precio'=>10,'idCategoria'=>5));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/postre2.png','nombre'=>'Helado de Banana Split','precio'=>10,'idCategoria'=>5));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/postre3.png','nombre'=>'Helado de Oreo','precio'=>15,'idCategoria'=>5));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/postre4.png','nombre'=>'Helado de tres Sabores','precio'=>10,'idCategoria'=>5));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/postre5.png','nombre'=>'Helado de payaso','precio'=>15,'idCategoria'=>5));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/postre6.png','nombre'=>'Helado de Frutilla','precio'=>15,'idCategoria'=>5));


        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Milaneza1.png','nombre'=>'Milaneza de Carne','precio'=>10,'idCategoria'=>6));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Milaneza2.png','nombre'=>'Milaneza de pollo napolitana','precio'=>10,'idCategoria'=>6));
        DB::table('producto')->insert(array('descripcion'=>'sin descripcion','foto'=>'imagenes/Milaneza3.png','nombre'=>'Milaneza de Pollo','precio'=>10,'idCategoria'=>6));
       
       

       
    }
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
