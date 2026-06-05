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
    ];

    // protected $casts = [
    //     'event_date'  => 'date',
    //     'is_featured' => 'boolean',
    // ];

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