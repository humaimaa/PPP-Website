<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'sector',
        'implementing_authority',
        'location',
        'cost',
        'status',
        'overview',
        'image',
        'division',
        'category',
    ];
    

    
    public function ongoingDetail()
    {
        return $this->hasOne(OngoingProjectDetail::class);
    }
    
    public function completedDetail()
    {
        return $this->hasOne(CompletedProjectDetail::class);
    }
}