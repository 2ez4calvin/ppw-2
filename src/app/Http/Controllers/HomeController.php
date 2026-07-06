<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Writer;
use App\Models\Studio;
use App\Models\Review; // Importe o model de Avaliações/Reviews (ajuste o nome se for diferente)

class HomeController extends Controller
{
    /**
     * .
     */
    public function index()
    {
        $carouselMovies = Movie::with('images')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $movies = Movie::with('images')
            ->inRandomOrder()
            ->take(4)
            ->get();

        $actors = Actor::with('person.image')
            ->inRandomOrder()
            ->take(4)
            ->get();

        $directors = Director::with('person.image')
            ->inRandomOrder()
            ->take(4)
            ->get();

        $recentReviews = [];
            $recentReviews = Review::with(['user', 'movie'])
                ->latest()
                ->take(4)
                ->get();
                
        return view('home/index', compact('carouselMovies', 'movies', 'actors','directors' ,'recentReviews'));
    }

    public function busca(Request $request)
    {
        $termo = trim($request->input('termo', ''));

        $movies = $actors = $directors = $writers = $studios = collect();

        if ($termo) {
            $movies = Movie::with('genres', 'images')->where('nome', 'ilike', "%{$termo}%")
                ->paginate(4, ['*'], 'movies_page')
                ->withQueryString();

           $actors = Actor::with('person.image')->whereHas('person', function ($query) use ($termo) {
                    $query->where('nome', 'ilike', "%{$termo}%");
                })
                ->paginate(4, ['*'], 'actors_page')
                ->withQueryString();

            $directors = Director::with('person.image',)->whereHas('person', function ($query) use ($termo) {
                    $query->where('nome', 'ilike', "%{$termo}%");
                })
                ->paginate(4, ['*'], 'directors_page')
                ->withQueryString();

            $writers = Writer::with('person.image')->whereHas('person', function ($query) use ($termo) {
                    $query->where('nome', 'ilike', "%{$termo}%");
                })
                ->paginate(4, ['*'], 'writers_page')
                ->withQueryString();

            $studios = Studio::with('image')->where('nome', 'ilike', "%{$termo}%")
                ->paginate(4, ['*'], 'studios_page')
                ->withQueryString();
        }

        return view('home.busca', compact('movies', 'actors', 'directors', 'writers', 'studios', 'termo'));
    }
}