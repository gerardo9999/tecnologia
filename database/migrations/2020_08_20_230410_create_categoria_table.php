<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
        });
        
        DB::table('categoria')->insert(array('nombre'=>'Pollos'));
        DB::table('categoria')->insert(array('nombre'=>'Carnes'));
        DB::table('categoria')->insert(array('nombre'=>'Platos Especiales'));
        DB::table('categoria')->insert(array('nombre'=>'Bebidas'));
        DB::table('categoria')->insert(array('nombre'=>'Postres'));
        DB::table('categoria')->insert(array('nombre'=>'Milanesa'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria');
    }
}
