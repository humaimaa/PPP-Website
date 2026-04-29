<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'sector',
        'implementing_authority',
        'location',
        'cost',
        'status',
        'overview'
    ];

    protected $casts = [
        'cost' => 'decimal:2',
    ];

    /**
     * Get the ongoing project details.
     */
    public function ongoingDetails()
    {
        return $this->hasOne(OngoingProjectDetail::class, 'project_id');
    }

    /**
     * Get the completed project details.
     */
    public function completedDetails()
    {
        return $this->hasOne(CompletedProjectDetail::class, 'project_id');
    }

    /**
     * Check if project has ongoing details
     */
    public function isOngoing()
    {
        return $this->ongoingDetails()->exists();
    }

    /**
     * Check if project has completed details
     */
    public function isCompleted()
    {
        return $this->completedDetails()->exists();
    }
}