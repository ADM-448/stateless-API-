<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    public function index()
    {
        return response()->json(Livro::all());
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $livro = Livro::create($request->all());
        return response()->json(['mensagem' => 'Criado com sucesso!', 'livro' => $livro], 201);
    }

    public function show(string $id)
    {
        $livro = Livro::find($id);
        if (!$livro) return response()->json(['erro' => 'Não encontrado'], 404);

        return response()->json($livro);
    }

    public function edit(Livro $livro)
    {
    }

    public function update(Request $request, string $id)
    {
        $livro = Livro::find($id);
        $livro->update($request->all());

        return response()->json(['mensagem' => 'Atualizado!', 'livro' => $livro]);
    }

    public function destroy(string $id)
    {
        $livro = Livro::find($id);
        $livro->delete();

        return response()->json(['mensagem' => 'Deletado com sucesso']);
    }
}
