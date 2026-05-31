<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'nome',
        'duracao',
        'data_lancamento',
        'classificacao',
        'sinopse',
    ];
    public function actor():BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_movie');
    }

    public function director():BelongsToMany
    {
        return $this->belongsToMany(Director::class, 'director_movie');
    }

    public function producer():BelongsToMany
    {
        return $this->belongsToMany(Producer::class, 'producer_movies');
    }
    public function writer():BelongsToMany
    {
        return $this->belongsToMany(Writer::class, 'writer_movies');
    }

    public function genre():BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_genres');
    }

    public function studio():BelongsToMany
    {
        return $this->belongsToMany(Studio::class, 'studio_movies');
    }

    public function image():BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'movie_images');
    }

    public function review():HasMany
    {
        return $this->hasMany(Review::class);
    }

}
