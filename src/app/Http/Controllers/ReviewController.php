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
    
    $usuarioLogadoId = auth()->id(); 

    $avaliacoes = Review::with('user')
        ->where('movie_id', $filmeId)
        ->orderByRaw("CASE WHEN user_id = ? THEN 0 ELSE 1 END ASC", [$usuarioLogadoId])
        ->orderBy('created_at', 'desc')
        ->paginate(4);

    return response()->json([
        'data' => $avaliacoes->items(),
        'current_page' => $avaliacoes->currentPage(),
        'last_page' => $avaliacoes->lastPage(),
        'total' => $avaliacoes->total(),
        'next_page_url' => $avaliacoes->nextPageUrl(),
        'prev_page_url' => $avaliacoes->previousPageUrl(),
        'usuario_logado_id' => $usuarioLogadoId,
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $movies = Movie::orderBy('nome')->get();
        $users = User::orderBy('name')->get(); // Ou 'nome' dependendo da sua tabela users
        return view('reviews.create', compact('filmePublico', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'movie_id' => 'required|exists:movies,id',
        'user_id' => 'required|exists:users,id',
        'nota' => 'required|integer|min:1|max:5',
        'descricao' => 'nullable|string',
    ]);

    $jaAvaliou = Review::where('movie_id', $request->movie_id)
                       ->where('user_id', $request->user_id)
                       ->exists();

    if ($jaAvaliou) {
        return back()->with('erro_review', 'Você já enviou uma avaliação para este filme! Só é permitida uma por usuário.');
    }

    try {
        Review::create($request->all());
        return back()->with('sucesso', 'Sua avaliação foi enviada com sucesso!');
    } catch (\Exception $e) {
        return back()->withInput()->withErrors(['error' => 'Erro ao salvar avaliação: ' . $e->getMessage()]);
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
    $review = Review::findOrFail($id);
    $usuarioLogadoId = auth()->id();

    if ($review->user_id != $usuarioLogadoId) {
        if (request()->wantsJson()) {
            return response()->json(['erro' => 'Você não tem permissão para excluir esta avaliação.'], 403);
        }
        return back()->with('erro_review', 'Você não tem permissão para excluir esta avaliação.');
    }

    $review->delete();

    if (request()->wantsJson()) {
        return response()->json(['sucesso' => 'Sua avaliação foi removida com sucesso!']);
    }

    return back()->with('sucesso', 'Avaliação excluída com sucesso!');
}
}
