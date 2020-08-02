<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRastreabilidadeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rastreabilidade', function(Blueprint $table)
		{
			$table->foreign('cliente', 'fk_rastreabilidade_cliente')->references('ID_cliente')->on('cliente')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('rastreabilidade', function(Blueprint $table)
		{
			$table->dropForeign('fk_rastreabilidade_cliente');
		});
	}

}
