<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model
{
    protected $fillable = [
        'nome',
        'duracao',
        'data_lancamento',
        'classificacao',
        'sinopse',
        'studio_id'

    ];
    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_movies')
            ->withPivot('papel')
            ->withTimestamps();
    }

    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(Director::class, 'director_movies');
    }

    public function producers(): BelongsToMany
    {
        return $this->belongsToMany(Producer::class, 'producer_movies');
    }
    public function writers(): BelongsToMany
    {
        return $this->belongsToMany(Writer::class, 'writer_movies');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_genres');
    }

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'movie_images');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

}
