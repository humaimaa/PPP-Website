<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $table = 'gallery';
    
    protected $fillable = ['event_id', 'image', 'is_thumbnail'];
    
    protected $casts = [
        'is_thumbnail' => 'boolean',
    ];
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}