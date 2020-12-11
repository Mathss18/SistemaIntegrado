<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\faturamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Session;
use Auth;

class FaturamentoController extends Controller
{

    public function index()
    {
        //
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

    public function data(){
        return view('admin.faturamento.data');
    }

    public function armazenarDataSeccion(Request $request){

        $dataFormCli = $request->except([
            '_token',
            '_method',
            
        ]);
        
        $dataInicio = $dataFormCli['data_inicio'];
        $dataFim = $dataFormCli['data_fim'];

        $request->session()->put('dataInicio',$dataInicio);
        $request->session()->put('dataFim',$dataFim);
            
        if($dataFormCli['submit'] == 'faturamento')
            return redirect('admin/faturamento/faturamentoFM');
        else
            return redirect('admin/faturamento/relatorio');
    }

    public function faturamentoFM(){
        if(Session::has('dataInicio')){
            $dataInicio = Session::get('dataInicio');
            $dataFim = Session::get('dataFim');
            $firma = Auth::user()->firma;

            //VERIFICA DE QUAL FIRMA VAI SER O FATURAMENTO
                $faturamentos = DB::table('faturamento as f')->join('cliente as c','f.cliente','=','c.ID_cliente')
                ->select('f.ID_faturamento','f.vale','f.nfe', 'f.situacao','f.status', 'c.nome', 'f.peso','f.valor','c.ID_Cliente')
                ->where('f.firma','LIKE',$firma)
                ->where('f.data', '>=', $dataInicio)
                ->where('f.data', '<=', $dataFim)
                ->get();
                return view('admin.faturamento.faturamento',compact('faturamentos','firma'));
            
            
        }
        else{
            return redirect('admin/faturamento/data')->with('message', 'Login Failed');
        }
        

        
    }

    public function acao(Request $request){
        $dataFormCli = $request->except([
            '_token',
            '_method',
        ]);
        $opcao = $dataFormCli['submit'];
        $idFaturamento = $dataFormCli['ID_faturamento'];
        $dataFormCli['firma'] = Auth::user()->firma; //MODIFICAR USER->FIRMA
    
        if($opcao == 'inserir'){
            $faturamento = new faturamento();
            $faturamento->create($dataFormCli);
            return redirect()->back()->with('success', 'Inserido Com Sucesso!');
        }
        elseif($opcao == 'editar'){
            $faturamento = new faturamento();
            $faturamento = $faturamento->find($idFaturamento);
            $faturamento->update($request->all());
            return redirect()->back()->with('success', 'Editado Com Sucesso!');
        }
        elseif($opcao == 'excluir'){
            $faturamento = new faturamento();
            $faturamento = $faturamento->find($idFaturamento);
            $faturamento->destroy($idFaturamento);
            return redirect()->back()->with('success', 'Excluido Com Sucesso!');
        }
    }

    public function relatorio()
    {
        if (Session::has('dataInicio')) {
            $firma = Auth::user()->firma;
            $dataInicio = Session::get('dataInicio');
            $dataFim = Session::get('dataFim');
        
            //Formatando a data para mandar para a view
            $data_inicio_reform = date('d/m/Y', strtotime($dataInicio));
            $data_fim_reform = date('d/m/Y', strtotime($dataFim));

            if($firma == 'FM')
                $nomeFimra = 'Flex-Mol';
            else
                $nomeFimra = 'Metal-Flex';

            //Faturamento Total
            $faturamentoTotal = DB::table('faturamento as f')->select(DB::raw('sum(f.valor) as total'))->where('f.firma', 'LIKE', $firma)->where('f.data', '>=', $dataInicio)->where('f.data', '<=', $dataFim)->get();
        
            //Faturamento em Aberto
            $faturamentoAberto = DB::table('faturamento as f')->select(DB::raw('sum(f.valor) as aberto' ))->where('f.firma', 'LIKE', $firma)->where('f.situacao','=','Aberto')->where('f.data', '>=', $dataInicio)->where('f.data', '<=', $dataFim)->get();
        
            //Peso Total
            $faturamentoPeso = DB::table('faturamento as f')->select(DB::raw('sum(f.peso) as peso'))->where('f.firma', 'LIKE', $firma)->where('f.data', '>=', $dataInicio)->where('f.data', '<=', $dataFim)->get();
            
            //Melhor Cliente
            $faturamentoClientes = DB::table('faturamento as f')->join('cliente as c', 'f.cliente', '=', 'c.ID_cliente')->select(DB::raw('sum(f.valor) as valor'),'c.nome')->where('f.firma', 'LIKE', $firma)->where('f.data', '>=', $dataInicio)->where('f.data', '<=', $dataFim)->groupBy('c.nome')->orderBy('valor','desc')->get();
            
            
            //Formatando os Valores para PT_BR
            $faturamentoTotal[0]->total = number_format($faturamentoTotal[0]->total, 2, ',', '.');

            $faturamentoAberto[0]->aberto = number_format($faturamentoAberto[0]->aberto, 2, ',', '.');

            $faturamentoPeso[0]->peso = number_format($faturamentoPeso[0]->peso, 2, ',', '.');

            foreach ($faturamentoClientes as $fc) {

               $fc->valor = number_format($fc->valor, 2, ',', '.');
            }



            return view('admin.faturamento.relatorio', compact('faturamentoTotal','faturamentoAberto','faturamentoPeso','faturamentoClientes','data_inicio_reform','data_fim_reform','nomeFimra'));
        }
        else {
            return redirect('admin/faturamento/data')->with('message', 'Login Failed');
        }
    }
}
