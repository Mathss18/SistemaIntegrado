<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFuncionarioPedidoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('funcionario_pedido', function(Blueprint $table)
		{
			$table->integer('ID_funcionario_pedido', true);
			$table->integer('ID_funcionario')->index('fk_FP_funcionario');
			$table->integer('ID_pedido')->index('fk_FP_pedido');
			$table->string('status', 30);
			$table->timestamp('data_controle')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('funcionario_pedido');
	}

}
