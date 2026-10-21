<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'release_id',
        'version',
        'ip_address',
        'user_agent',
    ];

    public function release()
    {
        return $this->belongsTo(Release::class);
    }
}
