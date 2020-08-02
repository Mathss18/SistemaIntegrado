<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\cliente;
use App\Models\fornecedor;
use App\Models\produto_cliente;
use Illuminate\Support\Str;


class Produto_ClienteController extends Controller
{
    public function index()
    {
        $firma = Auth::user()->firma;
        $produtos = collect();
        $produtos = DB::table('produto_cliente as p')->join('cliente as c','c.ID_cliente','=','p.ID_cliente')->select('p.ID_produto_cliente','p.cod_fabricacao','p.descricao','p.preco_venda','c.nome')->where('firma',$firma)->get();
        
        return view('admin.produto_cliente.index',compact('produtos','firma'));
    }

    
    public function create()
    {
        return view('admin.produto_cliente.create-edit');
    }

    
    public function store(Request $request)
    {
        $produto_cliente = new produto_cliente();
        $usuario = Auth::user();
        $hoje = date('d/m/Y');
       
        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        $dataFormCli['path_imagem'] = Str::kebab($usuario->id.$dataFormCli['path_imagem']->getClientOriginalName());
        
        if($request->hasFile('path_imagem') && $request->file('path_imagem')->isValid()){
            //Storage::delete('file.jpg');
            $upload = $request->path_imagem->storeAs('Desenhos',$dataFormCli['path_imagem']);
            if(!$upload){
                return redirect('admin/produto_cliente')->with('error', 'Produto NÃO Aberto - Falha ao atrubir o Arquivo de Desenho!');
            }
            
        }

        $dataFormCli['firma'] = Auth::user()->firma;
        $dataFormCli['last_preco'] = $hoje;
        

        $produto_cliente->create($dataFormCli);
        return redirect()->route('produto_cliente.index')->with('success', 'Cadastro Realizado Com Sucesso!');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $produto = new produto_cliente();
        $produto = $produto->find($id);

        $cliente = new Cliente;
        $cliente = $cliente->find($produto->ID_cliente);
        $cliente = $cliente->getOriginal();
        return view('admin.produto_cliente.create-edit',compact('produto','cliente'));
    }

    
    public function update(Request $request, $id)
    {
        $produto = new produto_cliente();
        $usuario = Auth::user();
        $hoje = date('d/m/Y');

        $dataFormCli = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        $dataFormCli['path_imagem'] = Str::kebab($usuario->id.$dataFormCli['path_imagem']->getClientOriginalName());
        
        if($request->hasFile('path_imagem') && $request->file('path_imagem')->isValid()){
            //Storage::delete('file.jpg');
            $upload = $request->path_imagem->storeAs('Desenhos',$dataFormCli['path_imagem']);
            if(!$upload){
                return redirect('admin/produto_cliente')->with('error', 'Produto NÃO Aberto - Falha ao atrubir o Arquivo de Desenho!');
            }
            
        }
        
        $produto = $produto->find($id);
        //Atualiza data lasp_preco
        if($produto->preco_venda != $dataFormCli['preco_venda']){
            $dataFormCli['last_preco'] = $hoje;
        }
        $produto->update($dataFormCli);
        return redirect()->route('produto_cliente.index')->with('success', 'Cadastro Atualizado Com Sucesso!');
    }

    
    public function destroy($id)
    {
        //
    }

    public function autocompleteCodigoProdCli(Request $request){

        $firma = Auth::user()->firma;
        $produto_cliente = 
        produto_cliente::select(DB::raw('concat(cod_fabricacao) as text, path_imagem as value'))
                    ->where("cod_fabricacao","LIKE","%{$request->input('query')}%")->where("firma",$firma)
                    ->get();
        return response()->json($produto_cliente);
        }
}
