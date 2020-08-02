<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePedidoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pedido', function(Blueprint $table)
		{
			$table->integer('ID_pedido', true);
			$table->string('OF', 50);
			$table->string('codigo', 50);
			$table->string('data_pedido', 50);
			$table->string('data_entrega', 50);
			$table->timestamp('data_controle')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('quantidade');
			$table->string('tipo', 50);
			$table->string('status', 50);
			$table->string('path_desenho', 400)->nullable();
			$table->integer('ID_cliente')->index('ID_cliente');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pedido');
	}

}
