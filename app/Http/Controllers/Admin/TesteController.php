<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cliente;
use Illuminate\Http\Request;

class TesteController extends Controller
{
    public function teste(){
        $numero = 10;
        $landa = 4;
        $clientes = new cliente();
        $clientes = $clientes->all();
        return view('admin.teste.teste',compact('numero','landa','clientes'));
    }

    public function index()
    {
        //
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
}
