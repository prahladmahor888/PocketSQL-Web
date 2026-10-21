<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'donor_email',
        'amount',
        'currency',
        'message',
        'payment_method',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope for successful transactions
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'successful');
    }

    /**
     * Scope for pending transactions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for failed transactions
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Formatted amount in INR (e.g. ₹500.00)
     */
    public function getFormattedAmountAttribute(): string
    {
        return '₹' . number_format($this->amount, 2);
    }

    /**
     * Human readable date and time
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->format('d M Y, h:i A') : 'N/A';
    }

    /**
     * Display icon/class for payment method
     */
    public function getMethodIconAttribute(): string
    {
        $m = strtolower($this->payment_method ?? '');
        if (str_contains($m, 'upi')) return 'fa-solid fa-mobile-screen-button';
        if (str_contains($m, 'card')) return 'fa-solid fa-credit-card';
        if (str_contains($m, 'netbanking') || str_contains($m, 'bank')) return 'fa-solid fa-building-columns';
        if (str_contains($m, 'wallet')) return 'fa-solid fa-wallet';
        if (str_contains($m, 'paypal')) return 'fa-brands fa-paypal';
        return 'fa-solid fa-money-check-dollar';
    }
}
