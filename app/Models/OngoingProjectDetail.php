<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OngoingProjectDetail extends Model
{
    use HasFactory;

    protected $table = 'ongoing_project_details';

    protected $fillable = [
        'project_id',
        'implementing_modality',
        'government_contribution',
        'government_return',
        'private_party_return'
    ];

    protected $casts = [
        'government_contribution' => 'decimal:2',
        'government_return' => 'decimal:2',
        'private_party_return' => 'decimal:2',
    ];

    /**
     * Get the project that owns the ongoing details.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}