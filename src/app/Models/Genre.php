<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $fillable =[
        'nome',
    ];

    public function movie():BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'movie_genre');
    }
}
