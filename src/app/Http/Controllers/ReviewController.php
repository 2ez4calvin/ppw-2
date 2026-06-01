<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['movie', 'user'])->orderBy('created_at', 'desc')->paginate(10); //EAGERLOADING, aprofundar depois
        return view('reviews.index', compact('reviews'));
    }

    public function publicIndex(string $filmeId)
        {
        $avaliacoes = Review::with('user')
        ->where('movie_id', $filmeId)
        ->orderBy('created_at', 'desc')
        ->paginate(1);
        // Se for requisição AJAX (Accept: application/json), retorna JSON
        // O paginator serializa automaticamente para JSON com metadados
        return response()->json([
        'data' => $avaliacoes->items(),
        'current_page' => $avaliacoes->currentPage(),
        'last_page' => $avaliacoes->lastPage(),
        'total' => $avaliacoes->total(),
        'next_page_url' => $avaliacoes->nextPageUrl(),
        'prev_page_url' => $avaliacoes->previousPageUrl(),
        ]);
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $movies = Movie::orderBy('nome')->get();
        $users = User::orderBy('name')->get(); // Ou 'nome' dependendo da sua tabela users
        return view('reviews.create', compact('movies', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'user_id' => 'required|exists:users,id',
            'nota' => 'required|integer|min:1|max:5',
            'descricao' => 'nullable|string',
        ]);

        try {
            $jaExiste = Review::where('user_id', $request->user_id)
                              ->where('movie_id', $request->movie_id)
                              ->exists();

            if ($jaExiste) {
                return back()->withInput()->withErrors(['error' => 'Este usuário já fez uma avaliação para este filme!']);
            }

            Review::create($request->all());

            return redirect()->route('reviews.index')->with('sucesso', 'Review cadastrada com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Erro ao salvar review: ' . $e->getMessage()]);
        }
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $review = Review::findOrFail($id);
        $movies = Movie::orderBy('nome')->get();
        $users = User::orderBy('name')->get();
        
        return view('reviews.edit', compact('review', 'movies', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        {
        $review = Review::findOrFail($id);

        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'user_id' => 'required|exists:users,id',
            'nota' => 'required|integer|min:1|max:5',
            'descricao' => 'nullable|string',
        ]);

        try {
            $review->update($request->all());
            return redirect()->route('reviews.index')->with('sucesso', 'Review atualizada com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Erro ao atualizar: ' . $e->getMessage()]);
        }
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('reviews.index')->with('sucesso', 'Review removida!');
    }
    }
}
