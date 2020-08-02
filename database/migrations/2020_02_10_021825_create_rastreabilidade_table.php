<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRastreabilidadeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rastreabilidade', function(Blueprint $table)
		{
			$table->integer('ID_rastreabilidade', true);
			$table->string('lacre', 50);
			$table->string('cor', 50);
			$table->string('codigo', 50);
			$table->string('data', 50);
			$table->string('nota', 50);
			$table->integer('cliente')->index('fk_rastreabilidade_cliente');
			$table->integer('qtde');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rastreabilidade');
	}

}
