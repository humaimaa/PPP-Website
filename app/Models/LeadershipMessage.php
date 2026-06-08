<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadershipMessage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'designation',
        'message',
        'image',
    ];
    
    // Define the enum values as a constant
    const DESIGNATIONS = [
        'Chief Minister',
        'Chief Secretary',
        'Chief Secretary Development',
        'Secretary P&D',
        'Chief PPP'
    ];
    
    // Cast designation to ensure it's always a string
    protected $casts = [
        'designation' => 'string',
    ];
    
    /**
     * Get all possible designation values
     */
    public static function getDesignations()
    {
        return self::DESIGNATIONS;
    }
    
    /**
     * Check if a designation is valid
     */
    public static function isValidDesignation($designation)
    {
        return in_array($designation, self::DESIGNATIONS);
    }
}