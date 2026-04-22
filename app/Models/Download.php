<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $fillable = ['title', 'type', 'document_path', 'date'];
    
    protected $casts = [
        'date' => 'date',
    ];
}