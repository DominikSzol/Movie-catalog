<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'rating',
        'comment',
    ];

    public function rated_by() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rated_on() {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}
