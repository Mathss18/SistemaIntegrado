<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Funcionario;
use App\Models\funcionario_pedido;
use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;



class PedidoController extends Controller
{
    
    public function index()
    {
        $titulo = 'Gestão de Pedidos';
        $pedidos = new Pedido();
        $pedidos = Pedido::orderBy('ID_pedido', 'desc')->get();
        return view('admin.pedido.index',compact('titulo','pedidos'));
    }

    public function pedidosAbertos()
    {
        $firma = Auth::user()->firma;
        $titulo = 'Gestão de Pedidos';
        $pedidos = new Pedido();
        $pedidos = DB::table('pedido as p')->join('cliente as c','p.ID_cliente','=','c.ID_cliente')->select('p.ID_pedido','p.OF','p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade','p.tipo','c.nome')->where('status', 'Aberto')->where('firma', $firma)->orderBy('ID_pedido', 'desc')->get();
        foreach ($pedidos as $pedido) {
            $pedido->data_pedido = date('d/m/Y', strtotime($pedido->data_pedido));
            $pedido->data_entrega = date('d/m/Y', strtotime($pedido->data_entrega));
        }
        return view('admin.pedido.indexAberto',compact('titulo','pedidos'));
    }
    public function pedidosFechados()
    {
        $firma = Auth::user()->firma;
        $titulo = 'Gestão de Pedidos';
        $pedidos = new Pedido();
        $pedidos = DB::table('pedido as p')->join('cliente as c','p.ID_cliente','=','c.ID_cliente')->select('p.ID_pedido','p.OF','p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade','p.tipo','c.nome')->where('status', 'Fechado')->where('firma', $firma)->orderBy('ID_pedido', 'desc')->get();
        foreach ($pedidos as $pedido) {
            $pedido->data_pedido = date('d/m/Y', strtotime($pedido->data_pedido));
            $pedido->data_entrega = date('d/m/Y', strtotime($pedido->data_entrega));
        }
        return view('admin.pedido.indexFechado',compact('titulo','pedidos'));
    }

    
    public function create()
    {
        $firma = Auth::user()->firma;
        $token = hexdec(uniqid());  
        $pedacoToken = substr($token, -6);
        $ano = date("y");
        $mes = date("m");
        $dia = date("d");

        $codigo = DB::table('pedido')->where('firma',$firma)->orderBy('ID_pedido', 'desc')->first();
        $codigo = $codigo->OF+1;
        //$codigo = strtoupper($pedacoToken.'-'.$firma.$dia.$mes.$ano);
        
        $hoje = date('Y-m-d');
        $titulo = 'Gestão de Pedidos';
        $funcionarios = new Funcionario;
        $funcionarios = $funcionarios->all();
        return view('admin.pedido.create-edit',compact('titulo','funcionarios','hoje','firma','codigo'));
    }

    public function aprovar(Request $request)
    {
        //PEGANDO O NUMERO DE ORÇAMENTO PARA PEGAR AS INFOS 
        $string = request()->headers->get('referer');
        $idOrcamento = explode("/", $string);

        $orcamento = DB::table('orcamento')->where('cod_orcamento',$idOrcamento[6])->get();
        //dd($orcamento);
        $idCli = $orcamento[0]->ID_cliente;
        $cliente = DB::table('cliente')->where('ID_cliente',$idCli)->get()->toArray();
        //dd($cliente[0]);
        $produtos = array();
        $produtoss = array();
        foreach ($orcamento as $key) {
            array_push($produtos,$key->ID_produto_cliente);
        }
        foreach ($produtos as $key) {
            $prod = DB::table('produto_cliente')->where('ID_produto_cliente',$key)->get();
            //dd($prod);
            array_push($produtoss,$prod[0]->cod_fabricacao);
        }
        //dd($produtoss);
        $firma = Auth::user()->firma;
        $token = hexdec(uniqid());  
        $pedacoToken = substr($token, -6);
        $ano = date("y");
        $mes = date("m");
        $dia = date("d");

        $codigo = DB::table('pedido')->orderBy('ID_pedido', 'desc')->first();
        $codigo = $codigo->OF+1;
        //$codigo = strtoupper($pedacoToken.'-'.$firma.$dia.$mes.$ano);
        
        $hoje = date('Y-m-d');
        $titulo = 'Gestão de Pedidos';
        $funcionarios = new Funcionario;
        $funcionarios = $funcionarios->all();
        //$cliente = $cliente[0];
        $cliente = json_decode(json_encode($cliente), true);
        $cliente = $cliente[0];
        return view('admin.pedido.create-edit',compact('titulo','funcionarios','hoje','firma','codigo','cliente','produtoss'));
    }
    
    public function store(Request $request)
    {
        $usuario = Auth::user();
        $firma = Auth::user()->firma;

        $pedido = new Pedido;
        
       
        $dataFormCliPedido = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        //dd($dataFormCliPedido);
        if($firma == 'MF' && $request->hasFile('path_desenho'))
        $dataFormCliPedido['path_desenho'] = Str::kebab($usuario->id.$dataFormCliPedido['path_desenho']->getClientOriginalName());
        
        
        //Adicionando o Status Padrão ao crir um Pedido que é 'Aberto'
        $dataFormCliPedido['status'] = 'Aberto';
        $dataFormCliPedido['firma'] = $firma;
        $funcionarios = $dataFormCliPedido['funcionario'];

        if($request->hasFile('path_desenho') && $request->file('path_desenho')->isValid()){
            //Storage::delete('file.jpg');
            $upload = $request->path_desenho->storeAs('Desenhos',$dataFormCliPedido['path_desenho']);
            if(!$upload){
                return redirect('admin/pedido/aberto')->with('error', 'Pedido NÃO Aberto - Falha ao atrubir o Arquivo de Desenho!');
            }
            
        }

        //Pegando o ID do pedido que acabou de ser cadastrado
        $resp = $pedido->create($dataFormCliPedido);
        $resp = $resp->getOriginal();
        $idPedido = $resp['ID_pedido'];
        $idCliente = $resp['ID_cliente'];


        //Populando a tabela Funcionario_Pedido por cada funcionário adicionado Para realizar o Pedido
        foreach ($funcionarios as $func) {
            $funcionario_pedido = new funcionario_pedido;
            $funcionario_pedido['ID_funcionario'] = $func;
            $funcionario_pedido['ID_pedido'] = $idPedido;
            $funcionario_pedido['status'] = 'Aberto';
            $funcionario_pedido['ID_cliente'] = $idCliente;
            $funcionario_pedido->create($funcionario_pedido->getAttributes());
        }
        

        return redirect('admin/pedido/aberto')->with('success', 'Pedido Aberto Com Sucesso!');
    }

    
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $pedido = new Pedido();
        $pedido = $pedido->find($id);
        $funcionarios = new Funcionario;
        $funcionarios = $funcionarios->all();
        $cliente = new Cliente;
        $cliente = $cliente->find($pedido->ID_cliente);
        $cliente = $cliente->getOriginal();
        $firma = Auth::user()->firma;
        

        //Pegas os Funcs qua ainda não deram Baixa
        $funcAberto = new funcionario_pedido();
        $funcAberto = DB::table('funcionario_pedido as fp')->join('funcionario as f','f.ID_funcionario','=','fp.ID_funcionario')->join('pedido as p','p.ID_pedido','=','fp.ID_pedido')->select('f.nome')->where('p.ID_pedido','=', $id)->where('fp.status', '=', 'Aberto')->orderBy('f.nome', 'asc')->get();
        
        
        //Colocar os Funcs na combobox
        $funcionario_pedido = new funcionario_pedido();
        $funcionario_pedido = DB::table('funcionario_pedido')->select('ID_funcionario')->where('ID_pedido',$id)->get();
        


        return view('admin.pedido.create-edit',compact('pedido','funcionarios','funcionario_pedido','cliente','funcAberto','firma'));
    }

    
    public function update(Request $request, $id)
    {
        $usuario = Auth::user();

        //Pega os funcionários
        $dataFormCliPedido = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        $funcionarios = $dataFormCliPedido['funcionario'];
        //dd($dataFormCliPedido['path_desenho']);
        if($request->hasFile('path_desenho'))
        $dataFormCliPedido['path_desenho'] = Str::kebab($usuario->id.$dataFormCliPedido['path_desenho']->getClientOriginalName());
        if($request->hasFile('path_desenho') && $request->file('path_desenho')->isValid()){
            //Storage::delete('file.jpg');
            
            $upload = $request->path_desenho->storeAs('Desenhos',$dataFormCliPedido['path_desenho']);
            if(!$upload){
                return redirect('admin/pedido/aberto')->with('error', 'Pedido NÃO Aberto - Falha ao atrubir o Arquivo de Desenho!');
            }
            
        }
        //dd($request->path_desenho);
        //Atualiza dados do Pedido
        $pedido = new Pedido();
        $pedido = $pedido->find($id);
        $pedido->update($dataFormCliPedido);

       
        $funcionario_pedido = new funcionario_pedido;
        $funcionario_pedido = DB::table('funcionario_pedido')->select('ID_funcionario')->where('ID_pedido',$id)->get();
        $funcionario_pedido = $funcionario_pedido->toArray();
        $funcionario_pedido = json_decode(json_encode($funcionario_pedido), true);
        
        //dd($funcionarios);

        $aux = Array();
            for ($i = 0; $i <= count($funcionario_pedido)-1; $i++){
                array_push($aux,$funcionario_pedido[$i]['ID_funcionario']);
            }

        if(count($funcionarios) > count($funcionario_pedido)){
            //Adicionou Funcionário
            $result = array_diff($funcionarios,$aux);

            foreach ($result as $func) {
                $funcionario_pedido = new funcionario_pedido;
                $funcionario_pedido['ID_funcionario'] = $func;
                $funcionario_pedido['ID_pedido'] = $id;
                $funcionario_pedido['status'] = 'Aberto';
                $funcionario_pedido->create($funcionario_pedido->getAttributes());
            }

        }
        elseif(count($funcionarios) < count($funcionario_pedido)){
            
            $result = array_diff($aux,$funcionarios);
            foreach ($result as $func) {
                $funcionario_pedido = new funcionario_pedido;
                $auxx = DB::table('funcionario_pedido')->select('ID_funcionario_pedido')->where('ID_pedido',$id)->where('ID_funcionario',$func)->get();
                $auxx = json_decode(json_encode($auxx), true);
                $idFunc = $auxx[0]['ID_funcionario_pedido'];
                $funcionario_pedido = $funcionario_pedido->find($idFunc);
                $funcionario_pedido->destroy($idFunc);
                
                
            }   
        }
        else{
            //Manteve 
        }

        

        
        return redirect('admin/pedido/aberto')->with('success', 'Pedido Atualizado Com Sucesso!');;;
    }

    public function destroy($id)
    {
        //
    }
    public function message(){
        return redirect('admin/pedido/aberto')->with('success', 'Pedido Aberto Com Sucesso!');
    }
    public function adicionar(Request $request)
    {
        $usuario = Auth::user();
        $firma = Auth::user()->firma;

        $pedido = new Pedido;
        
       
        $dataFormCliPedido = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        //dd($dataFormCliPedido);
        if($firma == 'MF' && $request->hasFile('path_desenho'))
        $dataFormCliPedido['path_desenho'] = Str::kebab($usuario->id.$dataFormCliPedido['path_desenho']->getClientOriginalName());
        
        
        //Adicionando o Status Padrão ao crir um Pedido que é 'Aberto'
        $dataFormCliPedido['status'] = 'Aberto';
        $dataFormCliPedido['firma'] = $firma;
        $funcionarios = $dataFormCliPedido['funcionario'];

        if($request->hasFile('path_desenho') && $request->file('path_desenho')->isValid()){
            //Storage::delete('file.jpg');
            $upload = $request->path_desenho->storeAs('Desenhos',$dataFormCliPedido['path_desenho']);
            if(!$upload){
                return redirect('admin/pedido/aberto')->with('error', 'Pedido NÃO Aberto - Falha ao atrubir o Arquivo de Desenho!');
            }
            
        }

        //Pegando o ID do pedido que acabou de ser cadastrado
        $resp = $pedido->create($dataFormCliPedido);
        $resp = $resp->getOriginal();
        $idPedido = $resp['ID_pedido'];
        $idCliente = $resp['ID_cliente'];


        //Populando a tabela Funcionario_Pedido por cada funcionário adicionado Para realizar o Pedido
        foreach ($funcionarios as $func) {
            $funcionario_pedido = new funcionario_pedido;
            $funcionario_pedido['ID_funcionario'] = $func;
            $funcionario_pedido['ID_pedido'] = $idPedido;
            $funcionario_pedido['status'] = 'Aberto';
            $funcionario_pedido['ID_cliente'] = $idCliente;
            $funcionario_pedido->create($funcionario_pedido->getAttributes());
        }
        

        //return redirect('admin/pedido/aberto')->with('success', 'Pedido Aberto Com Sucesso!');
        return response()->json(['message'=>'Funfou'],200);
        /*
        $usuario = Auth::user();
        $firma = Auth::user()->firma;

        $pedido = new Pedido;
        
       
        $dataFormCliPedido = $request->except([
            '_token',
            '_method',
            'submit'
        ]);

        dd($dataFormCliPedido);
        */
    }
    public function AutoCompleteClientes(Request $request){
    $clientes = 
     cliente::select(DB::raw('concat(nome) as text, ID_cliente as value'))
                ->where("nome","LIKE","%{$request->input('query')}%")
                ->get();
    return response()->json($clientes);
    }

    public function imprimir(Request $request){
        //PEGANDO O NUMERO DE PEDIDO PARA PEGAR AS INFOS 
        $string = request()->headers->get('referer');
        $idPedido = explode("/", $string);
        //dd($idPedido);
        $firma = Auth::user()->firma;
        $pedidoSingle = DB::table('pedido')->where('ID_pedido',$idPedido[5])->where('firma', $firma)->get()->toArray();
        //dd($pedidoSingle[0]);
        $OF = $pedidoSingle[0]->OF;
        $idCli = $pedidoSingle[0]->ID_cliente;
        $produtos = array();
        
        $total = 0;

        $pedidoFull = DB::table('pedido')->where('OF',$OF)->where('firma', $firma)->get()->toArray();
        $cliente = DB::table('cliente')->where('ID_cliente',$idCli)->get()->toArray();

        //dd($pedidoFull[0]);
        foreach ($pedidoFull as $produto) {
            $produto = DB::table('produto_cliente')->where('cod_fabricacao', $produto->codigo)->where('firma', $firma)->get()->toArray();
            array_push($produtos,$produto[0]);
        }
        //array_pop($produtos);
        //dd($produtos);
        
        $dataHoje = date("d/m/Y");

        if($pedidoFull[0]->codigo != 'sem codigo')
            return view('admin.pedido.template', compact('pedidoFull','cliente','produtos','total','firma'));
        else    
            return view('admin.pedido.templateGenerico', compact('pedidoFull','cliente','produtos','total','dataHoje','firma'));
    }

}
