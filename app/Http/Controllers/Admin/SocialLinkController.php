<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of social channels and links
     */
    public function index()
    {
        $socialLinks = SocialLink::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.social-links.index', compact('socialLinks'));
    }

    /**
     * Store a newly created social link
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:50',
            'label' => 'required|string|max:100',
            'url' => 'required|url|max:255',
            'icon_svg' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $platform = strtolower(trim($validated['platform']));
        $validated['platform'] = $platform;
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? (SocialLink::max('sort_order') + 1));
        $validated['is_active'] = $request->has('is_active');

        // Normalize icon: cleanly accept full FontAwesome class, shorthand, or plain name
        $icon = trim($validated['icon_svg'] ?? '');
        if (empty($icon)) {
            $icon = 'fa-brands fa-' . $platform;
        } elseif (!str_contains($icon, '<svg')) {
            if (!str_contains($icon, ' ')) {
                // If single token like "fa-instagram" or "instagram"
                $clean = str_starts_with($icon, 'fa-') ? substr($icon, 3) : $icon;
                $solids = ['globe', 'phone', 'envelope', 'mail', 'link', 'location', 'map', 'comment', 'chat', 'paper-plane', 'headset', 'share-nodes'];
                if (in_array(strtolower($clean), $solids)) {
                    $icon = 'fa-solid fa-' . (strtolower($clean) === 'mail' ? 'envelope' : strtolower($clean));
                } else {
                    $icon = 'fa-brands fa-' . strtolower($clean);
                }
            }
        }
        $validated['icon_svg'] = $icon;

        SocialLink::create($validated);

        return redirect()->route('admin.social-links.index')->with('success', 'Social channel added successfully.');
    }

    /**
     * Update the specified social link
     */
    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:50',
            'label' => 'required|string|max:100',
            'url' => 'required|url|max:255',
            'icon_svg' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $platform = strtolower(trim($validated['platform']));
        $validated['platform'] = $platform;
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->has('is_active');

        $icon = trim($validated['icon_svg'] ?? '');
        if (empty($icon)) {
            $icon = 'fa-brands fa-' . $platform;
        } elseif (!str_contains($icon, '<svg')) {
            if (!str_contains($icon, ' ')) {
                $clean = str_starts_with($icon, 'fa-') ? substr($icon, 3) : $icon;
                $solids = ['globe', 'phone', 'envelope', 'mail', 'link', 'location', 'map', 'comment', 'chat', 'paper-plane', 'headset', 'share-nodes'];
                if (in_array(strtolower($clean), $solids)) {
                    $icon = 'fa-solid fa-' . (strtolower($clean) === 'mail' ? 'envelope' : strtolower($clean));
                } else {
                    $icon = 'fa-brands fa-' . strtolower($clean);
                }
            }
        }
        $validated['icon_svg'] = $icon;

        $socialLink->update($validated);

        return redirect()->route('admin.social-links.index')->with('success', 'Social channel updated successfully.');
    }

    /**
     * Remove the specified social link
     */
    public function destroy(SocialLink $socialLink)
    {
        $platform = $socialLink->label ?: $socialLink->platform;
        $socialLink->delete();

        return redirect()->route('admin.social-links.index')->with('success', "Social link '{$platform}' deleted successfully.");
    }
}
