<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $guarded = [];

    protected $casts = ['mail_sent' => 'boolean'];

    public const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'qualified' => 'Qualified',
        'won' => 'Won',
        'lost' => 'Lost',
    ];

    public function getWaLinkAttribute(): string
    {
        return 'https://wa.me/'.preg_replace('/\D/', '', $this->phone);
    }
}
