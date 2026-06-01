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
     * Get the leadership messages for this designation
     */
    public function leadershipMessages()
    {
        return $this->hasMany(LeadershipMessage::class);
    }

    /**
     * Get the staff members with this designation
     */
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    /**
     * Check if designation is being used anywhere
     */
    public function isUsed()
    {
        return $this->leadershipMessages()->exists() || $this->staff()->exists();
    }

    /**
     * Get usage details
     */
    public function getUsageDetails()
    {
        $usage = [];
        
        $leadershipCount = $this->leadershipMessages()->count();
        if ($leadershipCount > 0) {
            $usage[] = $leadershipCount . ' leadership message(s)';
        }
        
        $staffCount = $this->staff()->count();
        if ($staffCount > 0) {
            $usage[] = $staffCount . ' staff member(s)';
        }
        
        return implode(' and ', $usage);
    }
}