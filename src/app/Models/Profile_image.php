<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile_image extends Model
{
    protected $fillable = [
        'user_id',
        'nome',
        'caminho',
    ];


    public function review():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
