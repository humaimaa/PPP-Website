<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'location',
        'description',
        'event_date',
        'publish', // Add this
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    protected function slugSourceColumn(): string
    {
        return 'title';
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

    /**
     * Boot method to handle file deletion.
     */
    protected static function boot()
    {
        parent::boot();

        // Delete all gallery images when event is deleted
        static::deleting(function ($event) {
            foreach ($event->gallery as $gallery) {
                $gallery->delete();
            }
        });
    }
}