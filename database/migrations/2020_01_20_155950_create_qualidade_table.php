<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateQualidadeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('qualidade', function(Blueprint $table)
		{
			$table->integer('ID_qualidade', true);
			$table->integer('of');
			$table->string('codigo', 100);
			$table->integer('cliente')->index('fk_qualidade_cliente');
			$table->string('abertura', 10)->nullable();
			$table->string('arame', 10)->nullable();
			$table->string('interno', 10)->nullable();
			$table->string('externo', 10)->nullable();
			$table->string('passo', 10)->nullable();
			$table->string('lo_corpo', 10)->nullable();
			$table->string('lo_total', 10)->nullable();
			$table->string('espiras', 10)->nullable();
			$table->timestamp('data')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('qtde');
			$table->integer('sobra')->nullable();
			$table->string('acabamento', 100)->nullable();
			$table->string('obs', 300)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('qualidade');
	}

}
