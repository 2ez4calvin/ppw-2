<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;   
use App\Models\Studio;
use App\Models\Genre;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Writer;
use App\Models\Producer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class MovieController extends Controller
{

    public function teste(string $id)
    {
        $movie = Movie::findOrFail($id);
        return view('filmes.show_public', compact('movie'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::with('studio')->paginate(8);
        return view('filmes.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $studios = Studio::orderBy('nome')->get();
        $genres = Genre::orderBy('nome')->get();

        // Traz os dados de pessoas processados em memória pra ordenar por nome da pessoa, já que atores, diretores, etc não tem nome direto
        $actors = Actor::with('person')->get()->sortBy('person.nome');
        $directors = Director::with('person')->get()->sortBy('person.nome');
        $writers = Writer::with('person')->get()->sortBy('person.nome');
        $producers = Producer::with('person')->get()->sortBy('person.nome');

        return view('filmes.create', compact('studios', 'genres', 'actors', 'directors', 'writers', 'producers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {

        $arquivosNovosSalvos = [];

        try {
            DB::transaction(function () use ($request, &$arquivosNovosSalvos) {
                
                $movie = Movie::create([
                    'nome' => $request->nome,
                    'data_lancamento' => $request->data_lancamento,
                    'duracao' => $request->duracao,
                    'sinopse' => $request->sinopse,
                    'classificacao' => $request->classificacao,
                    'studio_id' => $request->studio_id,
                ]);

                $movie->genres()->sync($request->input('genres'));
                $movie->directors()->sync($request->input('directors'));
                $movie->actors()->sync($request->input('actors', []));
                $movie->writers()->sync($request->input('writers', []));
                $movie->producers()->sync($request->input('producers', []));

                if ($request->hasFile('imagens')) {
                    foreach ($request->file('imagens') as $arquivo) {
                        
                        $caminho = $arquivo->store('movies', 'public');
                        $arquivosNovosSalvos[] = $caminho;
                        $novaImagem = Image::create([
                            'caminho' => $caminho,
                            'nome' => $arquivo->getClientOriginalName()
                        ]);

                        $movie->images()->attach($novaImagem->id);
                    }
                }
            });

            return redirect()->route('filmes.index')->with('sucesso', 'Filme e imagens cadastrados com sucesso!');

        } catch (\Exception $e) {
            // Remove arquivos do Storage se houver erro interno de banco
            foreach ($arquivosNovosSalvos as $caminho) {
                Storage::disk('public')->delete($caminho);
            }

            return back()->withInput()->withErrors(['error' => 'Erro ao salvar o filme: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::with([
            'studio', 
            'genres', 
            'images',
            'actors.person', 
            'directors.person', 
            'writers.person', 
            'producers.person'
        ])->findOrFail($id);

        return view('filmes.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $movie = Movie::with('images')->findOrFail($id);
        
        $studios = Studio::orderBy('nome')->get();
        $genres = Genre::orderBy('nome')->get();

        $actors = Actor::with('person')->get()->sortBy('person.nome');
        $directors = Director::with('person')->get()->sortBy('person.nome');
        $writers = Writer::with('person')->get()->sortBy('person.nome');
        $producers = Producer::with('person')->get()->sortBy('person.nome');

        return view('filmes.edit', compact('movie', 'studios', 'genres', 'actors', 'directors', 'writers', 'producers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, string $id)
    {
        $movie = Movie::findOrFail($id);

        $arquivosNovosSalvos = [];


        try {
            DB::transaction(function () use ($request, $movie, &$arquivosNovosSalvos) {
                
                $movie->update([
                    'nome' => $request->nome,
                    'data_lancamento' => $request->data_lancamento,
                    'sinopse' => $request->sinopse,
                    'classificacao' => $request->classificacao,
                    'duracao' => $request->duracao,
                    'studio_id' => $request->studio_id,
                ]);

                $movie->genres()->sync($request->input('genres'));
                $movie->directors()->sync($request->input('directors'));
                $movie->actors()->sync($request->input('actors', []));
                $movie->writers()->sync($request->input('writers', []));
                $movie->producers()->sync($request->input('producers', []));

                if ($request->has('remover_imagens') && is_array($request->remover_imagens)) {
                    foreach ($request->remover_imagens as $imageId) {
                        $imagem = Image::find($imageId);
                        if ($imagem) {
                            if (Storage::disk('public')->exists($imagem->caminho)) {
                                Storage::disk('public')->delete($imagem->caminho);
                            }
                            $movie->images()->detach($imageId);
                            $imagem->delete();
                        }
                    }
                }

                if ($request->hasFile('imagens')) {
                    foreach ($request->file('imagens') as $arquivo) {
                        
                        $caminho = $arquivo->store('movies', 'public');
                        $arquivosNovosSalvos[] = $caminho;

                        $novaImagem = Image::create([
                            'caminho' => $caminho,
                            'nome' => $arquivo->getClientOriginalName()
                        ]);

                        $movie->images()->attach($novaImagem->id);
                    }
                }
            });

            return redirect()->route('filmes.index')->with('sucesso', 'Filme atualizado com sucesso!');

        } catch (\Exception $e) {
            foreach ($arquivosNovosSalvos as $caminho) {
                Storage::disk('public')->delete($caminho);
            }

            return back()->withInput()->withErrors(['error' => 'Erro ao atualizar o filme. Detalhes: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::with('images')->findOrFail($id);

        try {
            DB::transaction(function () use ($movie) {
                foreach ($movie->images as $imagem) {
                    if (Storage::disk('public')->exists($imagem->caminho)) {
                        Storage::disk('public')->delete($imagem->caminho);
                    }
                    $movie->images()->detach($imagem->id);
                    $imagem->delete();
                }

                $movie->delete();
            });

            return redirect()->route('filmes.index')->with('sucesso', 'Filme e os seus arquivos removidos!');
        } catch (\Exception $e) {
            return redirect()->route('filmes.index')->with('erro', 'Erro ao remover: ' . $e->getMessage());
        }
    }
}

