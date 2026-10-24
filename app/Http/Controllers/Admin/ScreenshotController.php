<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Screenshot;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScreenshotController extends Controller
{
    public function index()
    {
        $screenshots = Screenshot::orderBy('sort_order')->get();
        return view('admin.screenshots', compact('screenshots'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'subtitle' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'image_path' => 'nullable|string|max:255',
        ]);

        $imagePath = $validated['image_path'] ?? null;

        // Handle uploaded file securely
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $ext = strtolower($file->extension() ?: 'jpg');
            if (!in_array($ext, ['jpeg', 'png', 'jpg', 'webp'], true)) {
                $ext = 'jpg';
            }
            $filename = 'ss_' . time() . '_' . Str::random(12) . '.' . $ext;
            $destinationPath = public_path('images/screenshots');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $imagePath = '/images/screenshots/' . $filename;
        }

        if (!$imagePath) {
            return back()->withErrors(['image_file' => 'Please provide an image file or a valid image URL.'])->withInput();
        }

        Screenshot::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'image_path' => $imagePath,
            'sort_order' => $validated['sort_order'],
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.screenshots.index')->with('success', 'Screenshot added successfully!');
    }

    public function toggleFeatured(Screenshot $screenshot)
    {
        $screenshot->update([
            'is_featured' => !$screenshot->is_featured,
        ]);

        return back()->with('success', 'Featured status updated for "' . $screenshot->title . '".');
    }

    public function destroy(Screenshot $screenshot)
    {
        $title = $screenshot->title;
        
        // Secure cleanup: Ensure file is strictly inside public/images/screenshots
        $fullPath = public_path(ltrim($screenshot->image_path, '/'));
        $screenshotsBase = realpath(public_path('images/screenshots'));
        $realFullPath = realpath($fullPath);

        if ($realFullPath && $screenshotsBase && str_starts_with($realFullPath, $screenshotsBase) && str_contains($screenshot->image_path, 'ss_') && file_exists($realFullPath)) {
            @unlink($realFullPath);
        }

        $screenshot->delete();

        return redirect()->route('admin.screenshots.index')->with('success', 'Screenshot "' . $title . '" deleted successfully.');
    }
}
