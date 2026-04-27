<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Studio extends Model
{
    protected $fillable = [
        'nome',
        'local',
    ];

    public function image():BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'studio_image');
    }

    public function movie():BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'studio_movie');
    }
}
