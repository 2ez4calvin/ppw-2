<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studios = Studio::paginate(8);
        return view('estudios.index', compact('studios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estudios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'nome' => 'required|string|max:45|unique:studios,nome',
        'local' => 'required|string|max:45',
    ]);

    Studio::create(['nome' => $request->nome, 'local' => $request->local]);

    return redirect()->route('estudios.index')->with('sucesso', 'Estúdio criado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $studio = Studio::findOrFail($id);
        return view('estudios.show', compact('studio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $studio = Studio::findOrFail($id);
        return view('estudios.edit', compact('studio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $studio = Studio::findOrFail($id);
        $request->validate([
            'nome' => 'required|string|max:45|unique:studios,nome,' . $studio->id,
            'local' => 'required|string|max:45',
        ]);

        $studio->update(['nome' => $request->nome, 'local' => $request->local]);

        return redirect()->route('estudios.index')->with('sucesso', 'Estúdio atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $studio = Studio::findOrFail($id);
        $studio->delete();

        return redirect()->route('estudios.index')->with('sucesso', 'Estúdio removido!');
    }
}
