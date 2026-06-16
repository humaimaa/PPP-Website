<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hierarchy extends Model
{
    use HasFactory;

    protected $table = 'hierarchy'; // Explicitly specify table name

    protected $fillable = [
        'title',
        'order'
    ];

    /**
     * Get the team members with this hierarchy entry
     */
    public function team()
    {
        return $this->hasMany(Team::class, 'hierarchy_id'); // Changed foreign key
    }

    /**
     * Check if hierarchy entry is being used anywhere
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