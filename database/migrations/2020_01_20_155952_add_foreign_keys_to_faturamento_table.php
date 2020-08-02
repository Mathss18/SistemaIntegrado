<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddForeignKeysToFaturamentoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('faturamento', function(Blueprint $table)
		{
			$table->foreign('cliente', 'fk_cliente_faturamento')->references('ID_cliente')->on('cliente')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('faturamento', function(Blueprint $table)
		{
			$table->dropForeign('fk_cliente_faturamento');
		});
	}

}
