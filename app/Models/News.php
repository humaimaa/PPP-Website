<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'type',
        'img_path',
        'is_featured',
        'news_date',
        'publish',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'news_date' => 'datetime',
    ];

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Generate slug when creating a new news item
        static::creating(function ($news) {
            $news->generateSlug();
        });

        // Regenerate slug when updating the title
        static::updating(function ($news) {
            if ($news->isDirty('title')) {
                $news->generateSlug();
            }
        });
    }

    /**
     * Generate slug from title
     */
    public function generateSlug()
    {
        if (empty($this->title)) {
            return;
        }

        // Generate base slug from title
        $baseSlug = Str::slug($this->title);

        // If no slug exists or we're updating, check for uniqueness
        if (empty($this->slug) || $this->isDirty('title')) {
            $this->slug = $this->getUniqueSlug($baseSlug);
        }
    }

    /**
     * Get unique slug
     */
    protected function getUniqueSlug($baseSlug, $count = 0)
    {
        // If count is 0, use base slug, otherwise append number
        $slug = $count > 0 ? $baseSlug . '-' . $count : $baseSlug;

        // Check if slug already exists (excluding current model)
        $query = static::where('slug', $slug);

        // If this is an existing model (update), exclude it from the check
        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }

        // If slug exists, try next number
        if ($query->exists()) {
            return $this->getUniqueSlug($baseSlug, $count + 1);
        }

        return $slug;
    }

    /**
     * Helper method to check if news is published
     */
    public function isPublished()
    {
        return $this->publish === 'yes';
    }

    /**
     * Scopes
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
    
    public function scopePublished($query)
    {
        return $query->where('publish', 'yes');
    }
}