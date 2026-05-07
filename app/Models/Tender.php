<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tender extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
        'document',
        'opening_date',
        'closing_date',
        'category',
        'advertisement',
        'is_active',
        'is_archived'
    ];
    
    protected $casts = [
        'opening_date' => 'date',
        'closing_date' => 'date',
        'is_active' => 'boolean',
        'is_archived' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the additional documents for the tender.
     */
    public function additionalDocs()
    {
        return $this->hasMany(TenderAdditionalDoc::class, 'tender_id');
    }
    
    /**
     * Get the additional documents (alias for additionalDocs).
     */
    public function additionalDocuments()
    {
        return $this->hasMany(TenderAdditionalDoc::class, 'tender_id');
    }
    
    /**
     * Check if tender is still open (closing date is in the future).
     */
    public function isOpen()
    {
        return !$this->is_archived && $this->closing_date->isFuture();
    }
    
    /**
     * Check if tender is closed (closing date has passed).
     */
    public function isClosed()
    {
        return $this->closing_date->isPast();
    }
    
    /**
     * Check if tender is opening soon (opening date is in the future).
     */
    public function isUpcoming()
    {
        return $this->opening_date->isFuture();
    }
    
    /**
     * Get the status of the tender.
     */
    public function getStatusAttribute()
    {
        if ($this->is_archived) {
            return 'Archived';
        } elseif ($this->isClosed()) {
            return 'Closed';
        } elseif ($this->isUpcoming()) {
            return 'Upcoming';
        } else {
            return 'Open';
        }
    }
    
    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute()
    {
        if ($this->is_archived) {
            return 'gray';
        } elseif ($this->isClosed()) {
            return 'red';
        } elseif ($this->isUpcoming()) {
            return 'yellow';
        } else {
            return 'green';
        }
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
     * Get advertisement URL.
     */
    public function getAdvertisementUrlAttribute()
    {
        if ($this->advertisement && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->advertisement)) {
            return \Illuminate\Support\Facades\Storage::url($this->advertisement);
        }
        return null;
    }
    
    /**
     * Get formatted opening date.
     */
    public function getFormattedOpeningDateAttribute()
    {
        return $this->opening_date->format('F d, Y');
    }
    
    /**
     * Get formatted closing date.
     */
    public function getFormattedClosingDateAttribute()
    {
        return $this->closing_date->format('F d, Y');
    }
}