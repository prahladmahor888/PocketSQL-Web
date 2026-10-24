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

        // Normalize icon and sanitize against XSS
        $icon = trim($validated['icon_svg'] ?? '');
        $validated['icon_svg'] = $this->sanitizeIconSvg($icon, $platform);

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
        $validated['icon_svg'] = $this->sanitizeIconSvg($icon, $platform);

        $socialLink->update($validated);

        return redirect()->route('admin.social-links.index')->with('success', 'Social channel updated successfully.');
    }

    /**
     * Sanitize SVG markup or convert class shorthand
     */
    protected function sanitizeIconSvg(string $icon, string $platform): string
    {
        if (empty($icon)) {
            return 'fa-brands fa-' . $platform;
        }

        if (str_contains($icon, '<svg')) {
            // Strip dangerous tags and javascript event handlers from SVG markup
            $sanitized = preg_replace('/<\s*(script|iframe|object|embed|applet|meta|link)[^>]*>.*?<\s*\/\s*\1\s*>/is', '', $icon);
            $sanitized = preg_replace('/<\s*(script|iframe|object|embed|applet|meta|link)[^>]*>/is', '', $sanitized);
            $sanitized = preg_replace('/\s*on[a-zA-Z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $sanitized);
            $sanitized = preg_replace('/\s*(href|xlink:href)\s*=\s*("javascript:[^"]*"|\'javascript:[^\']*\'|javascript:[^\s>]+)/i', '', $sanitized);
            return trim($sanitized);
        }

        if (!str_contains($icon, ' ')) {
            $clean = str_starts_with($icon, 'fa-') ? substr($icon, 3) : $icon;
            $solids = ['globe', 'phone', 'envelope', 'mail', 'link', 'location', 'map', 'comment', 'chat', 'paper-plane', 'headset', 'share-nodes'];
            if (in_array(strtolower($clean), $solids)) {
                return 'fa-solid fa-' . (strtolower($clean) === 'mail' ? 'envelope' : strtolower($clean));
            }
            return 'fa-brands fa-' . strtolower($clean);
        }

        return $icon;
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
