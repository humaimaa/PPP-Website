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
        'designation_id',
        'img',
        'email',
        'phone',
    ];
    
    /**
     * Get the designation associated with the team member.
     */
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}