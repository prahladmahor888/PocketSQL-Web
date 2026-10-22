<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReleaseController extends Controller
{
    public function index()
    {
        $releases = Release::orderBy('id', 'desc')->get();
        return view('admin.releases', compact('releases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'version' => 'required|string|max:50',
            'version_code' => 'required|integer|min:1',
            'release_date' => 'nullable|string',
            'apk_size' => 'nullable|string',
            'sha256_hash' => 'nullable|string',
            'changelog' => 'required|string',
            'download_url' => 'nullable|string',
            'is_latest' => 'nullable|boolean',
            'apk_file' => 'nullable|file|max:102400',
        ]);

        $downloadUrl = $validated['download_url'] ?? '/download/apk';
        $apkSize = $validated['apk_size'] ?? null;
        $sha256 = $validated['sha256_hash'] ?? null;

        // Handle uploaded .apk file
        if ($request->hasFile('apk_file')) {
            $file = $request->file('apk_file');
            $cleanVersion = preg_replace('/[^a-zA-Z0-9._-]/', '', $validated['version']);
            $filename = 'PocketSQL-' . $cleanVersion . '-' . time() . '.apk';
            $dest = public_path('downloads/releases');
            
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }

            $file->move($dest, $filename);
            $fullPath = $dest . DIRECTORY_SEPARATOR . $filename;
            $downloadUrl = '/downloads/releases/' . $filename;

            // Automatically compute file size if not provided
            if (empty($apkSize)) {
                $bytes = filesize($fullPath);
                $apkSize = number_format($bytes / (1024 * 1024), 1) . ' MB';
            }

            // Automatically compute SHA-256 hash if not provided
            if (empty($sha256)) {
                $sha256 = hash_file('sha256', $fullPath);
            }
        }

        $isLatest = $request->has('is_latest');
        if ($isLatest) {
            Release::query()->update(['is_latest' => false]);
            
            $settings = AppSetting::instance();
            $settings->update([
                'current_version' => $validated['version'],
                'download_url' => $downloadUrl,
            ]);
        }

        $releaseDate = !empty($validated['release_date'])
            ? $validated['release_date']
            : now()->format('F d, Y');

        $release = Release::create([
            'version' => $validated['version'],
            'version_code' => $validated['version_code'],
            'release_date' => $releaseDate,
            'apk_size' => $apkSize ?? '12.4 MB',
            'sha256_hash' => $sha256 ?? hash('sha256', Str::random(32)),
            'changelog' => $validated['changelog'],
            'download_url' => $downloadUrl,
            'is_latest' => $isLatest,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'New release "' . $release->version . '" published successfully.',
                'release' => [
                    'id' => $release->id,
                    'version' => $release->version,
                    'version_code' => $release->version_code,
                    'release_date' => $release->release_date,
                    'apk_size' => $release->apk_size,
                    'downloads_count' => (int) ($release->downloads_count ?? 0),
                    'is_latest' => (bool) $release->is_latest,
                    'download_url' => $release->download_url,
                ],
            ]);
        }

        return redirect()->route('admin.releases.index')->with('success', 'New release and APK package published successfully.');
    }

    public function destroy(Request $request, Release $release)
    {
        $wasLatest = $release->is_latest;
        $version = $release->version;
        $release->delete();

        $nextLatest = null;
        if ($wasLatest) {
            $nextLatest = Release::orderBy('id', 'desc')->first();
            if ($nextLatest) {
                $nextLatest->update(['is_latest' => true]);
                AppSetting::instance()->update([
                    'current_version' => $nextLatest->version,
                    'version_code' => $nextLatest->version_code,
                ]);
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Release "' . $version . '" deleted successfully.',
                'next_latest_id' => $nextLatest ? $nextLatest->id : null,
            ]);
        }

        return redirect()->route('admin.releases.index')->with('success', 'Release "' . $version . '" deleted successfully.');
    }
}
