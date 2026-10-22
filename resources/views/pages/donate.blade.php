<x-layout title="Community Support &amp; Donations — Sponsor PocketSQL"
          description="Support PocketSQL independent native Android SQL database development. Donate securely via Razorpay with UPI, Credit/Debit Cards, or Netbanking.">

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
                    <span class="text-slate-600 font-medium">Razorpay Verified</span>
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
        <!-- 1. CLEAN RAZORPAY CHECKOUT CARD                          -->
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
                                <span class="text-[11px] text-slate-400 font-normal">Minimum ₹{{ $minAmount }}</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 font-bold text-sm pointer-events-none">₹</span>
                                <input type="number" 
                                       x-model.number="amount"
                                       min="{{ $minAmount }}"
                                       step="1"
                                       placeholder="Enter custom amount"
                                       class="w-full pl-8 pr-16 py-2.5 rounded-[8px] border border-slate-300 text-sm font-mono font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       :class="amount < {{ $minAmount }} ? 'border-red-400 bg-red-50/20' : ''">
                                <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs font-semibold text-slate-400 font-mono pointer-events-none">INR</span>
                            </div>
                            <p x-show="amount < {{ $minAmount }}" class="text-[11px] font-semibold text-red-600 mt-1 flex items-center">
                                <i class="fa-solid fa-circle-exclamation mr-1"></i> Minimum donation amount is ₹{{ $minAmount }}.
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

                    <!-- Payment Channels -->
                    <div class="pt-2 border-t border-slate-100 space-y-2">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Supported Payment Channels:</span>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-1 rounded-[6px] bg-slate-50 border border-slate-200 text-slate-700 text-xs font-medium flex items-center space-x-1.5">
                                <i class="fa-solid fa-mobile-screen-button text-emerald-600"></i>
                                <span>UPI (GPay / PhonePe / Paytm / BHIM)</span>
                            </span>
                            <span class="px-2.5 py-1 rounded-[6px] bg-slate-50 border border-slate-200 text-slate-700 text-xs font-medium flex items-center space-x-1.5">
                                <i class="fa-solid fa-credit-card text-blue-600"></i>
                                <span>Cards (Visa, MC, RuPay)</span>
                            </span>
                            <span class="px-2.5 py-1 rounded-[6px] bg-slate-50 border border-slate-200 text-slate-700 text-xs font-medium flex items-center space-x-1.5">
                                <i class="fa-solid fa-building-columns text-slate-600"></i>
                                <span>Netbanking (50+ Banks)</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Donor Details & Checkout (5 Cols) -->
                <div class="lg:col-span-5 bg-slate-50 rounded-[10px] p-5 sm:p-6 border border-slate-200 space-y-4">
                    <div class="border-b border-slate-200 pb-2.5">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-blue-600 block">Step 2</span>
                        <h3 class="text-base font-bold text-slate-900">Donor Information</h3>
                    </div>

                    <!-- Form Inputs -->
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
                            <span class="text-[10px] text-slate-400">Payment receipt will be sent here.</span>
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

                    <!-- Pay Button -->
                    <div class="space-y-2 pt-1">
                        <button type="button" 
                                @click="initiateDonation()"
                                :disabled="isProcessing || amount < {{ $minAmount }} || !donorName || !donorEmail"
                                class="w-full py-3 px-4 rounded-[8px] bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold text-sm shadow-xs transition flex items-center justify-center space-x-2">
                            <template x-if="!isProcessing">
                                <span class="flex items-center space-x-1.5">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                    <span>Donate ₹<span x-text="amount"></span> via Razorpay</span>
                                </span>
                            </template>
                            <template x-if="isProcessing">
                                <span class="flex items-center space-x-2">
                                    <i class="fa-solid fa-circle-notch fa-spin text-white"></i>
                                    <span x-text="processingStep">Connecting to Razorpay...</span>
                                </span>
                            </template>
                        </button>

                        <div class="text-center text-[10px] text-slate-400 space-y-0.5">
                            <p class="flex items-center justify-center space-x-2 text-slate-500">
                                <span><i class="fa-solid fa-shield-halved text-emerald-600 mr-1"></i>256-Bit SSL</span>
                                <span>•</span>
                                <span>PCI-DSS Level 1</span>
                                <span>•</span>
                                <span>Razorpay Secure</span>
                            </p>
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
                        Payment Successful
                    </span>
                    <h3 class="text-xl font-bold text-slate-900">Thank You, <span x-text="receiptData.donor_name"></span>!</h3>
                    <p class="text-xs text-slate-500">Your contribution powers open-source SQL database development for Android.</p>
                </div>

                <!-- Screen Receipt Card -->
                <div class="p-4 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2.5 text-xs">
                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                        <span class="text-slate-500 font-medium">Contributor</span>
                        <span class="font-bold text-slate-900" x-text="receiptData.donor_name"></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                        <span class="text-slate-500 font-medium">Contribution Amount</span>
                        <span class="font-mono text-base font-extrabold text-emerald-600" x-text="receiptData.amount"></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                        <span class="text-slate-500 font-medium">Payment ID</span>
                        <span class="font-mono text-[11px] font-bold text-slate-800 select-all" x-text="receiptData.payment_id"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Date &amp; Time</span>
                        <span class="text-slate-700 font-mono text-[11px]" x-text="receiptData.date"></span>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end space-x-2 pt-2 border-t border-slate-100">
                    <button type="button" 
                            @click="printReceipt()" 
                            class="px-4 py-2 rounded-[8px] border border-slate-300 bg-white hover:bg-slate-50 text-slate-800 font-bold text-xs transition flex items-center space-x-2 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-file-pdf text-red-500 text-sm"></i>
                        <span>Print / Save PDF Receipt</span>
                    </button>
                    <button type="button" 
                            @click="showReceipt = false" 
                            class="px-5 py-2 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                        <span>Done</span>
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

    <!-- Razorpay Checkout Script Integration -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
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
            const initAmount = popularTier ? Number(popularTier.amount) : {{ $minAmount }};
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
                isProcessing: false,
                processingStep: '',
                errorMessage: '',
                showReceipt: false,
                receiptData: {},

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

                loadRazorpayScript() {
                    return new Promise((resolve, reject) => {
                        if (typeof window.Razorpay !== 'undefined') {
                            resolve(true);
                            return;
                        }
                        const existingScript = document.querySelector('script[src*="checkout.razorpay.com"]');
                        if (existingScript) {
                            existingScript.addEventListener('load', () => resolve(true));
                            existingScript.addEventListener('error', () => reject(new Error('Razorpay checkout script could not be loaded.')));
                            // If already loaded
                            if (typeof window.Razorpay !== 'undefined') {
                                resolve(true);
                                return;
                            }
                        }
                        const script = document.createElement('script');
                        script.src = 'https://checkout.razorpay.com/v1/checkout.js';
                        script.async = true;
                        script.onload = () => resolve(true);
                        script.onerror = () => reject(new Error('Razorpay checkout could not be loaded. Please disable ad-blockers or check your connection.'));
                        document.body.appendChild(script);
                    });
                },

                async initiateDonation() {
                    this.errorMessage = '';

                    if (!this.donorName || this.donorName.trim().length < 2) {
                        this.errorMessage = 'Please enter your full name.';
                        return;
                    }
                    if (!this.donorEmail || !this.donorEmail.includes('@')) {
                        this.errorMessage = 'Please enter a valid email address.';
                        return;
                    }
                    if (!this.amount || this.amount < {{ $minAmount }}) {
                        this.errorMessage = 'Minimum donation amount is ₹{{ $minAmount }}.';
                        return;
                    }

                    this.isProcessing = true;
                    this.processingStep = 'Preparing checkout gateway...';

                    try {
                        await this.loadRazorpayScript();
                    } catch (scriptErr) {
                        this.isProcessing = false;
                        this.errorMessage = scriptErr.message;
                        return;
                    }

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        
                        const orderRes = await fetch("{{ route('donate.order') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                amount: this.amount,
                                name: this.donorName.trim(),
                                email: this.donorEmail.trim(),
                                message: this.donorMessage.trim(),
                                donor_name: this.donorName.trim(),
                                donor_email: this.donorEmail.trim(),
                                donor_message: this.donorMessage.trim()
                            })
                        });

                        const orderData = await orderRes.json();

                        if (!orderRes.ok || !orderData.success) {
                            let errorMsg = orderData.message || 'Failed to initialize payment gateway.';
                            if (orderData.errors && typeof orderData.errors === 'object') {
                                errorMsg = Object.values(orderData.errors).flat().join(' ');
                            }
                            throw new Error(errorMsg);
                        }

                        this.processingStep = 'Opening Razorpay checkout...';

                        const self = this;
                        const options = {
                            key: orderData.key_id,
                            amount: orderData.amount_paise || orderData.amount,
                            currency: orderData.currency || 'INR',
                            name: 'PocketSQL Open Source Project',
                            description: 'Community Sponsorship (' + (orderData.donor_name || 'Supporter') + ')',
                            image: "{{ asset('images/logo.png') }}",
                            order_id: orderData.order_id,
                            prefill: {
                                name: orderData.donor_name,
                                email: orderData.donor_email
                            },
                            theme: {
                                color: '#2563EB'
                            },
                            modal: {
                                ondismiss: function() {
                                    self.isProcessing = false;
                                }
                            },
                            handler: async function (response) {
                                self.processingStep = 'Verifying payment signature...';
                                try {
                                    const verifyRes = await fetch("{{ route('donate.verify') }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        body: JSON.stringify({
                                            donation_id: orderData.donation_id,
                                            razorpay_order_id: response.razorpay_order_id || orderData.order_id,
                                            razorpay_payment_id: response.razorpay_payment_id,
                                            razorpay_signature: response.razorpay_signature
                                        })
                                    });

                                    const verifyData = await verifyRes.json();

                                    if (!verifyRes.ok || !verifyData.success) {
                                        throw new Error(verifyData.message || 'Signature verification failed.');
                                    }

                                    const don = verifyData.donation || {};
                                    self.receiptData = {
                                        donor_name: don.donor_name || self.donorName,
                                        donor_email: don.donor_email || self.donorEmail,
                                        amount: don.formatted_amount || don.amount || ('₹' + Number(self.amount).toLocaleString()),
                                        payment_method: don.payment_method || 'Razorpay Online',
                                        payment_id: don.payment_id || don.razorpay_payment_id || response.razorpay_payment_id || 'N/A',
                                        order_id: don.order_id || orderData.order_id || 'N/A',
                                        date: don.date || new Date().toLocaleString()
                                    };
                                    self.showReceipt = true;
                                    self.isProcessing = false;
                                } catch (vErr) {
                                    self.isProcessing = false;
                                    self.errorMessage = vErr.message || 'Verification failed. Please contact support.';
                                }
                            }
                        };

                        const rzp = new Razorpay(options);
                        rzp.on('payment.failed', function (failResponse){
                            self.isProcessing = false;
                            self.errorMessage = failResponse.error.description || 'Payment was cancelled or declined.';
                        });
                        rzp.open();

                    } catch (err) {
                        this.isProcessing = false;
                        this.errorMessage = err.message || 'An error occurred while connecting to payment service.';
                    }
                },

                printReceipt() {
                    const d = this.receiptData || {};
                    const esc = (s) => String(s || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                    
                    const donorName = esc(d.donor_name || this.donorName || 'Supporter');
                    const donorEmail = esc(d.donor_email || this.donorEmail || 'N/A');
                    const paymentId = esc(d.payment_id || 'N/A');
                    const orderId = esc(d.order_id || 'N/A');
                    const paymentMethod = esc(d.payment_method || 'Razorpay Online');
                    const amount = esc(d.amount || ('₹' + Number(this.amount || 0).toLocaleString()));
                    const date = esc(d.date || new Date().toLocaleString());
                    const logoUrl = "{{ asset('images/logo.png') }}";
                    const contactEmail = esc("{{ $settings->contact_email ?? 'support@pocketsql.net' }}");

                    let iframe = document.getElementById('receipt-print-iframe');
                    if (!iframe) {
                        iframe = document.createElement('iframe');
                        iframe.id = 'receipt-print-iframe';
                        iframe.style.position = 'fixed';
                        iframe.style.right = '0';
                        iframe.style.bottom = '0';
                        iframe.style.width = '0';
                        iframe.style.height = '0';
                        iframe.style.border = '0';
                        iframe.style.visibility = 'hidden';
                        document.body.appendChild(iframe);
                    }

                    const html = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Receipt - ${paymentId}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 15mm;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #0f172a;
            background: #ffffff;
            font-size: 11px;
            line-height: 1.4;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .sheet {
            max-width: 680px;
            margin: 0 auto;
            border: 1.5px solid #1e293b;
            border-radius: 4px;
            padding: 22px 26px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
        }
        .brand-col {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-img {
            width: 44px;
            height: 44px;
            max-width: 44px;
            max-height: 44px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #cbd5e1;
            display: block;
        }
        .brand-title {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #0f172a;
            line-height: 1.1;
        }
        .brand-title span {
            color: #2563eb;
        }
        .brand-sub {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #334155;
            margin-top: 2px;
        }
        .brand-meta {
            font-size: 9px;
            color: #64748b;
            font-family: monospace;
            margin-top: 2px;
        }
        .ref-col {
            text-align: right;
        }
        .badge-receipt {
            display: inline-block;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 3px 9px;
            font-size: 9.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .ref-item {
            font-size: 10px;
            color: #475569;
            font-family: monospace;
            line-height: 1.35;
        }
        .ref-item strong {
            color: #0f172a;
        }
        .banner {
            margin-top: 12px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 8px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .banner-title {
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #0f172a;
        }
        .banner-sub {
            font-size: 9px;
            color: #64748b;
            margin-top: 1px;
        }
        .badge-verified {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 8px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 12px;
        }
        .box {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 9px 12px;
            background: #ffffff;
        }
        .box-title {
            font-size: 9.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-bottom: 5px;
        }
        .box table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .box td {
            padding: 2.5px 0;
            vertical-align: top;
        }
        .box td.lbl {
            width: 90px;
            color: #64748b;
        }
        .box td.val {
            color: #0f172a;
            font-weight: 600;
        }
        .box td.val.mono {
            font-family: monospace;
            font-size: 9.5px;
        }
        .table-wrap {
            margin-top: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            overflow: hidden;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        table.items thead th {
            background: #f1f5f9;
            border-bottom: 1.5px solid #cbd5e1;
            padding: 6px 10px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1e293b;
        }
        table.items thead th.border-r, table.items tbody td.border-r, table.items tfoot td.border-r {
            border-right: 1px solid #cbd5e1;
        }
        table.items tbody td {
            padding: 8px 10px;
            vertical-align: middle;
        }
        table.items tfoot td {
            padding: 5px 10px;
        }
        .total-row {
            background: #f8fafc;
            border-top: 1.5px solid #94a3b8;
            font-weight: 800;
            font-size: 11px;
        }
        .total-amount {
            font-family: monospace;
            font-size: 13px;
            font-weight: 900;
            color: #0f172a;
            text-decoration: underline double;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.8fr 1.2fr;
            gap: 14px;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            align-items: center;
        }
        .mission {
            font-size: 9px;
            color: #475569;
            line-height: 1.35;
        }
        .mission strong {
            color: #0f172a;
            font-size: 9.5px;
            display: block;
            margin-bottom: 2px;
        }
        .mission-contact {
            margin-top: 3px;
            font-family: monospace;
            font-size: 8.5px;
            color: #64748b;
        }
        .seal-box {
            border: 1.5px solid #0f172a;
            background: #f8fafc;
            border-radius: 4px;
            padding: 7px 9px;
            text-align: center;
        }
        .seal-title {
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #0f172a;
            font-family: monospace;
        }
        .seal-sub {
            font-size: 8px;
            color: #15803d;
            font-weight: 800;
            margin-top: 2px;
        }
        .seal-meta {
            font-size: 7px;
            color: #64748b;
            font-family: monospace;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="header">
            <div class="brand-col">
                <img src="${logoUrl}" alt="PocketSQL" class="logo-img" width="44" height="44">
                <div>
                    <div class="brand-title">Pocket<span>SQL</span></div>
                    <div class="brand-sub">PocketSQL Open Source Project</div>
                    <div class="brand-meta">https://pocketsql.prahlix.com • MIT Licensed • Made in India</div>
                </div>
            </div>
            <div class="ref-col">
                <div class="badge-receipt">Donation Receipt</div>
                <div class="ref-item">Payment Ref: <strong>${paymentId}</strong></div>
                <div class="ref-item">Date: <strong>${date}</strong></div>
            </div>
        </div>

        <div class="banner">
            <div>
                <div class="banner-title">Official Contribution Voucher &amp; Acknowledgment Slip</div>
                <div class="banner-sub">Issued electronically upon successful online transaction verification.</div>
            </div>
            <div class="badge-verified">
                ✓ Payment Verified
            </div>
        </div>

        <div class="info-grid">
            <div class="box">
                <div class="box-title">Contributor Information</div>
                <table>
                    <tr>
                        <td class="lbl">Full Name:</td>
                        <td class="val">${donorName}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Email Address:</td>
                        <td class="val mono">${donorEmail}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Category:</td>
                        <td class="val">Community Backer &amp; Sponsor</td>
                    </tr>
                </table>
            </div>

            <div class="box">
                <div class="box-title">Transaction &amp; Gateway Details</div>
                <table>
                    <tr>
                        <td class="lbl">Payment ID:</td>
                        <td class="val mono">${paymentId}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Order ID:</td>
                        <td class="val mono">${orderId}</td>
                    </tr>
                    <tr>
                        <td class="lbl">Payment Method:</td>
                        <td class="val mono">${paymentMethod}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="table-wrap">
            <table class="items">
                <thead>
                    <tr>
                        <th style="width: 32px; text-align: center;" class="border-r">#</th>
                        <th style="text-align: left;" class="border-r">Description of Contribution</th>
                        <th style="width: 95px; text-align: center;" class="border-r">Type</th>
                        <th style="width: 105px; text-align: right;">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center; font-family: monospace; color: #64748b;" class="border-r">01</td>
                        <td class="border-r">
                            <div style="font-weight: 700; color: #0f172a; font-size: 10.5px;">PocketSQL Android Engine Sponsorship</div>
                            <div style="font-size: 9px; color: #64748b; margin-top: 2px;">
                                Voluntary contribution directly supporting native Android SQL embedded runtime optimization, continuous integration testing devices, and zero-tracking release builds.
                            </div>
                        </td>
                        <td style="text-align: center; font-family: monospace; color: #475569;" class="border-r">Direct Sponsor</td>
                        <td style="text-align: right; font-family: monospace; font-weight: 800; font-size: 11px; color: #0f172a;">${amount}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="background: #f8fafc; border-top: 1px solid #cbd5e1;">
                        <td colspan="3" style="text-align: right; color: #475569;" class="border-r">Subtotal:</td>
                        <td style="text-align: right; font-family: monospace; font-weight: 700; color: #0f172a;">${amount}</td>
                    </tr>
                    <tr style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                        <td colspan="3" style="text-align: right; color: #475569;" class="border-r">Processing &amp; Gateway Fees:</td>
                        <td style="text-align: right; font-family: monospace; font-weight: 700; color: #166534;">₹0.00 (Waived)</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right; text-transform: uppercase; letter-spacing: 0.5px; color: #0f172a;" class="border-r">Total Amount Received:</td>
                        <td style="text-align: right;" class="total-amount">${amount}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="footer-grid">
            <div class="mission">
                <strong>Thank you for powering independent open-source software!</strong>
                PocketSQL is built with zero cloud tracking and 100% offline-first principles. 100% of community contributions are utilized for hardware testing and maintaining open-source releases.
                <div class="mission-contact">
                    Project Contact: ${contactEmail} • https://pocketsql.prahlix.com
                </div>
            </div>

            <div>
                <div class="seal-box">
                    <div class="seal-title">Authenticated Voucher</div>
                    <div class="seal-sub">Secured by Razorpay • Verified</div>
                    <div class="seal-meta">Electronically Generated • No Physical Signature Required</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>`;

                    const doc = iframe.contentWindow.document;
                    doc.open();
                    doc.write(html);
                    doc.close();

                    setTimeout(() => {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                    }, 250);
                }
            };
        }
    </script>

</x-layout>
