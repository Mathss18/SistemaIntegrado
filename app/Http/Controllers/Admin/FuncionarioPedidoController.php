<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cliente;
use App\Models\funcionario_pedido;
use App\Models\pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use PhpParser\Node\Expr\FuncCall;
Use Redirect;
use Session;

class FuncionarioPedidoController extends Controller
{
    public function index()
    {
        $nomeFuncionario = Auth::user()->name;
        $funcionarioPedido = new funcionario_pedido();
        $funcionarioPedido = DB::table('funcionario_pedido as fp')->join('funcionario as f','f.ID_funcionario','=','fp.ID_funcionario')->join('pedido as p','p.ID_pedido','=','fp.ID_pedido')->select('fp.ID_funcionario_pedido','p.OF','p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade','p.tipo','p.ID_cliente','p.path_desenho')->where('f.nome','=',$nomeFuncionario)->where('fp.status', '=', 'Aberto')->get();
        
        $nivelDB = DB::table('funcionario as f')->select('f.nivel')->where('f.nome','=',$nomeFuncionario)->get();
        $nivelFunc = $nivelDB[0]->nivel;

        foreach ($funcionarioPedido as $fp) {
            $cliente = new cliente();
            $cliente = $cliente->find($fp->ID_cliente);
            $fp->cliente = $cliente->nome;
        }

        foreach ($funcionarioPedido as $fp) {
            $fp->data_pedido = date('d/m/Y', strtotime($fp->data_pedido));
            $fp->data_entrega = date('d/m/Y', strtotime($fp->data_entrega));
        }
        return view('admin.funcionario_pedido.index',compact('funcionarioPedido','nivelFunc'));
    }


    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        //
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
    
    public function baixa(Request $request){
        

        $dataFormCli = $request->except([
            '_token',
            '_method',
        ]);
        $id = $dataFormCli['ID_funcionario_pedido'];
        $hoje = date('Y-m-d');

        $funcionarioPedido = new funcionario_pedido();
        $funcionarioPedido = $funcionarioPedido->find($id);
        $funcionarioPedido->data_baixa = $hoje;
        $funcionarioPedido->update($request->all());

        $idPedido = $funcionarioPedido->ID_pedido;

        $contadorPedidosAbertos = new funcionario_pedido();
        $contadorPedidosAbertos = DB::table('funcionario_pedido as fp')->join('funcionario as f','f.ID_funcionario','=','fp.ID_funcionario')->join('pedido as p','p.ID_pedido','=','fp.ID_pedido')->select('fp.ID_funcionario_pedido','f.ID_funcionario')->where('fp.status', '=', 'Aberto')->where('fp.ID_pedido', '=', $idPedido)->get();
        $contadorPedidosAbertos = $contadorPedidosAbertos->toArray();
        $restante = sizeof($contadorPedidosAbertos);

        if($restante <= 0 ){
            //Fechando Pedido quando todos os Funcionarios derem baixa
            DB::table('pedido')->where('ID_pedido', $idPedido)->update(['status' => 'Fechado']);
        }
        return Redirect::back()->with('success', 'Baixa Realizada Com Sucesso!');   
        

    }

    public function data(){
        return view('admin.funcionario_pedido.data');
    }

    public function armazenarDataSeccion(Request $request){

        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        $dataInicio = $dataFormCli['data_inicio'];
        $dataFim = $dataFormCli['data_fim'];

        $request->session()->put('dataInicioMeuRelatorio',$dataInicio);
        $request->session()->put('dataFimMeuRelatorio',$dataFim);
            
        return redirect('admin/funcionarioPedido/relatorio');
    }

    public function relatorio(){
        if(Session::has('dataInicioMeuRelatorio')){
            $dataInicio = Session::get('dataInicioMeuRelatorio');
            $dataFim = Session::get('dataFimMeuRelatorio');
            $nomeFuncionario = Auth::user()->name; 

            $todosPedidos = new funcionario_pedido();
            $hoje = date('Y-m-d');


            //Formatando a data para mandar para a view
            $data_inicio_reform = date('d/m/Y', strtotime($dataInicio));
            $data_fim_reform = date('d/m/Y', strtotime($dataFim));

            $todosPedidos = DB::table('funcionario_pedido as fp')->join('funcionario as f','f.ID_funcionario','=','fp.ID_funcionario')->join('pedido as p','p.ID_pedido','=','fp.ID_pedido')->join('cliente as c','c.ID_cliente','=','fp.ID_cliente')->select('fp.ID_funcionario_pedido','p.OF','p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade','p.tipo','p.ID_cliente','c.nome')->where('f.nome','=',$nomeFuncionario)->where('fp.data_controle', '>=', $dataInicio)->where('fp.data_controle', '<=', $dataFim)->orderBy('fp.ID_funcionario_pedido', 'desc')->get();
            $pedidosAbertosAtrasados = DB::table('funcionario_pedido as fp')->join('funcionario as f','f.ID_funcionario','=','fp.ID_funcionario')->join('pedido as p','p.ID_pedido','=','fp.ID_pedido')->join('cliente as c','c.ID_cliente','=','fp.ID_cliente')->select('fp.ID_funcionario_pedido','p.OF','p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade','p.tipo','p.ID_cliente','fp.data_controle','fp.data_baixa','c.nome')->where('f.nome','=',$nomeFuncionario)->where('fp.data_controle', '>=', $dataInicio)->where('fp.data_controle', '<=', $dataFim)->where('p.data_entrega', '<=', $hoje)->where('fp.status', '=', 'Aberto')->orderBy('fp.ID_funcionario_pedido', 'desc')->get();
            $pedidosFechadosAtrasados = DB::table('funcionario_pedido as fp')->join('funcionario as f','f.ID_funcionario','=','fp.ID_funcionario')->join('pedido as p','p.ID_pedido','=','fp.ID_pedido')->join('cliente as c','c.ID_cliente','=','fp.ID_cliente')->select('fp.ID_funcionario_pedido','p.OF','p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade','p.tipo','p.ID_cliente','fp.data_controle','fp.data_baixa','c.nome')->where('f.nome','=',$nomeFuncionario)->where('fp.data_controle', '>=', $dataInicio)->where('fp.data_controle', '<=', $dataFim)->whereRaw('fp.data_baixa > p.data_entrega')->where('fp.status', '=', 'Fechado')->orderBy('fp.ID_funcionario_pedido', 'desc')->get();
            $pedidosFechadosAdiantados = DB::table('funcionario_pedido as fp')->join('funcionario as f','f.ID_funcionario','=','fp.ID_funcionario')->join('pedido as p','p.ID_pedido','=','fp.ID_pedido')->join('cliente as c','c.ID_cliente','=','fp.ID_cliente')->select('fp.ID_funcionario_pedido','p.OF','p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade','p.tipo','p.ID_cliente','fp.data_controle','fp.data_baixa','c.nome')->where('f.nome','=',$nomeFuncionario)->where('fp.data_controle', '>=', $dataInicio)->where('fp.data_controle', '<=', $dataFim)->whereRaw('fp.data_baixa <= p.data_entrega')->where('fp.status', '=', 'Fechado')->orderBy('fp.ID_funcionario_pedido', 'desc')->get();

            $porCentoPaa = $pedidosAbertosAtrasados->count();
           foreach ($pedidosAbertosAtrasados as $paa) {
                //Calculando os dias de atraso
                $hoje = date('Y-m-d');
                $paa->data_controle = $hoje;
                $paa->diferenca = strtotime($paa->data_controle) - strtotime($paa->data_entrega);
                $paa->diferenca = floor($paa->diferenca / (60 * 60 * 24));
                //Formatando a data para padrão BR
                $paa->data_pedido = date('d/m/Y', strtotime($paa->data_pedido));
                $paa->data_entrega = date('d/m/Y', strtotime($paa->data_entrega));
                $paa->data_controle = date('d/m/Y', strtotime($paa->data_controle));
           }

           $porCentoPfa = $pedidosFechadosAtrasados->count();
           foreach ($pedidosFechadosAtrasados as $pfa) {
                //Calculando os dias de atraso
                $pfa->diferenca = strtotime($pfa->data_baixa) - strtotime($pfa->data_entrega);
                $pfa->diferenca = floor($pfa->diferenca / (60 * 60 * 24));
                //Formatando a data para padrão BR
                $pfa->data_pedido = date('d/m/Y', strtotime($pfa->data_pedido));
                $pfa->data_entrega = date('d/m/Y', strtotime($pfa->data_entrega));
                $pfa->data_baixa = date('d/m/Y', strtotime($pfa->data_baixa));
            }

            $porCentoPfad = $pedidosFechadosAdiantados->count();
            foreach ($pedidosFechadosAdiantados as $pfa) {
                //Calculando os dias de atraso
                $pfa->diferenca = strtotime($pfa->data_baixa) - strtotime($pfa->data_entrega);
                $pfa->diferenca = abs(floor($pfa->diferenca / (60 * 60 * 24)));
                //Formatando a data para padrão BR
                $pfa->data_pedido = date('d/m/Y', strtotime($pfa->data_pedido));
                $pfa->data_entrega = date('d/m/Y', strtotime($pfa->data_entrega));
                $pfa->data_baixa = date('d/m/Y', strtotime($pfa->data_baixa));
            }

            $totalPorCento = $porCentoPaa+$porCentoPfa+$porCentoPfad;
            if($totalPorCento == 0){
                $totalPorCento = 1;
            }
            $aproveitamento = (($totalPorCento-$porCentoPaa-$porCentoPfa)*100)/$totalPorCento;
            $aproveitamento = number_format($aproveitamento,2);
            return view('admin.funcionario_pedido.relatorio',compact('pedidosAbertosAtrasados','pedidosFechadosAtrasados','pedidosFechadosAdiantados','data_inicio_reform','data_fim_reform','nomeFuncionario','aproveitamento'));
            

            
        }
        else{
            return redirect('admin/funcionarioPedido/data');
        }
    }
}
