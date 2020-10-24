<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\evento;
use Illuminate\Http\Request;
use Auth;
use DB;
use Symfony\Component\VarDumper\VarDumper;

class MoneyController extends Controller
{

    public function index()
    {
        $favorecidos = array();
        $fornecedores = DB::table('fornecedor')->select('*')->get();
        $clientes = DB::table('cliente')->select('*')->get();
        //dd($fornecedores);
        return view('admin.money.calendario',compact('clientes'));
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

    public function carregarEventos(Request $request){

        $returnedColumns = ['id', 'title', 'start', 'end', 'color', 'description','ID_cliente','favorecido','ID_fornecedor'];

        $start = (!empty($request->start)) ? ($request->start) : ('');
        $end = (!empty($request->end)) ? ($request->end) : ('');

        /** Retornaremos apenas os eventos ENTRE as datas iniciais e finais visiveis no calendário */
        $eventos = evento::whereBetween('start', [$start, $end])->get($returnedColumns);


        return response()->json($eventos);
    }

    public function atualizarEvento(Request $request){
        $event = evento::where('id',$request->id)->first();
        $event->fill($request->all());
        $event->save();
        
        return response()->json(true);
    }

    public function inserirEvento(Request $request){
        file_put_contents('varDump.txt',$request->all());
        $event = evento::create($request->all());
        return response()->json(true);
    }

    public function excluirEvento(Request $request){
        $event = evento::where('id',$request->id)->first();
        $event->delete();
        return response()->json(true);
    }
}
