<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    protected $fillable =[
        'cpf',
        'nome',
        'data_nascimento',
        'biografia',
        'genero',
        'nacionalidade',
    ];

    public function actor():HasOne
    {
        return $this->hasOne(Actor::class);
    }

    public function director():HasOne
    {
        return $this->hasOne(Director::class);
    }
    public function producer():HasOne
    {
        return $this->hasOne(Producer::class);
    }

    public function writer():HasOne
    {
        return $this->hasOne(Writer::class);
    }

    public function image():BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'person_image');
    }


}
