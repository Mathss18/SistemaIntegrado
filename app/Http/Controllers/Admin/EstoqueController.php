<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\entrada_produto;
use App\Models\Produto;
use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Debugbar;
use DateTime;
use Auth;


class EstoqueController extends Controller
{

    public function index()
    {
        $titulo = 'Gestão de Produtos';
        $firma = Auth::user()->firma;
        $estoques = collect();
        if($firma == 'FM'){
            $estoques = DB::table('estoque as e')->join('produto_fornecedor as p','p.ID_produto_fornecedor','=','e.ID_produtoForne')->select('p.ID_produto_fornecedor','p.descricao', 'e.qtde', 'p.grupo', 'e.valor_unitario')->where('p.firma','FM')->get();
            return view('admin.estoque.index',compact('titulo','estoques','firma'));
        }
        else{
            $estoques = DB::table('estoque as e')->join('produto_fornecedor as p','p.ID_produto_fornecedor','=','e.ID_produtoForne')->select('p.ID_produto_fornecedor','p.descricao', 'e.qtde', 'p.grupo', 'e.valor_unitario')->where('p.firma','MF')->get();
            return view('admin.estoque.index',compact('titulo','estoques','firma'));
        }
    }


    public function create()
    {
        $titulo = 'Gestão de Produtos';
        return view('admin.estoque.create-edit',compact('titulo'));
    }

  
    public function store(Request $request)
    {
        $produto = new Produto();
        $entrada_produto = new entrada_produto();
        $cad = new entrada_produto();

        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        
        $ID_prod = $produto->create($dataFormCli);

        $id = $ID_prod->getOriginal()['ID_produto'];
        

        $entrada_produto['ID_produto'] = $id;
        $entrada_produto['qtde'] = 0;
        $entrada_produto['valor_unitario'] = 0;
        $cad->create($entrada_produto->getAttributes());

        

        return redirect()->route('estoque.index')->with('success', 'Produto Cadastrado Com Sucesso!');
        ;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function desfazer(){
        $firma = Auth::user()->firma;
        $ultimo = DB::table('saida_produto')->where('firma',$firma)->orderBy('ID_saida', 'desc')->first();
        DB::table('saida_produto')->where('ID_saida', $ultimo->ID_saida)->delete();
        return redirect('admin/estoque')->with('success', 'Saída DESFEITA Com Sucesso!');
    }

    public function relatorioEntrada(){
        $firma = Auth::user()->firma;
        return view('admin.estoque.relatorioEntrada',compact('firma'));
    }

    public function relatorioSaida(){
        $firma = Auth::user()->firma;
        return view('admin.estoque.relatorioSaida',compact('firma'));
    }

    public function gerarRelatorioEntrada(Request $request){

        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        
        //Pegando as informações do form e jogando em váriaveis
        $data_inico = $request['data_inicio'];
        $data_fim = $request['data_fim'];

        //Formatando a data para mandar para a view
        $data_inicio_reform = date('d/m/Y', strtotime($data_inico));
        $data_fim_reform = date('d/m/Y', strtotime($data_fim));
        $totalGasto = 0;
        
        $dados = DB::table('entrada_produto as e')->join('produto_fornecedor as p','p.ID_produto_fornecedor','=','e.ID_produto')->join('estoque as a','a.ID_produtoForne','=','p.ID_produto_fornecedor')->select('p.descricao',DB::raw('sum(e.qtde) as quantidade_adiquirida'),'a.valor_unitario', 'e.data_entrada')->where('data_entrada','>=', $data_inico)->where('data_entrada','<=', $data_fim)->groupBy('e.data_entrada')->orderBy('p.descricao', 'ASC')->get();
        // Transforma data Americana em data Brasileira
        foreach ($dados as $dado) {
            $dado->data_entrada = date('d/m/Y H:i:s', strtotime($dado->data_entrada));
            $totalGasto = $totalGasto + $dado->quantidade_adiquirida * $dado->valor_unitario;
        }
        $totalGasto = number_format($totalGasto, 2, ',', '.');

        return view('admin.estoque.relatorioEntradaFinal',compact('dados','totalGasto','data_inicio_reform','data_fim_reform'));
        

    }

    public function gerarRelatorioSaida(Request $request){

        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        
        //Pegando as informações do form e jogando em váriaveis 
        $data_inico = $request['data_inicio'];
        $data_fim = $request['data_fim'];
        $banho = $request['banho'];

        //Formatando a data para mandar para a view
        $data_inicio_reform = date('d/m/Y', strtotime($data_inico));
        $data_fim_reform = date('d/m/Y', strtotime($data_fim));
        $totalGasto = 0;

        //Criando a Query para fazer o relátorio
        $dados = DB::table('saida_produto as e')->join('produto_fornecedor as p','p.ID_produto_fornecedor','=','e.ID_produto')->join('estoque as a','a.ID_produtoForne','=','p.ID_produto_fornecedor')->select('p.descricao',DB::raw('sum(e.qtde) as quantidade_gasta'),'a.valor_unitario', 'e.data_saida')->where('data_saida','>=', $data_inico)->where('data_saida','<=', $data_fim)->where('e.banho','LIKE', $banho)->groupBy('e.data_saida')->orderBy('p.descricao', 'ASC')->get();
        
        // Transforma data Americana em data Brasileira
        foreach ($dados as $dado) {
            $dado->data_saida = date('d/m/Y H:i:s', strtotime($dado->data_saida));
            $totalGasto = $totalGasto + $dado->quantidade_gasta * $dado->valor_unitario;
        }

        $totalGasto = number_format($totalGasto, 2, ',', '.');
        
        return view('admin.estoque.relatorioSaidaFinal',compact('dados','totalGasto','banho','data_inicio_reform','data_fim_reform'));
        

    }
}
