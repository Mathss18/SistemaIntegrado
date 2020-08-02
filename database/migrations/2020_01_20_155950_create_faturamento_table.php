<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFaturamentoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('faturamento', function(Blueprint $table)
		{
			$table->integer('ID_faturamento', true);
			$table->string('vale', 20);
			$table->string('nfe', 20);
			$table->string('situacao', 30)->nullable();
			$table->integer('cliente')->index('fk_cliente_faturamento');
			$table->decimal('peso', 9);
			$table->decimal('valor', 9);
			$table->string('firma', 5);
			$table->timestamp('data')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('faturamento');
	}

}
