<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEstoqueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estoque', function(Blueprint $table)
		{
			$table->integer('ID_estoque', true);
			$table->integer('ID_produto')->nullable()->index('fk_estoque');
			$table->decimal('qtde', 9)->nullable();
			$table->decimal('valor_unitario', 9)->nullable()->default(0.00);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('estoque');
	}

}
