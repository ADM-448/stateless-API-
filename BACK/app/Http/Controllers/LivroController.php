<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Livro::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
   //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $livro = Livro::create($request->all());
        return response()->json(['mensagem' => 'Criado com sucesso!', 'livro' => $livro],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $livro = Livro::find($id);
        if(!$livro) return response()->json(['erro'=>'Não encontrado'],404);

        return response()->json($livro);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livro $livro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $livro = Livro::find($id);
        $livro->update($request->all());

        return response()->json(['mensagem'=>'Atualizado!','livro'=>$livro]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $livro = Livro::find($id);
        $livro->delete();

        return response()->json(['mensagem' => 'Deletado com sucesso']);
    }
}
