<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sector extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'img',
        'tagline'
    ];

    // Automatically generate slug when creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sector) {
            if (empty($sector->slug)) {
                $sector->slug = Str::slug($sector->name);
            }
        });

        static::updating(function ($sector) {
            if ($sector->isDirty('name') && empty($sector->slug)) {
                $sector->slug = Str::slug($sector->name);
            }
        });
    }

    // Route binding using slug instead of ID
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    // Relationship with projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}