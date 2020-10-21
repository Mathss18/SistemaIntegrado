<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class MoneyController extends Controller
{

    public function index()
    {
        return view('admin.money.calendario');
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

    public function carregarEventos(){
        $firma = Auth::user()->firma;
        $eventos = DB::table('evento')->where('firma',$firma)->get();
        return response()->json($eventos);
    }

    public function atualizarEvento(Request $request){
        var_dump($request->all());
    }
}
