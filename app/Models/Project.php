<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'sector',
        'implementing_authority',
        'location',
        'cost',
        'status',
        'overview',
        'image',
        'division',
        'category',
        'publish',
    ];
    
    // Boot method to handle model events
    protected static function boot()
    {
        parent::boot();
        
        // Generate slug when creating a new project
        static::creating(function ($project) {
            $project->generateSlug();
        });
        
        // Regenerate slug when updating the name
        static::updating(function ($project) {
            if ($project->isDirty('name')) {
                $project->generateSlug();
            }
        });
    }
    
    // Generate slug from name
    public function generateSlug()
    {
        if (empty($this->name)) {
            return;
        }
        
        // Generate base slug from name
        $baseSlug = Str::slug($this->name);
        
        // If no slug exists or we're updating, check for uniqueness
        if (empty($this->slug) || $this->isDirty('name')) {
            $this->slug = $this->getUniqueSlug($baseSlug);
        }
    }
    
    // Get unique slug
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
    
    // Helper method to check if published
    public function isPublished()
    {
        return $this->publish === 'yes';
    }
    
    // Relationships
    public function ongoingDetail()
    {
        return $this->hasOne(OngoingProjectDetail::class);
    }
    
    public function completedDetail()
    {
        return $this->hasOne(CompletedProjectDetail::class);
    }
}