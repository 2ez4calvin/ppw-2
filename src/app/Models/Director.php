<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Director extends Model
{
    protected $fillable = [
        'person_id',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class); 
    }
    public function movie():BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'director_movie');
    }
}
