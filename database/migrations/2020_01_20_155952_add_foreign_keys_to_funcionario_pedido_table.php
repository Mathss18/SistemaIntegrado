<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddForeignKeysToFuncionarioPedidoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('funcionario_pedido', function(Blueprint $table)
		{
			$table->foreign('ID_funcionario', 'fk_FP_funcionario')->references('ID_funcionario')->on('funcionario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('ID_pedido', 'fk_FP_pedido')->references('ID_pedido')->on('pedido')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('funcionario_pedido', function(Blueprint $table)
		{
			$table->dropForeign('fk_FP_funcionario');
			$table->dropForeign('fk_FP_pedido');
		});
	}

}
