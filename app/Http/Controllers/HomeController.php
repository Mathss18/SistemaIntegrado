<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\FuncionarioPedidoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use PhpParser\Node\Expr\FuncCall;
use DateTime;
use Session;
use App\Models\cliente;
use App\Models\funcionario_pedido;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dataInicio = date('Y-m-01');
        $dataFim = date('Y-m-t');

        $dataInicioLastMonth = new DateTime("first day of last month");
        $dataFimLastMonth = new DateTime("last day of last month");
        $dataInicioLastMonth->format('Y-m-d'); // 2012-02-01
        $dataFimLastMonth->format('Y-m-d'); // 2012-02-29

        $aproveitamento = $this->relatorio($dataInicio, $dataFim);
        $aproveitamentoLastMonth = $this->relatorio($dataInicioLastMonth, $dataFimLastMonth);

        return view('home', compact('aproveitamento','aproveitamentoLastMonth'));
    }

    public function relatorio($dataInicio, $dataFim)
    {


        $nomeFuncionario = Auth::user()->name;


        $hoje = date('Y-m-d');


        $pedidosAbertosAtrasados = DB::table('funcionario_pedido as fp')->join('funcionario as f', 'f.ID_funcionario', '=', 'fp.ID_funcionario')->join('pedido as p', 'p.ID_pedido', '=', 'fp.ID_pedido')->join('cliente as c', 'c.ID_cliente', '=', 'fp.ID_cliente')->select('fp.ID_funcionario_pedido', 'p.OF', 'p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade', 'p.tipo', 'p.ID_cliente', 'fp.data_controle', 'fp.data_baixa', 'c.nome')->where('f.nome', '=', $nomeFuncionario)->where('fp.data_controle', '>=', $dataInicio)->where('fp.data_controle', '<=', $dataFim)->where('p.data_entrega', '<=', $hoje)->where('fp.status', '=', 'Aberto')->orderBy('fp.ID_funcionario_pedido', 'desc')->get();
        $pedidosFechadosAtrasados = DB::table('funcionario_pedido as fp')->join('funcionario as f', 'f.ID_funcionario', '=', 'fp.ID_funcionario')->join('pedido as p', 'p.ID_pedido', '=', 'fp.ID_pedido')->join('cliente as c', 'c.ID_cliente', '=', 'fp.ID_cliente')->select('fp.ID_funcionario_pedido', 'p.OF', 'p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade', 'p.tipo', 'p.ID_cliente', 'fp.data_controle', 'fp.data_baixa', 'c.nome')->where('f.nome', '=', $nomeFuncionario)->where('fp.data_controle', '>=', $dataInicio)->where('fp.data_controle', '<=', $dataFim)->whereRaw('fp.data_baixa > p.data_entrega')->where('fp.status', '=', 'Fechado')->orderBy('fp.ID_funcionario_pedido', 'desc')->get();
        $pedidosFechadosAdiantados = DB::table('funcionario_pedido as fp')->join('funcionario as f', 'f.ID_funcionario', '=', 'fp.ID_funcionario')->join('pedido as p', 'p.ID_pedido', '=', 'fp.ID_pedido')->join('cliente as c', 'c.ID_cliente', '=', 'fp.ID_cliente')->select('fp.ID_funcionario_pedido', 'p.OF', 'p.codigo', 'p.data_pedido', 'p.data_entrega', 'p.quantidade', 'p.tipo', 'p.ID_cliente', 'fp.data_controle', 'fp.data_baixa', 'c.nome')->where('f.nome', '=', $nomeFuncionario)->where('fp.data_controle', '>=', $dataInicio)->where('fp.data_controle', '<=', $dataFim)->whereRaw('fp.data_baixa <= p.data_entrega')->where('fp.status', '=', 'Fechado')->orderBy('fp.ID_funcionario_pedido', 'desc')->get();

        $porCentoPaa = $pedidosAbertosAtrasados->count();

        $porCentoPfa = $pedidosFechadosAtrasados->count();

        $porCentoPfad = $pedidosFechadosAdiantados->count();

        $totalPorCento = $porCentoPaa + $porCentoPfa + $porCentoPfad;
        if ($totalPorCento == 0) {
            $totalPorCento = 1;
        }
        $aproveitamento = (($totalPorCento - $porCentoPaa - $porCentoPfa) * 100) / $totalPorCento;
        $aproveitamento = number_format($aproveitamento, 2);


        return $aproveitamento;
    }
}
