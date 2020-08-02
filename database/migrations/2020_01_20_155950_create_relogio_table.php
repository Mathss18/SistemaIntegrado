<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRelogioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('relogio', function(Blueprint $table)
		{
			$table->integer('ID_relogio', true);
			$table->integer('inicio');
			$table->integer('fim');
			$table->timestamp('data')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('status', 10);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('relogio');
	}

}
