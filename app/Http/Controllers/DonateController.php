<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Donation;
use App\Models\DonationTier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DonateController extends Controller
{
    /**
     * Display the public donation & sponsorship portal
     */
    public function index()
    {
        $settings = AppSetting::instance();
        $minAmount = max(100, (int)($settings->min_donation_amount ?: 100));

        $totalRaised = Donation::successful()->sum('amount');
        $donorCount  = Donation::successful()->count();
        $recentDonations = Donation::successful()->latest()->take(6)->get();
        $donationTiers   = DonationTier::where('is_active', true)->orderBy('sort_order')->orderBy('amount')->get();

        return view('pages.donate', compact(
            'settings',
            'minAmount',
            'totalRaised',
            'donorCount',
            'recentDonations',
            'donationTiers'
        ));
    }

    /**
     * Record a UPI donation after the donor has paid and submitted their UTR/Transaction ID.
     * No payment gateway involvement — payment goes directly to UPI ID prahladmahor888-3@okaxis.
     * Admin will manually verify the transaction and mark as successful.
     */
    public function recordPayment(Request $request)
    {
        $settings  = AppSetting::instance();
        $minAmount = max(100, (int)($settings->min_donation_amount ?: 100));

        $validated = $request->validate([
            'donor_name'    => 'required|string|min:2|max:100',
            'donor_email'   => 'required|email|max:150',
            'amount'        => 'required|numeric|min:' . $minAmount . '|max:500000',
            'utr_id'        => 'required|string|min:4|max:50',
            'donor_message' => 'nullable|string|max:500',
        ], [
            'donor_name.required'  => 'Please provide your full name.',
            'donor_name.min'       => 'Name must be at least 2 characters.',
            'donor_email.required' => 'A valid email is required for confirmation.',
            'donor_email.email'    => 'Please provide a valid email address.',
            'amount.required'      => 'Please enter or select a donation amount.',
            'amount.min'           => 'Minimum donation amount is ₹' . $minAmount . '.',
            'amount.max'           => 'Maximum allowed single donation is ₹5,00,000.',
            'utr_id.required'      => 'Please enter your UPI Transaction / UTR ID.',
            'utr_id.min'           => 'UTR ID must be at least 4 characters.',
        ]);

        // Prevent duplicate UTR submission
        $duplicate = Donation::where('razorpay_payment_id', trim($validated['utr_id']))->exists();
        if ($duplicate) {
            return response()->json([
                'success' => false,
                'message' => 'This UTR/Transaction ID has already been submitted. Please contact support if this is an error.',
            ], 409);
        }

        $donation = Donation::create([
            'donor_name'          => strip_tags(trim($validated['donor_name'])),
            'donor_email'         => trim(strtolower($validated['donor_email'])),
            'amount'              => $validated['amount'],
            'currency'            => 'INR',
            'message'             => !empty($validated['donor_message']) ? strip_tags(trim($validated['donor_message'])) : null,
            // Reuse razorpay_payment_id column to store UTR for DB compatibility
            'razorpay_payment_id' => trim($validated['utr_id']),
            'razorpay_order_id'   => 'upi_' . time() . '_' . substr(md5($validated['utr_id']), 0, 8),
            'payment_method'      => 'UPI Direct (prahladmahor888-3@okaxis)',
            // Starts as 'pending' — admin verifies manually and marks successful
            'status'              => 'pending',
            'ip_address'          => $request->ip(),
            'user_agent'          => substr((string) $request->userAgent(), 0, 500),
        ]);

        Log::info('UPI donation recorded (pending verification)', [
            'donation_id' => $donation->id,
            'donor'       => $donation->donor_email,
            'amount'      => $donation->amount,
            'utr_id'      => $validated['utr_id'],
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Thank you! Your donation has been recorded and will be verified within 24 hours.',
            'donation'   => [
                'id'          => $donation->id,
                'donor_name'  => $donation->donor_name,
                'donor_email' => $donation->donor_email,
                'amount'      => $donation->formatted_amount ?? ('₹' . number_format($donation->amount)),
                'utr_id'      => $validated['utr_id'],
            ],
        ]);
    }
}

