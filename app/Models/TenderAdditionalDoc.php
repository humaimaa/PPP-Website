<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderAdditionalDoc extends Model
{
    use HasFactory;
    
    protected $table = 'tender_additional_docs';
    
    protected $fillable = [
        'tender_id',
        'title',
        'publish_date',
        'document',
    ];
    
    protected $casts = [
        'publish_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the tender that owns the additional document.
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }
    
    /**
     * Get document URL.
     */
    public function getDocumentUrlAttribute()
    {
        if ($this->document && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->document)) {
            return \Illuminate\Support\Facades\Storage::url($this->document);
        }
        return null;
    }
    
    /**
     * Get formatted publish date.
     */
    public function getFormattedPublishDateAttribute()
    {
        return $this->publish_date->format('d M Y');
    }
    
    /**
     * Scope for documents by tender
     */
    public function scopeForTender($query, $tenderId)
    {
        return $query->where('tender_id', $tenderId);
    }
    
    /**
     * Scope ordered by publish date descending
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('publish_date', 'desc');
    }
}