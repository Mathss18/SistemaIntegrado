<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSaidaProdutoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('saida_produto', function(Blueprint $table)
		{
			$table->integer('ID_saida', true);
			$table->integer('ID_produto')->nullable()->index('fk_saida_produto');
			$table->decimal('qtde', 9)->nullable();
			$table->string('banho', 100);
			$table->timestamp('data_saida')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
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
		Schema::drop('saida_produto');
	}

}
