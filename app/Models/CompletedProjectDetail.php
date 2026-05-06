<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedProjectDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'project_id',
        'scope',
        'cost_financing_mix',
        'project_timeline',
        'expected_financial_benefits_to_government',
    ];
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}