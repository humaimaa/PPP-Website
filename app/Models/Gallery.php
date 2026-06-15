<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $table = 'gallery';
    
    protected $fillable = ['event_id', 'image', 'is_thumbnail'];
    
    protected $casts = [
        'is_thumbnail' => 'boolean',
    ];
    
    /**
     * Get the event that owns the gallery image.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    
    /**
     * Boot method to handle file deletion automatically.
     */
    protected static function boot()
    {
        parent::boot();
        
        // Delete the physical image file when the gallery record is deleted
        static::deleting(function ($gallery) {
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
        });
    }
    
    /**
     * Get the full URL for the image.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }
        return null;
    }
    
    /**
     * Delete the image file manually if needed.
     */
    public function deleteImageFile()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            Storage::disk('public')->delete($this->image);
        }
    }
}