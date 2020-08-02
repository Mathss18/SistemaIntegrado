<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateClienteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cliente', function(Blueprint $table)
		{
			$table->integer('ID_cliente', true);
			$table->string('nome', 100);
			$table->string('cpf_cnpj', 50)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('telefone', 50)->nullable();
			$table->string('telefone2', 50);
			$table->string('inscricao_estadual', 50);
			$table->string('logradouro', 100)->nullable();
			$table->string('numero', 10)->nullable();
			$table->string('cidade', 100)->nullable();
			$table->string('uf', 2)->nullable();
			$table->string('bairro', 100)->nullable();
			$table->string('contato', 100)->nullable();
			$table->string('cep', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cliente');
	}

}
