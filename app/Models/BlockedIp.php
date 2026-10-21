<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedIp extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'reason',
        'blocked_until',
    ];

    protected $casts = [
        'blocked_until' => 'datetime',
    ];

    protected static function booted()
    {
        static::saved(function ($model) {
            cache()->forget("ip_blocked_{$model->ip_address}");
            cache()->forget('traffic_blocked_ips_list');
        });

        static::deleted(function ($model) {
            cache()->forget("ip_blocked_{$model->ip_address}");
            cache()->forget('traffic_blocked_ips_list');
        });
    }

    /**
     * Check if a given IP address is currently blocked (cached for high performance)
     */
    public static function isIpBlocked(string $ip): bool
    {
        return cache()->remember("ip_blocked_{$ip}", 30, function () use ($ip) {
            $block = static::where('ip_address', $ip)->first();

            if (!$block) {
                return false;
            }

            if ($block->blocked_until && $block->blocked_until->isPast()) {
                $block->delete();
                return false;
            }

            return true;
        });
    }

    /**
     * Helper to quickly block an IP address
     */
    public static function blockIp(string $ip, string $reason, int $hours = 24): self
    {
        $record = static::updateOrCreate(
            ['ip_address' => $ip],
            [
                'reason' => $reason,
                'blocked_until' => now()->addHours($hours),
            ]
        );

        cache()->forget("ip_blocked_{$ip}");
        cache()->forget('traffic_blocked_ips_list');

        return $record;
    }
}
