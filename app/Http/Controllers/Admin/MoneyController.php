<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\banco;
use App\Models\evento;
use Illuminate\Http\Request;
use Auth;
use DB;
use Symfony\Component\VarDumper\VarDumper;

class MoneyController extends Controller
{

    public function index()
    {


        $bancos = DB::table('banco')->select('*')->get();
        $funcionarios = DB::table('funcionario')->select('*')->where('money', 'sim')->get();

        return view('admin.money.calendario', compact('bancos', 'funcionarios'));
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

    public function carregarEventos(Request $request)
    {

        $returnedColumns = [
            'id', 'title', 'start', 'end', 'color', 'description', 'ID_cliente',
            'favorecido', 'ID_fornecedor', 'tipoFav', 'ID_banco', 'ID_funcionario', 'ID_transportadora', 'valor', 'numero',
            'situacao'
        ];

        $start = (!empty($request->start)) ? ($request->start) : ('');
        $end = (!empty($request->end)) ? ($request->end) : ('');

        /** Retornaremos apenas os eventos ENTRE as datas iniciais e finais visiveis no calendário */
        $eventos = evento::whereBetween('start', [$start, $end])->get($returnedColumns);


        return response()->json($eventos);
    }

    public function atualizarEvento(Request $request)
    {
        $event = evento::where('id', $request->id)->first();
        //EVENTO ANTES DA MODIFICACAO
        $oldEvent = evento::where('id', $request->id)->first();
        file_put_contents('atualizarEvtOld.json', $event);
        $event->fill($request->all());

        
        file_put_contents('atualizarEvtNew.json', $event);
        //EVENTO DEPOIS DA MODIFICACAO
        $newEvent = $event;

        /*
        //VERIFICA SE ENVENTO FOI ABERTO OU FECHADO E ATUALIZA A DATA DA BAIXA
        if($oldEvent->situacao == 'on' & $newEvent->situacao == 'off'){
            $event->dataBaixa = date("Y-m-d H:i:s", time());
        }
        if($oldEvent->situacao == 'off' & $newEvent->situacao == 'on'){
            $event->dataBaixa = date("Y-m-d H:i:s", time());
        }
        */

        //VERIFICA SE HOUVE TROCA DE BANCO
        /*
        if($oldEvent->ID_banco != $newEvent->ID_banco){
            //Tras o OLD banco
            $oldBanco = banco::where('ID_banco',$oldEvent->ID_banco)->first();
            //Tras o NEW banco
            $newBanco = banco::where('ID_banco',$newEvent->ID_banco)->first();

            file_put_contents('dump.json',$oldBanco.' '.$newBanco);
        }
        */
        //=============================
        //========= LEGENDA ===========
        //=============================
        // on = pendente / off = registrado 

        //CLIENTE 
        if (($oldEvent->situacao == 'on' & $newEvent->situacao == 'off') && $newEvent->tipoFav == 'cliente') {
            $event->color = '#f2f2e400';
            $event->title = '⠀';

            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 3');
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $newBanco->saldo = $newBanco->saldo + $newEvent->valor;
                $newBanco->save();
            } 
            else {
                file_put_contents('dump.json', 'SITUAÇÃO 1');
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $newBanco->saldo = $newBanco->saldo + $newEvent->valor;
                $newBanco->save();

            }
        } 
        else if (($oldEvent->situacao == 'off' & $newEvent->situacao == 'on') && $newEvent->tipoFav == 'cliente') {
            $event->color = '#8cf19f';
            $event->title = '⠀';

            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 6');
                $oldBanco = banco::where('ID_banco', $oldEvent->ID_banco)->first();
                $oldBanco->saldo = $oldBanco->saldo - $newEvent->valor;
                $oldBanco->save();

                
            } 
            else {
                file_put_contents('dump.json', 'SITUAÇÃO 444');
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $newBanco->saldo = $newBanco->saldo - $oldEvent->valor;
                $newBanco->save();
            }
        }
        else if ($oldEvent->situacao == 'on' & $newEvent->situacao == 'on' && $newEvent->tipoFav == 'cliente') {
            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 2');
            }
        } 
        else if ($oldEvent->situacao == 'off' & $newEvent->situacao == 'off' && $newEvent->tipoFav == 'cliente') {
            $event->color = '#f2f2e400';
            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json','SITUAÇÃO 5');
                $event->color = '#f2f2e400';
                $oldBanco = banco::where('ID_banco', $oldEvent->ID_banco)->first();
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $oldBanco->saldo = $oldBanco->saldo - $newEvent->valor;
                $newBanco->saldo = $newBanco->saldo + $newEvent->valor;
                $newBanco->save();
                $oldBanco->save();
            }
            if($oldEvent->valor != $newEvent->valor){
                $event->color = '#f2f2e400';
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $diferenca = $oldEvent->valor - $newEvent->valor;
                $diferenca = number_format((float)$diferenca, 2, '.', ' ');
                file_put_contents('dump.json','SITUAÇÃO 7 '.$diferenca);
                $newBanco->saldo = $newBanco->saldo - $diferenca;

                
                $newBanco->save();
            }
        }

        //FORNECEDOR,TRANSP,INVEST,FUNC...
        else if (($oldEvent->situacao == 'on' & $newEvent->situacao == 'off') && $newEvent->tipoFav != 'cliente') {
            $event->color = '#f2f2e400';
            $event->title = '⠀';

            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 3');
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $newBanco->saldo = $newBanco->saldo - $newEvent->valor;
                $newBanco->save();
            } 
            else {
                file_put_contents('dump.json', 'SITUAÇÃO 1');
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $newBanco->saldo = $newBanco->saldo - $newEvent->valor;
                $newBanco->save();

            }
        } 
        else if (($oldEvent->situacao == 'off' & $newEvent->situacao == 'on') && $newEvent->tipoFav != 'cliente') {
            $event->color = '#f1948c';
            $event->title = '⠀';
            
            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 6');
                $oldBanco = banco::where('ID_banco', $oldEvent->ID_banco)->first();
                $oldBanco->saldo = $oldBanco->saldo + $newEvent->valor;
                $oldBanco->save();

                
            } 
            else {
                file_put_contents('dump.json', 'SITUAÇÃO 44');
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $newBanco->saldo = $newBanco->saldo + $oldEvent->valor;
                $newBanco->save();
            }
        } 
        else if ($oldEvent->situacao == 'on' & $newEvent->situacao == 'on' && $newEvent->tipoFav != 'cliente') {
            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 2');
            }
        } 
        else if ($oldEvent->situacao == 'off' & $newEvent->situacao == 'off' && $newEvent->tipoFav != 'cliente') {
            $event->color = '#f2f2e400';
            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json','SITUAÇÃO 5');
                $event->color = '#f2f2e400';
                $oldBanco = banco::where('ID_banco', $oldEvent->ID_banco)->first();
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $oldBanco->saldo = $oldBanco->saldo + $newEvent->valor;
                $newBanco->saldo = $newBanco->saldo - $newEvent->valor;
                $newBanco->save();
                $oldBanco->save();
            }
            if($oldEvent->valor != $newEvent->valor){
                $event->color = '#f2f2e400';
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $diferenca = $oldEvent->valor - $newEvent->valor;
                $diferenca = number_format((float)$diferenca, 2, '.', ' ');
                file_put_contents('dump.json','SITUAÇÃO 7 b '.$diferenca);
                $newBanco->saldo = $newBanco->saldo + $diferenca;

                
                $newBanco->save();
            }
        }

        $event->save();
        file_put_contents('atualizarEvtNew.json', $event);

        return response()->json(true);
    }

    public function inserirEvento(Request $request)
    {
        
        $event = new evento;
        $event->fill($request->all());
        file_put_contents('varDump.txt', $event);
        $banco = banco::where('ID_banco', $event->ID_banco)->first();

        //VERIFICA O TIPO DE FAVORECIDO E SE O EVENDO É CRIADO FECHADO OU ABERTO
        if($event->situacao == 'off' && $event->tipoFav == 'cliente'){
            
            $event->color = '#f2f2e400';
            $banco->saldo = $banco->saldo + $event->valor;
            $banco->save();
        }
        else if($event->situacao == 'off' && $event->tipoFav != 'cliente'){
            $event->color = '#f2f2e400';
            $banco->saldo = $banco->saldo - $event->valor;
            $banco->save();
        }
        
        $event->save();
        return response()->json(true);
    }

    public function excluirEvento(Request $request)
    {
        $event = new evento;
        $event->fill($request->all());
        $event = evento::where('id', $event->id)->first();
        $banco = banco::where('ID_banco', $event->ID_banco)->first();

        if($event->situacao == 'off' && $event->tipoFav == 'cliente'){
            $banco->saldo = $banco->saldo - $event->valor;
            $banco->save();
        }
        else if($event->situacao == 'off' && $event->tipoFav != 'cliente'){
            $banco->saldo = $banco->saldo + $event->valor;
            $banco->save();
        }

        
        $event->delete();
        return response()->json(true);
    }

    public function mostrarBanco($idBanco)
    {
        $banco = banco::where('ID_banco', $idBanco)->first();
        $eventos = DB::table('evento')->select('*')->where('ID_banco',$idBanco)->where('situacao','off')->orderBy('start','desc')->orderBy('dataBaixa','desc')->get();
        $saldoBanco = $banco->saldo;
        $i = 0;
        $lastEvt = null;
        foreach ($eventos as $evento) {
            if($i!=0){
                if($lastEvt->tipoFav != 'cliente'){
                    $evento->saldo = $lastEvt->saldo + $lastEvt->valor;
                    $evento->saldo = number_format($evento->saldo,2,'.','');
                }
                else{
                    $evento->saldo = $lastEvt->saldo - $lastEvt->valor;
                    $evento->saldo = number_format($evento->saldo,2,'.','');
                }
            }
            else{
                $evento->saldo = $saldoBanco;
                
            }
            if($evento->tipoFav != 'cliente'){
                $evento->corFonte = 'red';
                //$evento->valor = $evento->valor * -1;
            }
            else{
                $evento->corFonte = 'black';
            }
            $lastEvt = $evento;
            $i++;

            //Altera a data para formato PT-BR
            $evento->dataFormat = date('d/m/Y', strtotime($evento->start));
            
            
        }
        $bancos = DB::table('banco')->select('*')->get();
        
            
        

        return view('admin.money.bancoEvent',compact('eventos','banco','bancos'));
    }

    public function rendimentoVsDespesas($relatorio){
        if($relatorio == 1){
            // RENDIMENTOS VS DESPESAS
            $totalDespesa = 0;
            $totalGeral = 0;
            $primeiroDiaMes = date('Y-m-01');
            $ultimoDiaMes = date('Y-m-t');

            

            $resultado = DB::table('evento as e')->select(DB::raw('sum(e.valor) as total,e.tipoFav as tipoFav'))->where('e.situacao','like','off')->where('e.start', '>=', $primeiroDiaMes)->where('e.start', '<=', $ultimoDiaMes)->groupBy('e.tipoFav')->get();
            for($i = 1; $i < sizeof($resultado); $i++){
                $totalDespesa += $resultado[$i]->total;
            }
            return view('admin.money.rendimentoVsDespesas',compact('resultado','totalDespesa','totalGeral','primeiroDiaMes','ultimoDiaMes'));
        }
    }

    public function gerarRelatorio01(Request $request){
        //dd($request);
        
        $dataForm = $request->except([
            '_token',
            '_method',
            'submit'
        ]);
        $totalDespesa = 0;
        $totalGeral = 0;
        
        try {
            //var_dump($dataForm);
            $resultado = DB::table('evento as e')->select(DB::raw('sum(e.valor) as total,e.tipoFav as tipoFav'))
            ->where('e.situacao','like',$dataForm['situacao'])
            ->where('e.start', '>=', $dataForm['inicio'])->where('e.start', '<=', $dataForm['fim'])
            ->groupBy('e.tipoFav')->get();
        
            for($i = 1; $i < sizeof($resultado); $i++){
                $totalDespesa += $resultado[$i]->total;
            }
            
            
            $tabela01 = view('admin.money.extra.tabelaRVD01', compact('resultado','totalDespesa','totalGeral'))->render(); 
            $tabela02 = view('admin.money.extra.tabelaRVD02', compact('resultado','totalDespesa','totalGeral'))->render();
            $tabela03 = view('admin.money.extra.tabelaRVD03', compact('resultado','totalDespesa','totalGeral'))->render();  
            
            return response()->json(compact('tabela01','tabela02','tabela03'));
        } catch (\Exception $e) {
            return $e;
        }
        

    }
}
