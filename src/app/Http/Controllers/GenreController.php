<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::paginate(8);
        return view('generos.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('generos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenreRequest $request)
    {

    Genre::create(['nome' => $request->nome]);

    return redirect()->route('generos.index')->with('sucesso', 'Gênero criado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::findOrFail($id);
        return view('generos.show', compact('genre'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $genre = Genre::findOrFail($id);
        return view('generos.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenreRequest $request, string $id)
    {
        $genre = Genre::findOrFail($id);


        $genre->update(['nome' => $request->nome]);

        return redirect()->route('generos.index')->with('sucesso', 'Gênero atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return redirect()->route('generos.index')->with('sucesso', 'Genero removido!');
    }
}
