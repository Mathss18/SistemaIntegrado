<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\fornecedor;
use App\Models\produto_fornecedor;
use Illuminate\Support\Str;

class Produto_FornecedorController extends Controller
{
    public function index()
    {
        $firma = Auth::user()->firma;
        $produtos = collect();
        $produtos = DB::table('produto_fornecedor as p')->join('fornecedor as f','f.ID_fornecedor','=','p.ID_fornecedor')->select('p.ID_produto_fornecedor','p.cod_fabricacao','p.descricao','p.preco_venda','f.nome')->where('p.firma',$firma)->get();
        
        return view('admin.produto_fornecedor.index',compact('produtos','firma'));
    }

    
    public function create()
    {
        return view('admin.produto_fornecedor.create-edit');
    }

    
    public function store(Request $request)
    {
        $produto_fornecedor = new produto_fornecedor();
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
                return redirect('admin/produto_fornecedor')->with('error', 'Produto NÃO Aberto - Falha ao atrubir o Arquivo de Desenho!');
            }
            
        }

        $dataFormCli['firma'] = Auth::user()->firma;
        $dataFormCli['last_preco'] = $hoje;
        

        $produto_fornecedor->create($dataFormCli);
        return redirect()->route('produto_fornecedor.index')->with('success', 'Cadastro Realizado Com Sucesso!');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $produto = new produto_fornecedor();
        $produto = $produto->find($id);

        $fornecedor = new fornecedor();
        $fornecedor = $fornecedor->find($produto->ID_fornecedor);
        $fornecedor = $fornecedor->getOriginal();
        return view('admin.produto_fornecedor.create-edit',compact('produto','fornecedor'));
    }

    
    public function update(Request $request, $id)
    {
        $produto = new produto_fornecedor();
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
                return redirect('admin/produto_fornecedor')->with('error', 'Produto NÃO Aberto - Falha ao atrubir o Arquivo de Desenho!');
            }
            
        }
        
        $produto = $produto->find($id);
        //Atualiza data lasp_preco
        if($produto->preco_venda != $dataFormCli['preco_venda']){
            $dataFormCli['last_preco'] = $hoje;
        }
        $produto->update($dataFormCli);
        return redirect()->route('produto_fornecedor.index')->with('success', 'Cadastro Atualizado Com Sucesso!');
    }

    
    public function destroy($id)
    {
        //
    }

    public function autocompleteCodigoProdForne(Request $request){

        $firma = Auth::user()->firma;
        $produto_fornecedor = 
        produto_fornecedor::select(DB::raw('concat(cod_fabricacao) as text, path_imagem as value, ID_produto_fornecedor as ID_produto_fornecedor'))
                    ->where("cod_fabricacao","LIKE","%{$request->input('query')}%")->where("firma",$firma)
                    ->get();
        return response()->json($produto_fornecedor);
        }

}
