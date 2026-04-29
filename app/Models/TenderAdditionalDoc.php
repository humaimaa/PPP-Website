<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderAdditionalDoc extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel convention
    protected $table = 'tender_additional_docs';

    protected $fillable = [
        'tender_id',
        'title',
        'publish_date',
        'document'
    ];

    protected $casts = [
        'publish_date' => 'date',
    ];

    /**
     * Get the tender that owns the additional document.
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}