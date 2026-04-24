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
    
    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }
}