<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddForeignKeysToQualidadeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('qualidade', function(Blueprint $table)
		{
			$table->foreign('cliente', 'fk_qualidade_cliente')->references('ID_cliente')->on('cliente')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('qualidade', function(Blueprint $table)
		{
			$table->dropForeign('fk_qualidade_cliente');
		});
	}

}
