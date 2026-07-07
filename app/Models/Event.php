<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'location',
        'description',
        'event_date',
        'publish',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Generate slug when creating a new event
        static::creating(function ($event) {
            $event->generateSlug();
        });

        // Regenerate slug when updating the title
        static::updating(function ($event) {
            if ($event->isDirty('title')) {
                $event->generateSlug();
            }
        });

        // Delete all gallery images when event is deleted
        static::deleting(function ($event) {
            foreach ($event->gallery as $gallery) {
                $gallery->delete();
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
     * Helper method to check if event is published
     */
    public function isPublished()
    {
        return $this->publish === 'yes';
    }

    /**
     * Scope for published events
     */
    public function scopePublished($query)
    {
        return $query->where('publish', 'yes');
    }

    /**
     * Get the gallery images for the event.
     */
    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Get the thumbnail image.
     */
    public function thumbnail()
    {
        return $this->hasOne(Gallery::class)->where('is_thumbnail', true);
    }
}