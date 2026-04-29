<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document',
        'opening_date',
        'closing_date',
        'advertisement'
    ];

    protected $casts = [
        'opening_date' => 'date',
        'closing_date' => 'date',
    ];

    /**
     * Get the additional documents for the tender.
     */
    public function additionalDocuments()
{
    return $this->hasMany(TenderAdditionalDoc::class);
}
}