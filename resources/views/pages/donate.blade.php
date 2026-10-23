<x-layout title="Community Support &amp; Donations — Sponsor PocketSQL"
          description="Support PocketSQL independent native Android SQL database development. Donate securely via UPI — scan QR code with any UPI app like GPay, PhonePe, Paytm, or BHIM.">

    <!-- Page Header (Clean, Light Theme matching About & Features) -->
    <div class="bg-slate-50 border-b border-slate-200 py-12 sm:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-[8px] bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold">
                    <i class="fa-solid fa-heart text-blue-600 mr-1.5"></i>
                    Open Source Community Sponsorship
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Sponsor PocketSQL Development
            </h1>

            <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed">
                PocketSQL is 100% free, offline-first, and MIT open-source. Your contribution keeps the project independent, funds Android test hardware, and powers ongoing engine optimizations.
            </p>

            <!-- Metrics Bar -->
            <div class="inline-flex flex-wrap items-center justify-center gap-3 pt-2 text-xs">
                <div class="flex items-center space-x-2 bg-white px-3.5 py-1.5 rounded-[8px] border border-slate-200 text-slate-700 shadow-2xs">
                    <i class="fa-solid fa-users text-blue-600"></i>
                    <span class="font-bold text-slate-900 font-mono">{{ number_format($donorCount) }}</span>
                    <span class="text-slate-400">Donors</span>
                </div>
                <div class="flex items-center space-x-2 bg-white px-3.5 py-1.5 rounded-[8px] border border-slate-200 text-slate-700 shadow-2xs">
                    <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                    <span class="text-slate-600 font-medium">UPI Secure Payment</span>
                </div>
                <div class="flex items-center space-x-1.5 bg-white px-3.5 py-1.5 rounded-[8px] border border-slate-200 text-slate-600 shadow-2xs">
                    <span class="text-slate-400">Minimum:</span>
                    <span class="font-bold text-slate-900 font-mono">₹{{ $minAmount }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12 space-y-12" x-data="donationApp()">
        
        <!-- ======================================================== -->
        <!-- 1. UPI QR DONATION CARD                                  -->
        <!-- ======================================================== -->
        <div class="bg-white rounded-[10px] border border-slate-200 shadow-xs p-6 sm:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Amount Selection (7 Cols) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="space-y-1 border-b border-slate-100 pb-3">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-blue-600">Step 1</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Choose Donation Amount</h2>
                        <p class="text-xs text-slate-500">Select a preset amount or enter your own custom amount (minimum ₹{{ $minAmount }}).</p>
                    </div>

                    <!-- Presets Grid -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            @forelse($donationTiers as $tier)
                                <button type="button" 
                                        @click="selectPreset({{ $tier->amount }}, '{{ addslashes($tier->impact_heading ?? $tier->name) }}', '{{ addslashes($tier->impact_text ?? '') }}')"
                                        :class="amount == {{ $tier->amount }} ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-500/20 shadow-xs' : 'bg-slate-50 text-slate-800 hover:bg-slate-100 border-slate-200'"
                                        class="py-2.5 px-3 rounded-[8px] border text-center transition flex flex-col items-center justify-center space-y-0.5 relative group">
                                    @if($tier->badge || $tier->is_popular)
                                        <span class="absolute -top-2 px-1.5 py-0.2 rounded-[4px] bg-blue-700 text-white text-[9px] font-bold uppercase tracking-wider shadow-2xs">
                                            {{ $tier->badge ?: 'Popular' }}
                                        </span>
                                    @endif
                                    <span class="font-mono text-base font-bold">₹{{ number_format($tier->amount) }}</span>
                                    <span class="text-[10px] opacity-80 truncate max-w-full">{{ $tier->name }}</span>
                                </button>
                            @empty
                                <button type="button" 
                                        @click="selectPreset({{ $minAmount }}, 'Community Supporter', 'Your contribution keeps PocketSQL free, private, and 100% offline.')"
                                        :class="amount == {{ $minAmount }} ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-500/20 shadow-xs' : 'bg-slate-50 text-slate-800 hover:bg-slate-100 border-slate-200'"
                                        class="py-2.5 px-3 rounded-[8px] border text-center transition flex flex-col items-center justify-center space-y-0.5 col-span-3">
                                    <span class="font-mono text-base font-bold">₹{{ number_format($minAmount) }}</span>
                                    <span class="text-[10px] opacity-80">Supporter</span>
                                </button>
                            @endforelse
                        </div>

                        <!-- Custom Amount Input -->
                        <div class="pt-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1 flex items-center justify-between">
                                <span>Custom Amount (₹)</span>
                                <span class="text-[11px] text-slate-500 font-medium">Minimum ₹{{ $minAmount }}</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 font-bold text-sm pointer-events-none">₹</span>
                                <input type="number" 
                                       x-model.number="amount"
                                       min="{{ $minAmount }}"
                                       step="1"
                                       placeholder="Enter custom amount (min ₹{{ $minAmount }})"
                                       class="w-full pl-8 pr-16 py-2.5 rounded-[8px] border border-slate-300 text-sm font-mono font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       :class="(!amount || amount < {{ $minAmount }}) ? 'border-red-400 bg-red-50/20' : ''">
                                <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs font-semibold text-slate-400 font-mono pointer-events-none">INR</span>
                            </div>
                            <p x-show="!amount || amount < {{ $minAmount }}" class="text-[11px] font-semibold text-red-600 mt-1 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i> Minimum donation amount must be ₹{{ $minAmount }} or more.
                            </p>
                        </div>
                    </div>

                    <!-- Impact Card -->
                    <div class="p-3 rounded-[8px] bg-blue-50/60 border border-blue-100 flex items-start space-x-2.5 text-xs text-slate-600">
                        <i class="fa-solid fa-lightbulb text-blue-600 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <span class="font-bold text-slate-900 block" x-text="getImpactHeading()">Community Impact</span>
                            <span class="text-[11px] text-slate-500 leading-relaxed block" x-text="getImpactText()">
                                Your contribution keeps PocketSQL free, private, and 100% offline.
                            </span>
                        </div>
                    </div>

                    <!-- UPI Apps Supported -->
                    <div class="pt-2 border-t border-slate-100 space-y-2">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Accepted via any UPI App:</span>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-1 rounded-[6px] bg-green-50 border border-green-200 text-green-800 text-xs font-medium flex items-center space-x-1.5">
                                <i class="fa-solid fa-mobile-screen-button text-green-600"></i>
                                <span>Google Pay</span>
                            </span>
                            <span class="px-2.5 py-1 rounded-[6px] bg-purple-50 border border-purple-200 text-purple-800 text-xs font-medium flex items-center space-x-1.5">
                                <i class="fa-solid fa-mobile-screen-button text-purple-600"></i>
                                <span>PhonePe</span>
                            </span>
                            <span class="px-2.5 py-1 rounded-[6px] bg-sky-50 border border-sky-200 text-sky-800 text-xs font-medium flex items-center space-x-1.5">
                                <i class="fa-solid fa-mobile-screen-button text-sky-600"></i>
                                <span>Paytm</span>
                            </span>
                            <span class="px-2.5 py-1 rounded-[6px] bg-orange-50 border border-orange-200 text-orange-800 text-xs font-medium flex items-center space-x-1.5">
                                <i class="fa-solid fa-mobile-screen-button text-orange-600"></i>
                                <span>BHIM / Any UPI</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: UPI QR + Donor Info -->
                <div class="lg:col-span-5 space-y-4">

                    <!-- UPI QR Card -->
                    <div class="bg-gradient-to-b from-blue-50 to-slate-50 rounded-[10px] p-5 border border-blue-100 space-y-3 text-center">
                        <div class="border-b border-blue-100 pb-2.5">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-blue-600 block">Step 2</span>
                            <h3 class="text-base font-bold text-slate-900">Scan &amp; Pay via UPI</h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">QR code automatically generates for your amount.</p>
                        </div>

                        <!-- QR Code Display -->
                        <div class="flex justify-center">
                            <div x-show="amount >= {{ $minAmount }}" class="bg-white rounded-[10px] p-3 border-2 border-blue-200 shadow-sm inline-block">
                                <img :src="getQrUrl()"
                                     alt="UPI QR Code"
                                     class="w-44 h-44 sm:w-48 sm:h-48 rounded-[6px]"
                                     style="image-rendering: pixelated;">
                            </div>
                            <div x-show="!amount || amount < {{ $minAmount }}" class="bg-white rounded-[10px] p-5 border-2 border-dashed border-amber-300 shadow-sm flex flex-col items-center justify-center w-48 h-48 text-amber-700">
                                <i class="fa-solid fa-triangle-exclamation text-3xl mb-2 text-amber-500"></i>
                                <span class="text-xs font-bold text-center">Minimum ₹{{ $minAmount }} Required</span>
                                <span class="text-[10px] text-slate-400 text-center mt-1">Please enter ₹{{ $minAmount }}+ to generate QR code</span>
                            </div>
                        </div>

                        <!-- Amount Display -->
                        <div class="bg-white rounded-[8px] px-4 py-2.5 border border-blue-100 inline-block">
                            <span class="text-xs text-slate-500 block">Pay Amount</span>
                            <span class="font-mono text-2xl font-extrabold text-blue-600">
                                <span x-show="amount >= {{ $minAmount }}">₹<span x-text="amount"></span></span>
                                <span x-show="!amount || amount < {{ $minAmount }}" class="text-red-500 text-sm font-semibold">Min. ₹{{ $minAmount }}</span>
                            </span>
                        </div>

                        <p class="text-[10px] text-slate-400">
                            <i class="fa-solid fa-circle-info text-blue-400 mr-1"></i>
                            Open any UPI app (GPay, PhonePe, Paytm) → Scan the QR above → Pay
                        </p>
                    </div>

                    <!-- Donor Info + UTR Submission Card -->
                    <div class="bg-slate-50 rounded-[10px] p-5 border border-slate-200 space-y-4">
                        <div class="border-b border-slate-200 pb-2.5">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-blue-600 block">Step 3</span>
                            <h3 class="text-base font-bold text-slate-900">Confirm Your Payment</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">After paying, fill in your details and transaction ID below.</p>
                        </div>

                        <div class="space-y-3">
                            <!-- Full Name -->
                            <div class="space-y-1">
                                <label for="donor_name" class="block text-xs font-semibold text-slate-700">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="donor_name"
                                       x-model="donorName"
                                       placeholder="e.g. Rahul Sharma"
                                       maxlength="100"
                                       required
                                       class="w-full px-3 py-2 rounded-[8px] bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Email -->
                            <div class="space-y-1">
                                <label for="donor_email" class="block text-xs font-semibold text-slate-700">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email"
                                       id="donor_email"
                                       x-model="donorEmail"
                                       placeholder="e.g. rahul@example.com"
                                       maxlength="150"
                                       required
                                       class="w-full px-3 py-2 rounded-[8px] bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <span class="text-[10px] text-slate-400">Confirmation will be sent here.</span>
                            </div>

                            <!-- UTR / Transaction ID -->
                            <div class="space-y-1">
                                <label for="utr_id" class="block text-xs font-semibold text-slate-700">
                                    UPI Transaction / UTR ID <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="utr_id"
                                       x-model="utrId"
                                       placeholder="e.g. 418239876543 or T2410231234"
                                       maxlength="50"
                                       required
                                       class="w-full px-3 py-2 rounded-[8px] bg-white border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <span class="text-[10px] text-slate-400">Find this in your UPI app payment history after successful payment.</span>
                            </div>

                            <!-- Message -->
                            <div class="space-y-1">
                                <label for="donor_message" class="block text-xs font-semibold text-slate-700 flex items-center justify-between">
                                    <span>Note / Message</span>
                                    <span class="text-[10px] text-slate-400 font-normal">Optional</span>
                                </label>
                                <textarea id="donor_message"
                                          x-model="donorMessage"
                                          rows="2"
                                          maxlength="500"
                                          placeholder="Leave a message for the developers..."
                                          class="w-full px-3 py-2 rounded-[8px] bg-white border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>

                        <!-- Summary Box -->
                        <div class="p-3 rounded-[8px] bg-white border border-slate-200 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between text-slate-600">
                                <span>Donation Amount</span>
                                <span class="font-mono font-bold text-slate-900">₹<span x-text="amount"></span></span>
                            </div>
                            <div class="flex items-center justify-between text-slate-500 text-[11px]">
                                <span>Processing Charges</span>
                                <span class="font-semibold text-emerald-600">Free</span>
                            </div>
                            <div class="border-t border-slate-100 pt-1.5 flex items-center justify-between text-slate-900 font-bold">
                                <span>Total Payable</span>
                                <span class="font-mono text-base text-blue-600 font-extrabold">₹<span x-text="amount"></span></span>
                            </div>
                        </div>

                        <!-- Error Alert -->
                        <div x-show="errorMessage"
                             x-cloak
                             style="display: none;"
                             class="p-2.5 rounded-[8px] bg-red-50 border border-red-200 text-red-700 text-xs flex items-center space-x-2">
                            <i class="fa-solid fa-circle-exclamation text-red-500 flex-shrink-0"></i>
                            <span x-text="errorMessage"></span>
                        </div>

                        <!-- Submit Button -->
                        <div class="space-y-2 pt-1">
                            <button type="button"
                                    @click="submitPayment()"
                                    :disabled="isProcessing || !amount || amount < {{ $minAmount }} || !donorName || !donorEmail || !utrId"
                                    class="w-full py-3 px-4 rounded-[8px] bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold text-sm shadow-xs transition flex items-center justify-center space-x-2">
                                <template x-if="!isProcessing">
                                    <span class="flex items-center space-x-1.5">
                                        <i class="fa-solid fa-check-circle text-xs"></i>
                                        <span>Confirm Donation of ₹<span x-text="amount"></span></span>
                                    </span>
                                </template>
                                <template x-if="isProcessing">
                                    <span class="flex items-center space-x-2">
                                        <i class="fa-solid fa-circle-notch fa-spin text-white"></i>
                                        <span>Submitting...</span>
                                    </span>
                                </template>
                            </button>

                            <div class="text-center text-[10px] text-slate-400 space-y-0.5">
                                <p class="flex items-center justify-center space-x-2 text-slate-500">
                                    <span><i class="fa-solid fa-shield-halved text-emerald-600 mr-1"></i>Direct UPI</span>
                                    <span>•</span>
                                    <span>Zero Processing Fees</span>
                                    <span>•</span>
                                    <span>NPCI Secured</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- ======================================================== -->
        <!-- SUCCESS RECEIPT MODAL (SCREEN VIEW)                      -->
        <!-- ======================================================== -->
        <div x-show="showReceipt" 
             x-cloak 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 print:hidden">
            
            <div @click.away="showReceipt = false"
                 class="bg-white rounded-[10px] max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4 relative my-auto">

                <button type="button"
                        @click="showReceipt = false"
                        class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1.5 rounded-[6px] hover:bg-slate-100 transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>

                <div class="text-center space-y-2 pt-1">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-xl shadow-xs">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold uppercase tracking-wider">
                        Donation Recorded
                    </span>
                    <h3 class="text-xl font-bold text-slate-900">Thank You, <span x-text="receiptData.donor_name"></span>!</h3>
                    <p class="text-xs text-slate-500">Your donation has been recorded. We'll verify your UPI payment and send a confirmation to your email.</p>
                </div>

                <!-- Receipt Card -->
                <div class="p-4 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2.5 text-xs">
                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                        <span class="text-slate-500 font-medium">Contributor</span>
                        <span class="font-bold text-slate-900" x-text="receiptData.donor_name"></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                        <span class="text-slate-500 font-medium">Amount</span>
                        <span class="font-mono text-base font-extrabold text-emerald-600" x-text="receiptData.amount"></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                        <span class="text-slate-500 font-medium">UPI / UTR ID</span>
                        <span class="font-mono text-[11px] font-bold text-slate-800 select-all" x-text="receiptData.utr_id"></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                        <span class="text-slate-500 font-medium">Paid To</span>
                        <span class="font-mono text-[11px] font-bold text-slate-700">prahladmahor888-3@okaxis</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Date &amp; Time</span>
                        <span class="text-slate-700 font-mono text-[11px]" x-text="receiptData.date"></span>
                    </div>
                </div>

                <p class="text-[11px] text-amber-700 bg-amber-50 border border-amber-200 rounded-[8px] px-3 py-2">
                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                    Please keep your UTR/Transaction ID handy. We'll verify and confirm within 24 hours.
                </p>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end space-x-2 pt-2 border-t border-slate-100">
                    <button type="button"
                            @click="showReceipt = false"
                            class="px-5 py-2 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                        Done
                    </button>
                </div>
            </div>
        </div>


        <!-- GitHub Sponsors Section -->
        <section class="space-y-3">
            <div class="p-5 sm:p-6 rounded-[10px] bg-white border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-5">
                <div class="flex items-start space-x-3.5 flex-1">
                    <div class="w-10 h-10 rounded-[8px] bg-slate-100 text-slate-800 flex items-center justify-center font-bold text-lg flex-shrink-0 border border-slate-200">
                        <i class="fa-brands fa-github"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-bold text-slate-900">Prefer Recurring Sponsorship via GitHub?</h4>
                        <p class="text-xs text-slate-500 leading-relaxed max-w-xl">
                            You can also support PocketSQL with zero processing fees through GitHub Sponsors and earn an official backer badge on your profile.
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0" style="display: inline-block;">
                    <a href="{{ $settings->github_sponsor_url }}" target="_blank" rel="noopener" 
                       style="display: inline-flex; white-space: nowrap; width: auto;"
                       class="items-center justify-center px-4 py-2.5 rounded-[8px] bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition space-x-2">
                        <i class="fa-brands fa-github text-sm"></i>
                        <span>Sponsor on GitHub &rarr;</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Transparency / Usage of Funds -->
        <div class="p-5 rounded-[10px] bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-1.5">
            <h4 class="font-bold text-slate-900 text-xs">Where Does Your Contribution Go?</h4>
            <p class="leading-relaxed">
                100% of all contributions go directly toward hardware testing devices (testing compatibility across Samsung OneUI, Google Pixel, Xiaomi HyperOS, and Android 10-15), server hosting for APK distribution, and ongoing open-source maintenance.
            </p>
        </div>

    </div>

    <!-- UPI QR Donation Script -->

    <script>
        const UPI_ID = 'prahladmahor888-3@okaxis';
        const UPI_NAME = 'PocketSQL';

        function copyToClipboard(text, btnElement) {
            navigator.clipboard.writeText(text).then(() => {
                const orig = btnElement.innerHTML;
                btnElement.innerHTML = '<span class="text-emerald-600 font-bold">✓ Copied!</span>';
                setTimeout(() => { btnElement.innerHTML = orig; }, 2000);
            });
        }

        function donationApp() {
            const dynamicTiers = @json($donationTiers);
            const popularTier = dynamicTiers.find(t => t.is_popular) || dynamicTiers[0] || null;
            const initAmount = Math.max({{ $minAmount }}, popularTier ? Number(popularTier.amount) : {{ $minAmount }});
            const initHeading = popularTier ? (popularTier.impact_heading || popularTier.name) : 'Community Impact';
            const initText = popularTier ? (popularTier.impact_text || 'Your contribution keeps PocketSQL free, private, and 100% offline.') : 'Your contribution keeps PocketSQL free, private, and 100% offline.';

            return {
                tiers: dynamicTiers,
                amount: initAmount,
                currentHeading: initHeading,
                currentText: initText,
                donorName: '',
                donorEmail: '',
                donorMessage: '',
                utrId: '',
                isProcessing: false,
                errorMessage: '',
                showReceipt: false,
                receiptData: {},

                getQrUrl() {
                    if (!this.amount || this.amount < {{ $minAmount }}) return '';
                    const upiUri = `upi://pay?pa=${encodeURIComponent(UPI_ID)}&pn=${encodeURIComponent(UPI_NAME)}&am=${encodeURIComponent(this.amount)}&cu=INR&tn=${encodeURIComponent('PocketSQL Donation')}`;
                    return `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(upiUri)}&margin=10&color=1e3a5f`;
                },

                selectPreset(val, heading, text) {
                    this.amount = Number(val);
                    this.errorMessage = '';
                    if (heading) this.currentHeading = heading;
                    if (text) this.currentText = text;
                },

                getImpactHeading() {
                    const matched = this.tiers.find(t => Number(t.amount) === Number(this.amount));
                    if (matched && matched.impact_heading) return matched.impact_heading;
                    if (matched && matched.name) return matched.name + ' Tier';
                    if (this.currentHeading) return this.currentHeading;
                    return 'Community Impact';
                },

                getImpactText() {
                    const matched = this.tiers.find(t => Number(t.amount) === Number(this.amount));
                    if (matched && matched.impact_text) return matched.impact_text;
                    if (this.currentText) return this.currentText;
                    return 'Your contribution keeps PocketSQL free, private, and 100% offline.';
                },

                async submitPayment() {
                    this.errorMessage = '';

                    if (!this.donorName || this.donorName.trim().length < 2) {
                        this.errorMessage = 'Please enter your full name.';
                        return;
                    }
                    if (!this.donorEmail || !this.donorEmail.includes('@')) {
                        this.errorMessage = 'Please enter a valid email address.';
                        return;
                    }
                    if (!this.utrId || this.utrId.trim().length < 4) {
                        this.errorMessage = 'Please enter your UPI Transaction / UTR ID from your payment app.';
                        return;
                    }
                    if (!this.amount || this.amount < {{ $minAmount }}) {
                        this.errorMessage = 'Minimum donation amount is ₹{{ $minAmount }}';
                        return;
                    }

                    this.isProcessing = true;

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                        const res = await fetch("{{ route('donate.record') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                amount: this.amount,
                                donor_name: this.donorName.trim(),
                                donor_email: this.donorEmail.trim(),
                                donor_message: this.donorMessage.trim(),
                                utr_id: this.utrId.trim(),
                            })
                        });

                        const data = await res.json();

                        if (!res.ok || !data.success) {
                            let msg = data.message || 'Submission failed. Please try again.';
                            if (data.errors && typeof data.errors === 'object') {
                                msg = Object.values(data.errors).flat().join(' ');
                            }
                            throw new Error(msg);
                        }

                        this.receiptData = {
                            donor_name: this.donorName,
                            amount: '₹' + Number(this.amount).toLocaleString('en-IN'),
                            utr_id: this.utrId,
                            date: new Date().toLocaleString('en-IN'),
                        };
                        this.showReceipt = true;
                        this.utrId = '';
                        this.donorMessage = '';

                    } catch (err) {
                        this.errorMessage = err.message || 'An error occurred. Please try again.';
                    } finally {
                        this.isProcessing = false;
                    }
                },
            };
        }
    </script>

</x-layout>
