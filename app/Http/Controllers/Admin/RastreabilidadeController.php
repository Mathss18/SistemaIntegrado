<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\rastreabilidade;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class RastreabilidadeController extends Controller
{

    public function index()
    {
        $lacres = new rastreabilidade();
        $lacres = DB::table('rastreabilidade as r')->join('cliente as c','r.cliente','=','c.ID_cliente')->select('r.ID_rastreabilidade','r.lacre','r.cor', 'r.codigo', 'r.data', 'r.nota','c.nome','r.qtde')->get();
        foreach ($lacres as $lacre) {
            $lacre->data = date('d/m/Y', strtotime($lacre->data));
        }
        return view('admin.rastreabilidade.index',compact('lacres'));
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

    public function info(){
        $hoje = date('Y-m-d');
        return view('admin.rastreabilidade.info',compact('hoje'));
    }

    public function armazenarInfoSeccion(Request $request){

        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        //dd($dataFormCli);
        $cor = $dataFormCli['cor'];
        $codigo = $dataFormCli['codigo'];
        $nota = $dataFormCli['nota'];
        $cliente = $dataFormCli['cliente'];
        $nomeCliente = $dataFormCli['nomeCliente'];
        $qtde = $dataFormCli['qtde'];
        $data = $dataFormCli['data'];
        

        $request->session()->put('RastreCor',$cor);
        $request->session()->put('RastreCodigo',$codigo);
        $request->session()->put('RastreNota',$nota);
        $request->session()->put('RastreCliente',$cliente);
        $request->session()->put('RastreNomeCliente',$nomeCliente);
        $request->session()->put('RastreQtde',$qtde);
        $request->session()->put('RastreData',$data);
            
        return redirect('admin/rastreabilidade/cadastrar');
    }
    public function cadastrar(){
        $qtde = Session::get('RastreQtde');
        $cor = Session::get('RastreCor');

        $arr = explode(' ',trim($cor));
        $prefixo = '';

        switch ($arr[0]) {
            case 'Amarela':
                $cor = 'orange';
                $prefixo = 'am';
                break;
            case 'Vermelha':
                $cor = 'red';
                $prefixo = 'vm';
                break;
            case 'Azul':
                $cor = 'blue';
                $prefixo = 'az';
                break;
            case 'Verde':
                $cor = 'green';
                $prefixo = 'vd';
                break;
            case 'Branca':
                $cor = 'grey';
                $prefixo = 'br';
                break;
            case 'Preta':
                $cor = 'black';
                $prefixo = 'pr';
                break;
                case 'Marrom':
                    $cor = 'brown';
                    $prefixo = 'mr';
                    break;
            default:
                $cor = 'black';
                $prefixo = 'ot';
                break;
        }

        return view('admin.rastreabilidade.cadastrar',compact('qtde','cor','prefixo'));
    }

    public function cadastrarLacres(Request $request){

        $lacreFinal = new rastreabilidade();

        $codigo = Session::get('RastreCodigo');
        $cor = Session::get('RastreCor');
        $nota = Session::get('RastreNota');
        $cliente = Session::get('RastreCliente');
        $data = Session::get('RastreData');
        $qtde = Session::get('RastreQtde');

        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        $lacres = $dataFormCli['lacre'];
        $prefixo = $dataFormCli['prefixo'];
        $lacrePrefixo = [];

        foreach ($lacres as $lacre1) {
            array_push($lacrePrefixo,$prefixo.$lacre1);
        }

        foreach ($lacrePrefixo as $lacre) {
            $salvaLacre = new rastreabilidade();
            $dataFormCli['codigo'] = $codigo;
            $dataFormCli['cor'] = $cor;
            $dataFormCli['nota'] = $nota;
            $dataFormCli['cliente'] = $cliente;
            $dataFormCli['data'] = $data;
            $dataFormCli['qtde'] = $qtde;
            $dataFormCli['lacre'] = $lacre;
            $salvaLacre->create($dataFormCli);
        }
        return redirect('admin/rastreabilidade')->with('success', 'Lacres Cadastrados Com Sucesso!');
    }
}
