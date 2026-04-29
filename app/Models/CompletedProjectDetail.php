<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedProjectDetail extends Model
{
    use HasFactory;

    protected $table = 'completed_project_details';

    protected $fillable = [
        'project_id',
        'scope',
        'cost_financing_mix',
        'project_timeline',
        'expected_financial_benefits_to_government'
    ];

    /**
     * Get the project that owns the completed details.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}