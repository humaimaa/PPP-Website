<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'content',
        'type',
        'img_path',
        'is_featured',
        'news_date', // Add this
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'news_date' => 'datetime', // Add this line to cast news_date as datetime
    ];

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}