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


        $bancos = DB::table('banco')->select('*')->get();
        $funcionarios = DB::table('funcionario')->select('*')->where('money','sim')->get();

        return view('admin.money.calendario',compact('bancos','funcionarios'));
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

        $returnedColumns = ['id', 'title', 'start', 'end', 'color', 'description','ID_cliente',
        'favorecido','ID_fornecedor','tipoFav','ID_banco','ID_funcionario','ID_transportadora','valor','numero',
        'situacao'
    ];

        $start = (!empty($request->start)) ? ($request->start) : ('');
        $end = (!empty($request->end)) ? ($request->end) : ('');

        /** Retornaremos apenas os eventos ENTRE as datas iniciais e finais visiveis no calendário */
        $eventos = evento::whereBetween('start', [$start, $end])->get($returnedColumns);


        return response()->json($eventos);
    }

    public function atualizarEvento(Request $request){
        $event = evento::where('id',$request->id)->first();
        //EVENTO ANTES DA MODIFICACAO
        $oldEvent = evento::where('id',$request->id)->first();
        file_put_contents('atualizarEvt.json',$event);
        $event->fill($request->all());
        
        //EVENTO DEPOIS DA MODIFICACAO
        $newEvent = $event; 

        //Verificar se o evento foi registrado 
        if(($oldEvent->situacao =='on' & $newEvent->situacao =='off') && $newEvent->tipoFav == 'cliente'){
            $event->color = '#025509';
            $event->title = '- Registrado';
        }
        else if(($oldEvent->situacao =='off' & $newEvent->situacao =='on') && $newEvent->tipoFav == 'cliente'){
            $event->color = '#8cf19f';
            $event->title = '- Aberto';
        }
        else if(($oldEvent->situacao =='on' & $newEvent->situacao =='off') && $newEvent->tipoFav != 'cliente'){
            $event->color = '#85110f';
            $event->title = '- Registrado';
        }
        else if(($oldEvent->situacao =='off' & $newEvent->situacao =='on') && $newEvent->tipoFav != 'cliente'){
            $event->color = '#f1948c';
            $event->title = '- Aberto';
        }

        $event->save();
        file_put_contents('atualizarEvt1.json',$event);
        
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
