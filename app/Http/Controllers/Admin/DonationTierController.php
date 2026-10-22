<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationTier;
use Illuminate\Http\Request;

class DonationTierController extends Controller
{
    /**
     * Display a listing of donation cards / preset tiers
     */
    public function index()
    {
        $tiers = DonationTier::orderBy('sort_order')->orderBy('amount')->get();
        return view('admin.donation-tiers.index', compact('tiers'));
    }

    /**
     * Store a newly created donation card / tier
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:1|max:1000000',
            'name' => 'required|string|max:100',
            'badge' => 'nullable|string|max:50',
            'impact_heading' => 'nullable|string|max:150',
            'impact_text' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? (DonationTier::max('sort_order') + 1));
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');

        // If this tier is marked popular, remove popular flag from others
        if ($validated['is_popular']) {
            DonationTier::where('is_popular', true)->update(['is_popular' => false]);
        }

        DonationTier::create($validated);

        return redirect()->route('admin.donation-tiers.index')->with('success', 'Donation amount card added successfully.');
    }

    /**
     * Update the specified donation card / tier
     */
    public function update(Request $request, DonationTier $donationTier)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:1|max:1000000',
            'name' => 'required|string|max:100',
            'badge' => 'nullable|string|max:50',
            'impact_heading' => 'nullable|string|max:150',
            'impact_text' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_popular' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');

        if ($validated['is_popular']) {
            DonationTier::where('id', '!=', $donationTier->id)->where('is_popular', true)->update(['is_popular' => false]);
        }

        $donationTier->update($validated);

        return redirect()->route('admin.donation-tiers.index')->with('success', 'Donation amount card updated successfully.');
    }

    /**
     * Remove the specified donation card / tier
     */
    public function destroy(DonationTier $donationTier)
    {
        $name = $donationTier->name . ' (₹' . number_format($donationTier->amount) . ')';
        $donationTier->delete();

        return redirect()->route('admin.donation-tiers.index')->with('success', "Donation card '{$name}' removed successfully.");
    }
}
