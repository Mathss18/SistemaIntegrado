<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddForeignKeysToSaidaProdutoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('saida_produto', function(Blueprint $table)
		{
			$table->foreign('ID_produto', 'fk_saida_produto')->references('ID_produto')->on('produto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('saida_produto', function(Blueprint $table)
		{
			$table->dropForeign('fk_saida_produto');
		});
	}

}
