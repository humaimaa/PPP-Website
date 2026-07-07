<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Acronym extends Model
{
    use HasFactory;

    protected $fillable = [
        'acronym',
        'standfor',
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('acronyms_list');
        });

        static::deleted(function () {
            Cache::forget('acronyms_list');
        });
    }
}