<?php

namespace App\Models;

use App\Services\DeviceDetectorService;
use App\Services\GeoLocationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'city',
        'state',
        'country',
        'country_code',
        'device_type',
        'os',
        'browser',
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

    /**
     * Nicely formatted location (e.g., "Gwalior, MP, India")
     */
    public function getFormattedLocationAttribute(): string
    {
        return GeoLocationService::formatLocation($this->city, $this->state, $this->country);
    }

    /**
     * Country Flag image URL
     */
    public function getFlagUrlAttribute(): ?string
    {
        return GeoLocationService::getFlagUrl($this->country_code);
    }

    /**
     * Country Flag Retina image URL
     */
    public function getFlagRetinaUrlAttribute(): ?string
    {
        return GeoLocationService::getFlagRetinaUrl($this->country_code);
    }

    /**
     * Fallback Unicode Flag Emoji
     */
    public function getFlagEmojiAttribute(): string
    {
        return GeoLocationService::getFlagEmoji($this->country_code);
    }

    /**
     * Parsed Device Metadata (Type, OS, Browser, Icons)
     */
    public function getDeviceInfoAttribute(): array
    {
        $parsed = DeviceDetectorService::parse($this->user_agent);

        if (!empty($this->device_type)) {
            $parsed['device_type'] = $this->device_type;
        }
        if (!empty($this->os)) {
            $parsed['os'] = $this->os;
        }
        if (!empty($this->browser)) {
            $parsed['browser'] = $this->browser;
        }

        return $parsed;
    }
}
