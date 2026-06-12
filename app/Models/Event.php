<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = ['title', 'location', 'description', 'event_date'];
    
    protected $casts = [
        'event_date' => 'date',
    ];
    
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
    
    // Get the thumbnail image
    public function thumbnail()
    {
        return $this->hasOne(Gallery::class)->where('is_thumbnail', true);
    }
    
    // Get the image count
    public function getGalleriesCountAttribute()
    {
        return $this->galleries()->count();
    }
    
    // Get thumbnail URL (accessor)
    public function getThumbnailUrlAttribute()
    {
        // First try to get the thumbnail marked image
        $thumbnail = $this->thumbnail;
        if ($thumbnail && $thumbnail->image) {
            return asset('storage/' . $thumbnail->image);
        }
        
        // If no thumbnail marked, get the first image from gallery
        $firstImage = $this->galleries()->first();
        if ($firstImage && $firstImage->image) {
            return asset('storage/' . $firstImage->image);
        }
        
        // Return null if no images found
        return null;
    }
}