<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddForeignKeysToEstoqueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('estoque', function(Blueprint $table)
		{
			$table->foreign('ID_produto', 'fk_estoque')->references('ID_produto')->on('produto')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('estoque', function(Blueprint $table)
		{
			$table->dropForeign('fk_estoque');
		});
	}

}
