<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'method',
        'path',
        'status_code',
        'user_agent',
        'response_time_ms',
        'is_blocked',
        'created_at',
    ];

    protected $casts = [
        'status_code' => 'integer',
        'response_time_ms' => 'integer',
        'is_blocked' => 'boolean',
        'created_at' => 'datetime',
    ];
}
