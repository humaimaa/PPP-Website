<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OngoingProjectDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'project_id',
        'implementing_modality',
        'government_contribution',
        'government_return',
        'private_party_return',
    ];
    
    protected $casts = [
        'government_contribution' => 'decimal:2',
        'government_return' => 'decimal:2',
        'private_party_return' => 'decimal:2',
    ];
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}