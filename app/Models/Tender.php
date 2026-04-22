<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $fillable = [
        'name', 'document', 'opening_date', 
        'closing_date', 'advertisement', 'extended_date'
    ];
    
    protected $casts = [
        'opening_date' => 'date',
        'closing_date' => 'date',
        'extended_date' => 'date',
    ];
}