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
    
    // Cast designation to ensure it's always a string
    protected $casts = [
        'designation' => 'string',
    ];
    
    /**
     * List of all valid designations
     */
    const DESIGNATIONS = [
        'Chief Minister / Chairman of PPP Committee',
        'Chief Secretary',
        'Additional Chief Secretary Development / Chairman of PDF Committee',
        'Secretary P&D / Chairman of PPP Unit',
        'Chief PPP'
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