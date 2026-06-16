<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    
    protected $table = 'team';
    
    protected $fillable = [
        'name',
        'hierarchy_id', // Changed from designation_id
        'designation', // New field
        'img',
        'email',
        'phone',
    ];
    
    /**
     * Get the hierarchy associated with the team member.
     */
    public function hierarchy() // Changed from designation()
    {
        return $this->belongsTo(Hierarchy::class, 'hierarchy_id');
    }
    
    /**
     * Get the designation title directly from the column.
     * This is a helper method for backward compatibility.
     */
    public function getDesignationTitleAttribute()
    {
        return $this->designation;
    }
}