<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'location',
        'description',
        'event_date',
    ];
    
    protected $casts = [
        'event_date' => 'date',
    ];
    
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
                // This will trigger the Gallery's deleting event
                $gallery->delete();
            }
        });
    }
}