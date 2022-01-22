<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'director',
        'description',
        'year',
        'length',
        'image',
        'ratings_enabled'
    ];

    public function ratings() {
        return $this->hasMany(Rating::class, 'movie_id');
    }
}
