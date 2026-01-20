<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    protected $fillable = [
        'artist_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'dimensions',
        'medium',
        'year_created',
        'status',
        'image_url',
        'is_featured'
    ];

    public function artist() {
        return $this->belongsTo(Artist::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
