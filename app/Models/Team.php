<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Team extends Model
{
    protected $table = 'team';
    
    protected $fillable = ['name', 'designation_id', 'img', 'email', 'message'];
    
    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }
}