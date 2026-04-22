<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadershipMessage extends Model
{
    protected $fillable = ['name', 'designation', 'message'];
}