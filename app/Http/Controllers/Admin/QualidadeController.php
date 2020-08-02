<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\qualidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class QualidadeController extends Controller
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

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }

    public function data(){
        return view('admin.qualidade.data');
    }
    
    public function armazenarDataSeccion(Request $request){
        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        $QualiDataInicio = $dataFormCli['data_inicio'];
        $QualiDataFim = $dataFormCli['data_fim'];

        $request->session()->put('QualiDataInicio',$QualiDataInicio);
        $request->session()->put('QualiDataFim',$QualiDataFim);

        return redirect('admin/qualidade/medidas');
    }
    public function medidas(){
        if(Session::has('QualiDataInicio')){
            $dataInicio = Session::get('QualiDataInicio');
            $dataFim = Session::get('QualiDataFim');
            $hoje = date('Y-m-d');
            $medidas = DB::table('qualidade as q')->join('cliente as c','q.cliente','=','c.ID_cliente')->select('q.ID_qualidade','q.of','q.codigo','q.acabamento','q.abertura', 'q.arame', 'q.interno','q.externo','q.passo','q.lo_corpo','q.lo_total','q.espiras','q.data','q.sobra','q.qtde','q.obs','c.ID_cliente','c.nome')->where('q.data', '>=', $dataInicio)->where('q.data', '<=', $dataFim)->get();
            
            return view('admin.qualidade.medidasMolas',compact('medidas','hoje'));
        }
        else{
            return redirect('admin/qualidade/data');
        }
    }

    public function acao(Request $request){
        $dataFormCli = $request->except([
            '_token',
            '_method',
        ]);
        $opcao = $dataFormCli['submit'];
        $idQualidade = $dataFormCli['ID_qualidade'];
    
        if($opcao == 'inserir'){
            $medidas = new qualidade();
            $medidas->create($dataFormCli);
            return redirect()->back()->with('success', 'Inserido Com Sucesso!');
        }
        elseif($opcao == 'editar'){
            $medidas = new qualidade();
            $medidas = $medidas->find($idQualidade);
            $medidas->update($request->all());
            return redirect()->back()->with('success', 'Editado Com Sucesso!');
        }
        elseif($opcao == 'excluir'){
            $medidas = new qualidade();
            $medidas = $medidas->find($idQualidade);
            $medidas->destroy($idQualidade);
            return redirect()->back()->with('success', 'Excluido Com Sucesso!');
        }
    }

    
}
