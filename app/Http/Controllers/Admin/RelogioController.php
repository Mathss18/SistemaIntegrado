<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\relogio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class RelogioController extends Controller
{
   
    public function index()
    {
        $titulo = 'Gestão de Relógios';
        $relogios = new relogio();
        $relogios = $relogios->all();
        return view('admin.relogio.index',compact('titulo','relogios'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        
        $relogio = new relogio();
       
        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        
        $relogio->create($dataFormCli);
        return redirect()->route('relogio.index')->with('success', 'Entrada Realizada Com Sucesso!');
        
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

    public function editar(Request $request)
    {   
        $dataFormCli = $request->except([
            '_token',
            '_method',
        ]);

        $idRelogio = $dataFormCli['ID_relogio'];
        $opcao = $dataFormCli['submit'];
    
        if($opcao == 'editar'){
            $relogio = new relogio();
            $relogio = $relogio->find($idRelogio);
            $relogio->update($request->all());
            return redirect()->back()->with('success', 'Valores Editados Com Sucesso!');
        }
        elseif($opcao == 'excluir'){
            $relogio = new relogio();
            $relogio = $relogio->find($idRelogio);
            $relogio->destroy($idRelogio);
            return redirect()->back()->with('success', 'Valores Excluidos Com Sucesso!');;
        }


        
        return redirect('admin/relogio/relatorio');
    }

    public function excluir(Request $request)
    {
        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        $id = $dataFormCli['ID_produto'];

        $relogio = new relogio();
        $relogio = $relogio->find($id);
        $relogio->destroy($id);
        return redirect('admin/relogio/relatorio');
    }
    
    public function destroy($id)
    {
        //
    }

    public function relatorio(){
        return view('admin.relogio.relatorio');
    }

    public function armazenarDataSeccionRelogio(Request $request){

        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        $dataInicio = $dataFormCli['data_inicio'];
        $dataFim = $dataFormCli['data_fim'];

        $request->session()->put('dataInicioRelogio',$dataInicio);
        $request->session()->put('dataFimRelogio',$dataFim);
            
        return redirect('admin/relogio/relatorio2');
    }

    public function relatorio2(){
        if(Session::has('dataInicioRelogio')){
            $dataInicio = Session::get('dataInicioRelogio');
            $dataFim = Session::get('dataFimRelogio');
            $relogios = new relogio();
            $relogios2 = new relogio();
            $relogios = DB::table('relogio as r')->select('r.ID_relogio','r.inicio','r.fim', 'r.data')->where('status', 'r1')->where('data', '>=', $dataInicio)->where('data', '<=', $dataFim)->orderBy('r.data', 'desc')->get();
            $relogios2 = DB::table('relogio as r')->select('r.ID_relogio','r.inicio','r.fim', 'r.data')->where('status', 'r2')->where('data', '>=', $dataInicio)->where('data', '<=', $dataFim)->orderBy('r.data', 'desc')->get();


            foreach ($relogios as $relogio1) {
                $relogio1->data = date('d/m/Y', strtotime($relogio1->data));
            }
        

            foreach ($relogios2 as $relogio2) {
                $relogio2->data = date('d/m/Y', strtotime($relogio2->data));
            }

            return view('admin.relogio.fechado',compact('relogios','relogios2'));
        }
        else{

        }
    }
}
