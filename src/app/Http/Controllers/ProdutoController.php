<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome')->get();
        $quantidade_produtos = Produto::count();
        return view('produtos.index', compact('produtos', 'quantidade_produtos'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|min:3',
            'preco' => 'required|numeric|min:0',
        ]);
        Produto::create($dados);
        return redirect('/produtos')->with('sucesso', 'Produto criado!');
    }

    public function show(string $id)
    {
        $produto = Produto::findOrFail($id); // 404 automático
        return view('produtos.show', compact('produto'));
    }


    public function edit(string $id)
    {
        $produto = Produto::find($id);
        return view('produtos.edit', compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produto = Produto::find($id);
        $produto->update([
            'nome'=> $request->nome,
            'preco'=> $request->preco
        ]);
        return redirect('/produtos')->with('sucesso','Produto atualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Produto::findOrFail($id)->delete();
        return redirect('/produtos')->with('sucesso', 'Removido!');

    }
}