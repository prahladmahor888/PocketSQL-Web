<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display all community donations with financial statistics and filters
     */
    public function index(Request $request)
    {
        $query = Donation::query()->latest();

        // 1. Status Filter
        if ($request->filled('status') && in_array($request->status, ['successful', 'pending', 'failed'])) {
            $query->where('status', $request->status);
        }

        // 2. Search by Donor Name, Email, or Transaction IDs
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                  ->orWhere('donor_email', 'like', "%{$search}%")
                  ->orWhere('razorpay_payment_id', 'like', "%{$search}%")
                  ->orWhere('razorpay_order_id', 'like', "%{$search}%");
            });
        }

        $donations = $query->paginate(15)->withQueryString();

        // Aggregate statistics
        $totalCollected = Donation::successful()->sum('amount');
        $successfulCount = Donation::successful()->count();
        $pendingCount = Donation::pending()->count();
        $todayCollected = Donation::successful()->whereDate('created_at', today())->sum('amount');
        $averageDonation = $successfulCount > 0 ? ($totalCollected / $successfulCount) : 0;

        return view('admin.donations.index', compact(
            'donations',
            'totalCollected',
            'successfulCount',
            'pendingCount',
            'todayCollected',
            'averageDonation'
        ));
    }

    /**
     * Delete an individual donation record
     */
    public function destroy(Donation $donation)
    {
        $donorName = $donation->donor_name;
        $donation->delete();

        return redirect()->route('admin.donations.index')
            ->with('status', "Donation record for '{$donorName}' has been deleted.");
    }
}
