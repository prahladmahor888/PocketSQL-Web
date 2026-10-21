<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'method_name',
        'account_identifier',
        'qr_image_path',
        'payment_url',
        'instructions',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
