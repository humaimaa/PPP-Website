<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Designation extends Model
{
    protected $fillable = ['title'];
    
    public function teamMembers(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}