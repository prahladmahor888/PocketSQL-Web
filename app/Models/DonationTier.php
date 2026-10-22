<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationTier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'badge',
        'impact_heading',
        'impact_text',
        'sort_order',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'integer',
        'sort_order' => 'integer',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getFormattedAmountAttribute(): string
    {
        return '₹' . number_format($this->amount);
    }

    protected static function booted()
    {
        static::saved(function () {
            cache()->forget('active_donation_tiers');
        });

        static::deleted(function () {
            cache()->forget('active_donation_tiers');
        });
    }
}
