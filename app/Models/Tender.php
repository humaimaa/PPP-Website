<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tender extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'document',
        'opening_date',
        'closing_date',
        'extended_closing_date',
        'category',
        'advertisement',
    ];
    
    protected $casts = [
        'opening_date' => 'date',
        'closing_date' => 'date',
        'extended_closing_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the effective closing date (extended if exists, otherwise original)
     */
    public function getEffectiveClosingDateAttribute()
    {
        return $this->extended_closing_date ?? $this->closing_date;
    }
    
    /**
     * Get the original closing date
     */
    public function getOriginalClosingDateAttribute()
    {
        return $this->closing_date;
    }
    
    /**
     * Check if closing date has been extended
     */
    public function getIsExtendedAttribute()
    {
        return !is_null($this->extended_closing_date) && 
               $this->extended_closing_date->gt($this->closing_date);
    }
    
    /**
     * Get days remaining for tender (using effective closing date)
     */
    public function getDaysRemainingAttribute()
    {
        $effectiveDate = $this->effective_closing_date;
        
        if (!$effectiveDate) {
            return null;
        }
        
        $now = now()->startOfDay();
        
        if ($effectiveDate->isPast()) {
            return 0;
        }
        
        // Return integer days (floor the difference)
        return floor($now->diffInDays($effectiveDate, false));
    }
    
    /**
     * Get days remaining text
     */
    public function getDaysRemainingTextAttribute()
    {
        $days = $this->days_remaining;
        
        if ($days === null) {
            return 'No closing date';
        }
        
        if ($days <= 0) {
            return 'Closed';
        }
        
        if ($days == 1) {
            return '1 day left';
        }
        
        return $days . ' days left';
    }
    
    /**
     * Check if tender is still open (effective closing date is in the future)
     */
    public function isOpen()
    {
        $effectiveDate = $this->effective_closing_date;
        return $effectiveDate && $effectiveDate->isFuture();
    }
    
    /**
     * Check if tender is closed (effective closing date has passed)
     */
    public function isClosed()
    {
        $effectiveDate = $this->effective_closing_date;
        return $effectiveDate && $effectiveDate->isPast();
    }
    
    /**
     * Check if tender is opening soon (opening date is in the future)
     */
    public function isUpcoming()
    {
        return $this->opening_date->isFuture();
    }
    
    /**
     * Get the status of the tender (using effective closing date)
     */
    public function getStatusAttribute()
    {
        if ($this->isClosed()) {
            return 'Closed';
        } elseif ($this->isUpcoming()) {
            return 'Upcoming';
        } else {
            return 'Open';
        }
    }
    
    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        if ($this->isClosed()) {
            return 'red';
        } elseif ($this->isUpcoming()) {
            return 'yellow';
        } else {
            return 'green';
        }
    }
    
    /**
     * Get document URL
     */
    public function getDocumentUrlAttribute()
    {
        if ($this->document && Storage::disk('public')->exists($this->document)) {
            return Storage::url($this->document);
        }
        return null;
    }
    
    /**
     * Get advertisement URL
     */
    public function getAdvertisementUrlAttribute()
    {
        if ($this->advertisement && Storage::disk('public')->exists($this->advertisement)) {
            return Storage::url($this->advertisement);
        }
        return null;
    }
    
    /**
     * Get formatted opening date
     */
    public function getFormattedOpeningDateAttribute()
    {
        return $this->opening_date->format('F d, Y');
    }
    
    /**
     * Get formatted closing date (original)
     */
    public function getFormattedClosingDateAttribute()
    {
        return $this->closing_date->format('F d, Y');
    }
    
    /**
     * Get formatted effective closing date
     */
    public function getFormattedEffectiveClosingDateAttribute()
    {
        if ($this->effective_closing_date) {
            return $this->effective_closing_date->format('F d, Y');
        }
        return 'N/A';
    }
    
    /**
     * Get the additional documents for the tender
     */
    public function additionalDocs()
    {
        return $this->hasMany(TenderAdditionalDoc::class, 'tender_id');
    }
    
    /**
     * Get the additional documents (alias for additionalDocs)
     */
    public function additionalDocuments()
    {
        return $this->hasMany(TenderAdditionalDoc::class, 'tender_id');
    }
}