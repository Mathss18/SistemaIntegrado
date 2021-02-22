<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\banco;
use App\Models\cliente;
use App\Models\evento;
use App\Models\fornecedor;
use App\Models\Funcionario;
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
        $eventos = evento::whereBetween('start', [$start, $end])->orderBy('situacao', 'desc')->get($returnedColumns);


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
            } else {
                file_put_contents('dump.json', 'SITUAÇÃO 1');
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $newBanco->saldo = $newBanco->saldo + $newEvent->valor;
                $newBanco->save();
            }
        } else if (($oldEvent->situacao == 'off' & $newEvent->situacao == 'on') && $newEvent->tipoFav == 'cliente') {
            $event->color = '#8cf19f';
            $event->title = '⠀';

            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 6');
                $oldBanco = banco::where('ID_banco', $oldEvent->ID_banco)->first();
                $oldBanco->saldo = $oldBanco->saldo - $newEvent->valor;
                $oldBanco->save();
            } else {
                file_put_contents('dump.json', 'SITUAÇÃO 444');
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $newBanco->saldo = $newBanco->saldo - $oldEvent->valor;
                $newBanco->save();
            }
        } else if ($oldEvent->situacao == 'on' & $newEvent->situacao == 'on' && $newEvent->tipoFav == 'cliente') {
            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 2');
            }
        } else if ($oldEvent->situacao == 'off' & $newEvent->situacao == 'off' && $newEvent->tipoFav == 'cliente') {
            $event->color = '#f2f2e400';
            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 5');
                $event->color = '#f2f2e400';
                $oldBanco = banco::where('ID_banco', $oldEvent->ID_banco)->first();
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $oldBanco->saldo = $oldBanco->saldo - $newEvent->valor;
                $newBanco->saldo = $newBanco->saldo + $newEvent->valor;
                $newBanco->save();
                $oldBanco->save();
            }
            if ($oldEvent->valor != $newEvent->valor) {
                $event->color = '#f2f2e400';
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $diferenca = $oldEvent->valor - $newEvent->valor;
                $diferenca = number_format((float)$diferenca, 2, '.', ' ');
                file_put_contents('dump.json', 'SITUAÇÃO 7 ' . $diferenca);
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
            } else {
                file_put_contents('dump.json', 'SITUAÇÃO 1');
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $newBanco->saldo = $newBanco->saldo - $newEvent->valor;
                $newBanco->save();
            }
        } else if (($oldEvent->situacao == 'off' & $newEvent->situacao == 'on') && $newEvent->tipoFav != 'cliente') {
            $event->color = '#f1948c';
            $event->title = '⠀';

            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 6');
                $oldBanco = banco::where('ID_banco', $oldEvent->ID_banco)->first();
                $oldBanco->saldo = $oldBanco->saldo + $newEvent->valor;
                $oldBanco->save();
            } else {
                file_put_contents('dump.json', 'SITUAÇÃO 44');
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $newBanco->saldo = $newBanco->saldo + $oldEvent->valor;
                $newBanco->save();
            }
        } else if ($oldEvent->situacao == 'on' & $newEvent->situacao == 'on' && $newEvent->tipoFav != 'cliente') {
            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 2');
            }
        } else if ($oldEvent->situacao == 'off' & $newEvent->situacao == 'off' && $newEvent->tipoFav != 'cliente') {
            $event->color = '#f2f2e400';
            if ($oldEvent->ID_banco != $newEvent->ID_banco) {
                file_put_contents('dump.json', 'SITUAÇÃO 5');
                $event->color = '#f2f2e400';
                $oldBanco = banco::where('ID_banco', $oldEvent->ID_banco)->first();
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $oldBanco->saldo = $oldBanco->saldo + $newEvent->valor;
                $newBanco->saldo = $newBanco->saldo - $newEvent->valor;
                $newBanco->save();
                $oldBanco->save();
            }
            if ($oldEvent->valor != $newEvent->valor) {
                $event->color = '#f2f2e400';
                $newBanco = banco::where('ID_banco', $newEvent->ID_banco)->first();
                $diferenca = $oldEvent->valor - $newEvent->valor;
                $diferenca = number_format((float)$diferenca, 2, '.', ' ');
                file_put_contents('dump.json', 'SITUAÇÃO 7 b ' . $diferenca);
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
        file_put_contents('varDump.json', $event);
        $banco = banco::where('ID_banco', $event->ID_banco)->first();


        if ($event->tipoFav == 'cliente' && $event->ID_cliente == null) {
            $cliente = new cliente();
            $cliente->nome = $event->favorecido;
            $cliente->ibge = 'money';
            $cliente->tipo = 'C';
            $cliente->mostrar = 'nao';
            $cliente->save();
        } else if ($event->tipoFav == 'transportadora' && $event->ID_transportadora == null) {
            $transp = new cliente();
            $transp->nome = $event->favorecido;
            $transp->ibge = 'money';
            $transp->tipo = 'T';
            $transp->mostrar = 'nao';
            $transp->save();
        } else if ($event->tipoFav == 'funcionario' && $event->ID_funcionario == null) {
            $func = new Funcionario();
            $func->nome = $event->favorecido;
            $func->money = 'sim';
            $func->funcPedido = 'nao';
            $func->perfil = 'Producao';
            $func->save();
        } else if ($event->tipoFav == 'fornecedor' && $event->ID_fornecedor == null) {
            $fornecedor = new fornecedor();
            $fornecedor->nome = $event->favorecido;
            $fornecedor->inscricao_estadual = 'money';
            $fornecedor->firma = 'MF';
            $fornecedor->save();
        } else if ($event->tipoFav == 'imposto' && $event->ID_fornecedor == null) {
            $fornecedor = new fornecedor();
            $fornecedor->nome = $event->favorecido;
            $fornecedor->inscricao_estadual = 'money';
            $fornecedor->firma = 'MF';
            $fornecedor->save();
        } else if ($event->tipoFav == 'investimento' && $event->ID_fornecedor == null) {
            $fornecedor = new fornecedor();
            $fornecedor->nome = $event->favorecido;
            $fornecedor->inscricao_estadual = 'money';
            $fornecedor->firma = 'MF';
            $fornecedor->save();
        }


        //VERIFICA O TIPO DE FAVORECIDO E SE O EVENDO É CRIADO FECHADO OU ABERTO
        if ($event->situacao == 'off' && $event->tipoFav == 'cliente') {

            $event->color = '#f2f2e400';
            $banco->saldo = $banco->saldo + $event->valor;
            $banco->save();
        } else if ($event->situacao == 'off' && $event->tipoFav != 'cliente') {
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

        if ($event->situacao == 'off' && $event->tipoFav == 'cliente') {
            $banco->saldo = $banco->saldo - $event->valor;
            $banco->save();
        } else if ($event->situacao == 'off' && $event->tipoFav != 'cliente') {
            $banco->saldo = $banco->saldo + $event->valor;
            $banco->save();
        }


        $event->delete();
        return response()->json(true);
    }

    public function mostrarBanco($idBanco)
    {
        $banco = banco::where('ID_banco', $idBanco)->first();
        $eventos = DB::table('evento')->select('*')->where('ID_banco', $idBanco)->where('situacao', 'off')->orderBy('start', 'desc')->orderBy('dataBaixa', 'desc')->get();
        $saldoBanco = $banco->saldo;
        $i = 0;
        $lastEvt = null;
        foreach ($eventos as $evento) {
            if ($i != 0) {
                if ($lastEvt->tipoFav != 'cliente') {
                    $evento->saldo = $lastEvt->saldo + $lastEvt->valor;
                    $evento->saldo = number_format($evento->saldo, 2, '.', '');
                } else {
                    $evento->saldo = $lastEvt->saldo - $lastEvt->valor;
                    $evento->saldo = number_format($evento->saldo, 2, '.', '');
                }
            } else {
                $evento->saldo = $saldoBanco;
            }
            if ($evento->tipoFav != 'cliente') {
                $evento->corFonte = 'red';
                //$evento->valor = $evento->valor * -1;
            } else {
                $evento->corFonte = 'black';
            }
            $lastEvt = $evento;
            $i++;

            //Altera a data para formato PT-BR
            $evento->dataFormat = date('d/m/Y', strtotime($evento->start));
        }
        $bancos = DB::table('banco')->select('*')->get();




        return view('admin.money.bancoEvent', compact('eventos', 'banco', 'bancos'));
    }

    public function relatorios($relatorio)
    {
        if ($relatorio == 1) {
            // RENDIMENTOS VS DESPESAS
            $totalDespesa = 0;
            $totalGeral = 0;
            $primeiroDiaMes = date('Y-m-01');
            $ultimoDiaMes = date('Y-m-t');



            $resultado = DB::table('evento as e')->select(DB::raw('sum(e.valor) as total,e.tipoFav as tipoFav'))->where('e.situacao', 'like', 'off')->where('e.start', '>=', $primeiroDiaMes)->where('e.start', '<=', $ultimoDiaMes)->groupBy('e.tipoFav')->get();
            for ($i = 1; $i < sizeof($resultado); $i++) {
                $totalDespesa += $resultado[$i]->total;
            }

            $resultadoRendimentos = DB::table('evento as e')
                ->join('banco as b', 'b.ID_banco', '=', 'e.ID_banco')
                ->select('*')
                ->where('e.situacao', 'like', 'off')
                ->where('e.tipoFav', 'like', 'cliente')
                ->where('e.start', '>=', $primeiroDiaMes)->where('e.start', '<=', $ultimoDiaMes)
                ->orderBy('e.start', 'desc')
                ->get();

            $tipoFavDespesa =  DB::table('evento as e')
                ->select('e.tipoFav')
                ->where('e.situacao', 'like', 'off')
                ->where('e.tipoFav', 'not like', 'cliente')
                ->where('e.start', '>=', $primeiroDiaMes)->where('e.start', '<=', $ultimoDiaMes)
                ->groupBy('e.tipoFav')
                ->get();

            $tipoFavArray = [];

            foreach ($tipoFavDespesa as $tfd) {
                $resultadoDespesas = DB::table('evento as e')
                    ->join('banco as b', 'b.ID_banco', '=', 'e.ID_banco')
                    ->select('*')
                    ->where('e.situacao', 'like', 'off')
                    ->where('e.tipoFav', 'like', $tfd->tipoFav)
                    ->where('e.start', '>=', $primeiroDiaMes)->where('e.start', '<=', $ultimoDiaMes)
                    ->orderBy('e.start', 'desc')
                    ->get();
                array_push($tipoFavArray, $resultadoDespesas);
            }




            return view('admin.money.rendimentoVsDespesas', compact('resultado', 'totalDespesa', 'totalGeral', 'primeiroDiaMes', 'ultimoDiaMes', 'resultadoRendimentos', 'tipoFavArray'));
        } else if ($relatorio == 2) {
            $rendimentos = [];
            $despesas = [];
            $firstDays = [];
            $lastDays = [];
            $totalRendDesp = [];
            $mes = '';
            for ($i = 0; $i < 12; $i++) {
                switch ($i) {
                    case 0:
                        $mes = 'january';
                        break;
                    case 1:
                        $mes = 'february';
                        break;
                    case 2:
                        $mes = 'march';
                        break;
                    case 3:
                        $mes = 'april';
                        break;
                    case 4:
                        $mes = 'may';
                        break;
                    case 5:
                        $mes = 'june';
                        break;
                    case 6:
                        $mes = 'july';
                        break;
                    case 7:
                        $mes = 'august';
                        break;
                    case 8:
                        $mes = 'september';
                        break;
                    case 9:
                        $mes = 'october';
                        break;
                    case 10:
                        $mes = 'november';
                        break;
                    case 11:
                        $mes = 'december';
                        break;
                }

                $primeioDia = new \DateTime();
                $primeioDia->modify('first day of ' . $mes);
                $primeioDia = $primeioDia->format('Y-m-d');
                array_push($firstDays, $primeioDia);

                $ultimoDia = new \DateTime();
                $ultimoDia->modify('last day of' . $mes);
                $ultimoDia = $ultimoDia->format('Y-m-d');
                array_push($lastDays, $ultimoDia);


                //dd($firstDays);
                $rendimento = DB::table('evento as e')->select(DB::raw('sum(e.valor) as total'))
                    ->where('e.situacao', 'like', 'off')
                    ->where('e.tipoFav', 'like', 'cliente')
                    ->where('e.start', '>=', $primeioDia)->where('e.start', '<=', $ultimoDia)
                    ->get();

                $despesa = DB::table('evento as e')->select(DB::raw('sum(e.valor) as total'))
                    ->where('e.situacao', 'like', 'off')
                    ->where('e.tipoFav', 'not like', 'cliente')
                    ->where('e.start', '>=', $primeioDia)->where('e.start', '<=', $ultimoDia)
                    ->get();



                //dd($resultado[0]->total);
                array_push($rendimentos, $rendimento[0]->total);
                array_push($despesas, $despesa[0]->total);
                if ($i == 0)
                    array_push($totalRendDesp, ($rendimentos[$i] - $despesas[$i]) + 632840.94);
                else
                    array_push($totalRendDesp, ($rendimentos[$i] - $despesas[$i]) + $totalRendDesp[$i - 1]);

                if ($rendimentos[$i] == null && $despesas[$i] == null)
                    $totalRendDesp[$i] = 0;
            }
            //dd($rendimentos, $despesas, $totalRendDesp, $aux);
            return view('admin.money.rendimentoAoLongoDoTempo', compact('totalRendDesp'));
        } else if ($relatorio == 3) {

            $nomeFuncionario = Auth::user()->name;
            $aproveitamentos = [];

            $hoje = date('Y-m-d');
            $dataInicio = date('Y-m-01');
            $dataFim = date('Y-m-t');

            $funcionarios = DB::table('funcionario as f')->select('*')
                ->where('f.funcPedido', 'sim')
                ->orderBy('nome', 'asc')
                ->get();

            //dd($funcionarios);

            for ($i = 0; $i < count($funcionarios); $i++) {

                $pedidosAbertosAtrasados = DB::table('funcionario_pedido as fp')->join('funcionario as f', 'f.ID_funcionario', '=', 'fp.ID_funcionario')->join('pedido as p', 'p.ID_pedido', '=', 'fp.ID_pedido')->join('cliente as c', 'c.ID_cliente', '=', 'fp.ID_cliente')->select('fp.ID_funcionario_pedido', 'p.OF', 'p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade', 'p.tipo', 'p.ID_cliente', 'fp.data_controle', 'fp.data_baixa', 'c.nome')->where('f.nome', '=', $funcionarios[$i]->nome)->where('fp.data_controle', '>=', $dataInicio)->where('fp.data_controle', '<=', $dataFim)->where('p.data_entrega', '<=', $hoje)->where('fp.status', '=', 'Aberto')->orderBy('fp.ID_funcionario_pedido', 'desc')->get();
                $pedidosFechadosAtrasados = DB::table('funcionario_pedido as fp')->join('funcionario as f', 'f.ID_funcionario', '=', 'fp.ID_funcionario')->join('pedido as p', 'p.ID_pedido', '=', 'fp.ID_pedido')->join('cliente as c', 'c.ID_cliente', '=', 'fp.ID_cliente')->select('fp.ID_funcionario_pedido', 'p.OF', 'p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade', 'p.tipo', 'p.ID_cliente', 'fp.data_controle', 'fp.data_baixa', 'c.nome')->where('f.nome', '=', $funcionarios[$i]->nome)->where('fp.data_controle', '>=', $dataInicio)->where('fp.data_controle', '<=', $dataFim)->whereRaw('fp.data_baixa > p.data_entrega')->where('fp.status', '=', 'Fechado')->orderBy('fp.ID_funcionario_pedido', 'desc')->get();
                $pedidosFechadosAdiantados = DB::table('funcionario_pedido as fp')->join('funcionario as f', 'f.ID_funcionario', '=', 'fp.ID_funcionario')->join('pedido as p', 'p.ID_pedido', '=', 'fp.ID_pedido')->join('cliente as c', 'c.ID_cliente', '=', 'fp.ID_cliente')->select('fp.ID_funcionario_pedido', 'p.OF', 'p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade', 'p.tipo', 'p.ID_cliente', 'fp.data_controle', 'fp.data_baixa', 'c.nome')->where('f.nome', '=', $funcionarios[$i]->nome)->where('fp.data_controle', '>=', $dataInicio)->where('fp.data_controle', '<=', $dataFim)->whereRaw('fp.data_baixa <= p.data_entrega')->where('fp.status', '=', 'Fechado')->orderBy('fp.ID_funcionario_pedido', 'desc')->get();

                $porCentoPaa = $pedidosAbertosAtrasados->count();

                $porCentoPfa = $pedidosFechadosAtrasados->count();

                $porCentoPfad = $pedidosFechadosAdiantados->count();

                $totalPorCento = $porCentoPaa + $porCentoPfa + $porCentoPfad;
                if ($totalPorCento == 0) {
                    $totalPorCento = 1;
                }
                $aproveitamento = (($totalPorCento - $porCentoPaa - $porCentoPfa) * 100) / $totalPorCento;
                $aproveitamento = number_format($aproveitamento, 2);
                array_push($aproveitamentos, $aproveitamento);
            }

            //dd($funcionarios);

            return view('admin.money.relatorioProducao', compact('aproveitamentos','funcionarios'));
        }
    }

    public function gerarRelatorio01(Request $request)
    {
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
                ->where('e.situacao', 'like', $dataForm['situacao'])
                ->where('e.start', '>=', $dataForm['inicio'])->where('e.start', '<=', $dataForm['fim'])
                ->groupBy('e.tipoFav')->get();

            for ($i = 1; $i < sizeof($resultado); $i++) {
                $totalDespesa += $resultado[$i]->total;
            }

            $resultadoRendimentos = DB::table('evento as e')
                ->join('banco as b', 'b.ID_banco', '=', 'e.ID_banco')
                ->select('*')
                ->where('e.situacao', 'like', $dataForm['situacao'])
                ->where('e.tipoFav', 'like', 'cliente')
                ->where('e.start', '>=', $dataForm['inicio'])->where('e.start', '<=', $dataForm['fim'])
                ->orderBy('e.start', 'desc')
                ->get();


            $tipoFavDespesa =  DB::table('evento as e')
                ->select('e.tipoFav')
                ->where('e.situacao', 'like', $dataForm['situacao'])
                ->where('e.tipoFav', 'not like', 'cliente')
                ->where('e.start', '>=', $dataForm['inicio'])->where('e.start', '<=', $dataForm['fim'])
                ->groupBy('e.tipoFav')
                ->get();

            if (sizeOf($tipoFavDespesa) == 0) {
                $resultadoDespesas = [];
            }
            $tipoFavArray = [];


            foreach ($tipoFavDespesa as $tfd) {
                $resultadoDespesas = DB::table('evento as e')
                    ->join('banco as b', 'b.ID_banco', '=', 'e.ID_banco')
                    ->select('*')
                    ->where('e.situacao', 'like', $dataForm['situacao'])
                    ->where('e.tipoFav', 'like', $tfd->tipoFav)
                    ->where('e.start', '>=', $dataForm['inicio'])->where('e.start', '<=', $dataForm['fim'])
                    ->orderBy('e.start', 'desc')
                    ->get();
                array_push($tipoFavArray, $resultadoDespesas);
            }

            $tabela01 = view('admin.money.extra.tabelaRVD01', compact('resultado', 'totalDespesa', 'totalGeral', 'resultadoRendimentos'))->render();
            $tabela02 = view('admin.money.extra.tabelaRVD02', compact('resultado', 'totalDespesa', 'totalGeral', 'resultadoDespesas', 'tipoFavArray'))->render();
            $tabela03 = view('admin.money.extra.tabelaRVD03', compact('resultado', 'totalDespesa', 'totalGeral'))->render();

            return response()->json(compact('tabela01', 'tabela02', 'tabela03'));
        } catch (\Exception $e) {
            return response()->json(['message' => 'error']);
        }
    }
}
