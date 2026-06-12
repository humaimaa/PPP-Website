<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Download extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 
        'category', 
        'document_path', 
        'date'
    ];
    
    protected $casts = [
        'date' => 'date',
    ];
    
    /**
     * Get document URL attribute
     */
    public function getDocumentUrlAttribute()
    {
        if ($this->document_path && \Storage::disk('public')->exists($this->document_path)) {
            return \Storage::url($this->document_path);
        }
        return null;
    }
    
    /**
     * Get formatted date attribute
     */
    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('F d, Y') : 'N/A';
    }
    
    /**
     * Get category badge color
     */
    public function getCategoryColorAttribute()
    {
        switch ($this->category) {
            case 'Legal Framework':
                return 'purple';
            case 'Prequalified Transaction Advisory':
                return 'blue';
            case 'Policies ,Regulations and Guidelines':
                return 'green';
            case 'Knowledge Hub':
                return 'yellow';
            default:
                return 'gray';
        }
    }
}