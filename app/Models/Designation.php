<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'order'
    ];

    /**
     * Get the team members with this designation
     */
    public function team()
    {
        return $this->hasMany(Team::class, 'designation_id');
    }

    /**
     * Check if designation is being used anywhere
     * Only check team table (leadership_messages uses ENUM, not foreign key)
     */
    public function isUsed()
    {
        return $this->team()->exists();
    }

    /**
     * Get usage details
     */
    public function getUsageDetails()
    {
        $usage = [];
        
        $teamCount = $this->team()->count();
        if ($teamCount > 0) {
            $usage[] = $teamCount . ' team member(s)';
        }
        
        return implode(' and ', $usage);
    }
}