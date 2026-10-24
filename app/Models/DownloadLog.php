<?php

namespace App\Models;

use App\Services\DeviceDetectorService;
use App\Services\GeoLocationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'release_id',
        'version',
        'ip_address',
        'city',
        'state',
        'country',
        'country_code',
        'device_type',
        'os',
        'browser',
        'user_agent',
    ];

    public function release()
    {
        return $this->belongsTo(Release::class);
    }

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
