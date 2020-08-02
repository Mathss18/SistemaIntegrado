<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEntradaProdutoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entrada_produto', function(Blueprint $table)
		{
			$table->integer('ID_entrada', true);
			$table->integer('ID_produto')->nullable()->index('fk_entrada_produto');
			$table->decimal('qtde', 9)->nullable();
			$table->decimal('valor_unitario', 9)->nullable()->default(0.00);
			$table->timestamp('data_entrada')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('entrada_produto');
	}

}
