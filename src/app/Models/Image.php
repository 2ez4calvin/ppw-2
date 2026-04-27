<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Image extends Model
{
    protected $fillable = [
        'caminho',
        'nome',
    ];

    public function person():BelongsToMany
    {
        return $this->belongsToMany(Person::class,  'person_image');
    }

    public function studio():BelongsToMany
    {
        return $this->belongsToMany(Studio::class, 'studio_image');
    }

    public function movie():BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'movie_image');
    }
}
