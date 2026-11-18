<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = ['visited_on' => 'date', 'created_at' => 'datetime'];
}
