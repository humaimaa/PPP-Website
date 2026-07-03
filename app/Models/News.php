<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'type',
        'img_path',
        'is_featured',
        'news_date',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'news_date' => 'datetime',
    ];

    protected function slugSourceColumn(): string
    {
        return 'title';
    }

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