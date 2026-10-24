<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\DownloadLog;
use App\Models\Release;
use App\Services\DeviceDetectorService;
use App\Services\GeoLocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller
{
    public function index()
    {
        $settings = AppSetting::instance();

        $pageData = cache()->remember('download_page_data_v1', 300, function () use ($settings) {
            $latestRelease = Release::where('is_latest', true)->first() ?? Release::orderBy('id', 'desc')->first();
            $previousReleases = Release::where('is_latest', false)->orderBy('id', 'desc')->get();
            $totalDownloads = max((int) Release::sum('downloads_count'), (int) DownloadLog::count(), (int) ($settings->total_downloads_count ?? 0));

            return compact('latestRelease', 'previousReleases', 'totalDownloads');
        });

        return view('pages.download', array_merge(['settings' => $settings], $pageData));
    }

    /**
     * Handle APK file download and count server-side exactly once per download request.
     */
    public function downloadApk(Request $request, ?int $release = null)
    {
        // Find targeted release or default to latest
        $targetRelease = null;
        if ($release) {
            $targetRelease = Release::find($release);
        }
        if (!$targetRelease) {
            $targetRelease = Release::where('is_latest', true)->first() ?? Release::orderBy('id', 'desc')->first();
        }

        // Server-side download count tracking: 1 request = 1 count
        if ($targetRelease) {
            $clientIp = GeoLocationService::getClientIp($request);
            $location = GeoLocationService::resolve($clientIp);
            $ua = (string) $request->userAgent();
            $device = DeviceDetectorService::parse($ua);

            DB::transaction(function () use ($targetRelease, $clientIp, $location, $ua, $device) {
                // Increment release downloads count
                $targetRelease->increment('downloads_count');
                
                // Increment global app downloads count
                $settings = AppSetting::instance();
                $settings->increment('total_downloads_count');

                // Record detailed log entry with IP, location, flag, and device
                DownloadLog::create([
                    'release_id' => $targetRelease->id,
                    'version' => $targetRelease->version,
                    'ip_address' => $clientIp,
                    'city' => $location['city'] ?? null,
                    'state' => $location['region'] ?? null,
                    'country' => $location['country'] ?? null,
                    'country_code' => $location['countryCode'] ?? null,
                    'device_type' => $device['device_type'] ?? null,
                    'os' => $device['os'] ?? null,
                    'browser' => $device['browser'] ?? null,
                    'user_agent' => substr($ua, 0, 500),
                ]);
            });
        }

        // 1. Check if the targeted release has a specific uploaded APK file
        if ($targetRelease && $targetRelease->download_url && str_starts_with($targetRelease->download_url, '/downloads/')) {
            $releaseApkPath = public_path(ltrim($targetRelease->download_url, '/'));
            $downloadsBase = realpath(public_path('downloads'));
            $realApkPath = realpath($releaseApkPath);

            // Path traversal protection: Ensure file exists and is strictly inside public/downloads directory
            if ($realApkPath && $downloadsBase && str_starts_with($realApkPath, $downloadsBase) && file_exists($realApkPath)) {
                $filename = 'PocketSQL-' . preg_replace('/[^a-zA-Z0-9._-]/', '', $targetRelease->version) . '.apk';
                return response()->download($realApkPath, $filename, [
                    'Content-Type' => 'application/vnd.android.package-archive',
                    'Cache-Control' => 'no-store, no-cache, must-revalidate',
                ]);
            }
        }

        // 2. Default bundled sample APK package
        $defaultApkPath = public_path('downloads/PocketSQL-v1.0.5.apk');
        if (file_exists($defaultApkPath)) {
            $filename = $targetRelease ? 'PocketSQL-' . $targetRelease->version . '.apk' : 'PocketSQL-v1.0.5.apk';
            return response()->download($defaultApkPath, $filename, [
                'Content-Type' => 'application/vnd.android.package-archive',
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
            ]);
        }

        if ($targetRelease && $targetRelease->download_url && $targetRelease->download_url !== '/download/apk') {
            return redirect()->away($targetRelease->download_url);
        }

        return redirect()->route('download')->with('error', 'Download package is temporarily unavailable.');
    }
}
