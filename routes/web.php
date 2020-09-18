<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



// === Desabilitar rota de Registo
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::group(['middleware' => ['auth']],function(){
    //Trocar Senha do User Logado (Entrar no controller);
    //Route::get('/admin/trocarSenha', 'Auth\TrocarSenhaController@trocarSenha');

    //Rotas de Clientes
    Route::resource('/admin/cliente', 'Admin\ClienteController')->middleware('auth.tipo:Admin,Secretaria');
    Route::get('autocompleteclientes','Admin\PedidoController@AutoCompleteClientes');
    Route::get('autocompletetransp','Admin\ClienteController@AutoCompleteTransp');

    //Rotas de Fornecedores
    Route::resource('/admin/fornecedor', 'Admin\FornecedorController')->middleware('auth.tipo:Admin,Secretaria');
    Route::get('autocompletefornecedor','Admin\FornecedorController@AutoCompleteFornecedores');

    //Rotas de Pedidos
    Route::get('/admin/pedido/aberto', 'Admin\PedidoController@pedidosAbertos')->name('pedido.aberto')->middleware('auth.tipo:Admin,Secretaria');
    Route::get('/admin/pedido/fechado', 'Admin\PedidoController@pedidosFechados')->middleware('auth.tipo:Admin,Secretaria');
    Route::get('/admin/pedido/aberto2', 'Admin\PedidoController@message')->name('pedido.aberto2')->middleware('auth.tipo:Admin,Secretaria');
    Route::post('/admin/pedido/adicionar','Admin\PedidoController@adicionar')->name('pedido.adicionar')->middleware('auth.tipo:Admin,Secretaria');
    Route::resource('/admin/pedido', 'Admin\PedidoController')->middleware('auth.tipo:Admin,Secretaria');

    //Rotas de Estoque
    Route::post('/admin/estoque/gerarRelatorioEntrada', 'Admin\EstoqueController@gerarRelatorioEntrada')->middleware('auth.tipo:Admin,Almoxarifado,Secretaria');
    Route::get('/admin/estoque/relatorioEntrada', 'Admin\EstoqueController@relatorioEntrada')->middleware('auth.tipo:Admin,Almoxarifado,Secretaria');

    Route::post('/admin/estoque/gerarRelatorioSaida', 'Admin\EstoqueController@gerarRelatorioSaida')->middleware('auth.tipo:Admin,Almoxarifado,Producao,Secretaria');
    Route::get('/admin/estoque/relatorioSaida', 'Admin\EstoqueController@relatorioSaida')->middleware('auth.tipo:Admin,Almoxarifado,Producao,Secretaria');

    Route::resource('/admin/estoque', 'Admin\EstoqueController')->middleware('auth.tipo:Admin,Almoxarifado,Producao,Secretaria');
    
    //Rotas de Entrada de Produtos
    Route::resource('/admin/entradaProduto', 'Admin\Entrada_ProdutoController')->middleware('auth.tipo:Admin,Almoxarifado,Secretaria');
    
    //Rotas de Saida de Produtos
    Route::resource('/admin/saidaProduto', 'Admin\Saida_ProdutoController')->middleware('auth.tipo:Admin,Almoxarifado,Producao,Secretaria');
    
    //Rotas de Relógio
    Route::post('/admin/relogio/armazenarDataSeccionRelogio', 'Admin\RelogioController@armazenarDataSeccionRelogio')->middleware('auth.tipo:Admin,Almoxarifado');
    Route::get('/admin/relogio/relatorio', 'Admin\RelogioController@relatorio')->middleware('auth.tipo:Admin,Almoxarifado');
    Route::get('/admin/relogio/relatorio2', 'Admin\RelogioController@relatorio2')->middleware('auth.tipo:Admin,Almoxarifado');
    Route::post('/admin/relogio/fechado', 'Admin\RelogioController@fechado')->middleware('auth.tipo:Admin,Almoxarifado');
    Route::post('/admin/relogio/editar', 'Admin\RelogioController@editar')->middleware('auth.tipo:Admin,Almoxarifado');
    Route::post('/admin/relogio/excluir', 'Admin\RelogioController@excluir')->middleware('auth.tipo:Admin,Almoxarifado');
    Route::resource('/admin/relogio', 'Admin\RelogioController')->middleware('auth.tipo:Admin,Almoxarifado');

    //Rotas de Faturamento
    Route::get('/admin/faturamento/faturamentoFM', 'Admin\FaturamentoController@faturamentoFM')->middleware('auth.tipo:Admin,Secretaria');
    Route::post('/admin/faturamento/acao', 'Admin\FaturamentoController@acao')->middleware('auth.tipo:Admin,Secretaria');
    Route::post('/admin/faturamento/armazenarDataSeccion', 'Admin\FaturamentoController@armazenarDataSeccion')->middleware('auth.tipo:Admin,Secretaria');
    Route::get('/admin/faturamento/data', 'Admin\FaturamentoController@data')->middleware('auth.tipo:Admin,Secretaria');
    Route::get('/admin/faturamento/relatorio', 'Admin\FaturamentoController@relatorio')->middleware('auth.tipo:Admin,Secretaria');
    Route::resource('/admin/faturamento', 'Admin\FaturamentoController')->middleware('auth.tipo:Admin,Secretaria');

    //Rotas de Funcionario_Pedido
    Route::post('/admin/funcionarioPedido/baixa', 'Admin\FuncionarioPedidoController@baixa')->middleware('auth.tipo:Admin,Secretaria,Almoxarifado,Qualidade,Producao');
    Route::post('/admin/funcionarioPedido/armazenarDataSeccion', 'Admin\FuncionarioPedidoController@armazenarDataSeccion')->middleware('auth.tipo:Admin,Secretaria,Almoxarifado,Qualidade,Producao');
    Route::get('/admin/funcionarioPedido/data', 'Admin\FuncionarioPedidoController@data')->middleware('auth.tipo:Admin,Secretaria,Almoxarifado,Qualidade,Producao');
    Route::get('/admin/funcionarioPedido/relatorio', 'Admin\FuncionarioPedidoController@relatorio')->middleware('auth.tipo:Admin,Secretaria,Almoxarifado,Qualidade,Producao');
    Route::resource('/admin/funcionarioPedido', 'Admin\FuncionarioPedidoController');

    //Rotas de Rastreabilidade
    Route::post('/admin/rastreabilidade/cadastrarLacres', 'Admin\RastreabilidadeController@cadastrarLacres')->middleware('auth.tipo:Admin,Qualidade');
    Route::post('/admin/rastreabilidade/armazenarInfoSeccion', 'Admin\RastreabilidadeController@armazenarInfoSeccion')->middleware('auth.tipo:Admin,Qualidade');
    Route::get('/admin/rastreabilidade/info', 'Admin\RastreabilidadeController@info')->middleware('auth.tipo:Admin,Qualidade');
    Route::get('/admin/rastreabilidade/cadastrar', 'Admin\RastreabilidadeController@cadastrar')->middleware('auth.tipo:Admin,Qualidade');
    Route::resource('/admin/rastreabilidade', 'Admin\RastreabilidadeController')->middleware('auth.tipo:Admin,Qualidade');

    //Rotas de Qualidade
    Route::post('/admin/qualidade/acao', 'Admin\QualidadeController@acao')->middleware('auth.tipo:Admin,Qualidade');
    Route::post('/admin/qualidade/armazenarDataSeccion', 'Admin\QualidadeController@armazenarDataSeccion')->middleware('auth.tipo:Admin,Qualidade');
    Route::get('/admin/qualidade/data', 'Admin\QualidadeController@data')->middleware('auth.tipo:Admin,Qualidade');
    Route::get('/admin/qualidade/medidas', 'Admin\QualidadeController@medidas')->middleware('auth.tipo:Admin,Qualidade');
    Route::resource('/admin/qualidade', 'Admin\RastreabilidadeController')->middleware('auth.tipo:Admin,Qualidade');

    //Rotas de Produto_Cliente
    Route::get('autocompleteCodigoProdCli','Admin\Produto_ClienteController@autocompleteCodigoProdCli');
    Route::resource('/admin/produto_cliente', 'Admin\Produto_ClienteController')->middleware('auth.tipo:Admin,Secretaria');

    //Rotas de Produto_Fornecedor
    Route::get('autocompleteCodigoProdForne','Admin\Produto_FornecedorController@autocompleteCodigoProdForne');
    Route::resource('/admin/produto_fornecedor', 'Admin\Produto_FornecedorController')->middleware('auth.tipo:Admin,Secretaria');

    //Rotas NFe
    Route::get('/admin/nfe/finalizarNfe','Admin\NfeController@finalizarNfe')->name('nfe.finalizarNfe')->middleware('auth.tipo:Admin,Secretaria');
    Route::post('/admin/nfe/addParcela','Admin\NfeController@addParcela')->name('nfe.addParcela')->middleware('auth.tipo:Admin,Secretaria');
    //--NFe form passo 1
    Route::get('/admin/nfe/emitirPasso1', 'Admin\NfeController@emitir1')->name('nfe.emitirPasso1')->middleware('auth.tipo:Admin,Secretaria');
    Route::post('/admin/nfe/postEmitirPasso1', 'Admin\NfeController@postEmitir1')->name('nfe.postEmitirPasso1')->middleware('auth.tipo:Admin,Secretaria');
    //--NFe form passo 2
    Route::get('/admin/nfe/emitirPasso2', 'Admin\NfeController@emitir2')->name('nfe.emitirPasso2')->middleware('auth.tipo:Admin,Secretaria');
    Route::post('/admin/nfe/postEmitirPasso2', 'Admin\NfeController@postEmitir2')->name('nfe.postEmitirPasso2')->middleware('auth.tipo:Admin,Secretaria');
    //--NFe form passo 3
    Route::get('/admin/nfe/emitirPasso3', 'Admin\NfeController@emitir3')->name('nfe.emitirPasso3')->middleware('auth.tipo:Admin,Secretaria');
    Route::post('/admin/nfe/postEmitirPasso3', 'Admin\NfeController@postEmitir3')->name('nfe.postEmitirPasso3')->middleware('auth.tipo:Admin,Secretaria');
    //--NFe mail
    Route::post('/admin/nfe/enviarEmail', 'Admin\NfeController@enviarEmail')->name('nfe.enviarEmail')->middleware('auth.tipo:Admin,Secretaria');

    Route::get('autocompleteCodigoProdNfe','Admin\NfeController@autocompleteCodigoProdNfe');
    
    //--Carta Correcao Nfe
    Route::post('/admin/nfe/correcao','Admin\NfeController@cartaCorrecao')->name('nfe.cartaCorrecao')->middleware('auth.tipo:Admin,Secretaria');

    //--Cancelar Nfe
    Route::post('/admin/nfe/cancelar','Admin\NfeController@cancelar')->name('nfe.cancelar')->middleware('auth.tipo:Admin,Secretaria');
    
    /* Rotas de Inutilização de NFe
    Route::get('/admin/nfe/inutilizarShow','Admin\NfeController@inutilizarShow')->middleware('auth.tipo:Admin');
    Route::post('/admin/nfe/inutilizar','Admin\NfeController@inutilizar')->name('nfe.inutilizar')->middleware('auth.tipo:Admin');
    */

    Route::resource('/admin/nfe', 'Admin\NfeController')->middleware('auth.tipo:Admin,Secretaria');

    //Rotas orçamento
    Route::get('/admin/orcamento/mostrar','Admin\OrcamentoController@mostrar')->name('orcamento.mostrar')->middleware('auth.tipo:Admin,Secretaria');
    Route::post('/admin/orcamento/adicionar','Admin\OrcamentoController@adicionar')->name('orcamento.adicionar')->middleware('auth.tipo:Admin,Secretaria');
    Route::get('/admin/orcamento/mostrarPronto/{cod_orcamento}','Admin\OrcamentoController@mostrarPronto')->name('orcamento.mostrarPronto')->middleware('auth.tipo:Admin,Secretaria');
    Route::resource('/admin/orcamento', 'Admin\OrcamentoController')->middleware('auth.tipo:Admin,Secretaria');

    //Rotas Pedido de compra
    Route::get('/admin/pedidoCompra/mostrar','Admin\PedidoCompraController@mostrar')->name('pedidoCompra.mostrar')->middleware('auth.tipo:Admin,Secretaria');
    Route::post('/admin/pedidoCompra/adicionar','Admin\PedidoCompraController@adicionar')->name('pedidoCompra.adicionar')->middleware('auth.tipo:Admin,Secretaria');
    Route::get('/admin/pedidoCompra/mostrarPronto/{cod_pedidoCompra}','Admin\PedidoCompraController@mostrarPronto')->name('pedidoCompra.mostrarPronto')->middleware('auth.tipo:Admin,Secretaria');
    Route::resource('/admin/pedidoCompra', 'Admin\PedidoCompraController')->middleware('auth.tipo:Admin,Secretaria');

});

