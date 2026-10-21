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
                        <div class="grid grid-cols-3 gap-2.5">
                            
                            <!-- ₹100 -->
                            <button type="button" 
                                    @click="selectPreset(100)"
                                    :class="amount == 100 ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-500/20 shadow-xs' : 'bg-slate-50 text-slate-800 hover:bg-slate-100 border-slate-200'"
                                    class="py-2.5 px-3 rounded-[8px] border text-center transition flex flex-col items-center justify-center space-y-0.5">
                                <span class="font-mono text-base font-bold">₹100</span>
                                <span class="text-[10px] opacity-80">Supporter</span>
                            </button>

                            <!-- ₹250 -->
                            <button type="button" 
                                    @click="selectPreset(250)"
                                    :class="amount == 250 ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-500/20 shadow-xs' : 'bg-slate-50 text-slate-800 hover:bg-slate-100 border-slate-200'"
                                    class="py-2.5 px-3 rounded-[8px] border text-center transition flex flex-col items-center justify-center space-y-0.5">
                                <span class="font-mono text-base font-bold">₹250</span>
                                <span class="text-[10px] opacity-80">Contributor</span>
                            </button>

                            <!-- ₹500 (Popular) -->
                            <button type="button" 
                                    @click="selectPreset(500)"
                                    :class="amount == 500 ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-500/20 shadow-xs' : 'bg-slate-50 text-slate-800 hover:bg-slate-100 border-slate-200'"
                                    class="py-2.5 px-3 rounded-[8px] border text-center transition flex flex-col items-center justify-center space-y-0.5 relative">
                                <span class="absolute -top-2 px-1.5 py-0.2 rounded-[4px] bg-blue-700 text-white text-[9px] font-bold uppercase tracking-wider">Popular</span>
                                <span class="font-mono text-base font-bold">₹500</span>
                                <span class="text-[10px] opacity-80">Backer</span>
                            </button>

                            <!-- ₹1,000 -->
                            <button type="button" 
                                    @click="selectPreset(1000)"
                                    :class="amount == 1000 ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-500/20 shadow-xs' : 'bg-slate-50 text-slate-800 hover:bg-slate-100 border-slate-200'"
                                    class="py-2.5 px-3 rounded-[8px] border text-center transition flex flex-col items-center justify-center space-y-0.5">
                                <span class="font-mono text-base font-bold">₹1,000</span>
                                <span class="text-[10px] opacity-80">Advocate</span>
                            </button>

                            <!-- ₹2,500 -->
                            <button type="button" 
                                    @click="selectPreset(2500)"
                                    :class="amount == 2500 ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-500/20 shadow-xs' : 'bg-slate-50 text-slate-800 hover:bg-slate-100 border-slate-200'"
                                    class="py-2.5 px-3 rounded-[8px] border text-center transition flex flex-col items-center justify-center space-y-0.5">
                                <span class="font-mono text-base font-bold">₹2,500</span>
                                <span class="text-[10px] opacity-80">Champion</span>
                            </button>

                            <!-- ₹5,000 -->
                            <button type="button" 
                                    @click="selectPreset(5000)"
                                    :class="amount == 5000 ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-500/20 shadow-xs' : 'bg-slate-50 text-slate-800 hover:bg-slate-100 border-slate-200'"
                                    class="py-2.5 px-3 rounded-[8px] border text-center transition flex flex-col items-center justify-center space-y-0.5">
                                <span class="font-mono text-base font-bold">₹5,000</span>
                                <span class="text-[10px] opacity-80">Patron</span>
                            </button>

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
        <!-- SUCCESS RECEIPT MODAL                                    -->
        <!-- ======================================================== -->
        <div x-show="showReceipt" 
             x-cloak 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
            
            <div @click.away="showReceipt = false" 
                 class="bg-white rounded-[10px] max-w-md w-full p-6 shadow-xl border border-slate-200 space-y-5 relative">
                
                <button type="button" 
                        @click="showReceipt = false" 
                        class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1 rounded-[6px] hover:bg-slate-100 transition">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>

                <div class="text-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">
                        Payment Successful
                    </span>
                    <h3 class="text-xl font-bold text-slate-900">Thank You, <span x-text="receiptData.donor_name"></span>!</h3>
                    <p class="text-xs text-slate-500">Your donation supports native SQL database development for Android.</p>
                </div>

                <!-- Receipt Slip -->
                <div class="p-4 rounded-[8px] bg-slate-50 border border-slate-200 space-y-2 text-xs">
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                        <span class="text-slate-500 font-medium">Donor</span>
                        <span class="font-bold text-slate-900" x-text="receiptData.donor_name"></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                        <span class="text-slate-500 font-medium">Amount</span>
                        <span class="font-mono text-sm font-bold text-emerald-600" x-text="receiptData.amount"></span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                        <span class="text-slate-500 font-medium">Payment ID</span>
                        <span class="font-mono text-[11px] text-slate-700 select-all" x-text="receiptData.payment_id"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Date</span>
                        <span class="text-slate-700" x-text="receiptData.date"></span>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-1">
                    <button type="button" 
                            @click="window.print()" 
                            class="px-3.5 py-2 rounded-[8px] border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-print text-[11px]"></i>
                        <span>Print</span>
                    </button>
                    <button type="button" 
                            @click="showReceipt = false" 
                            class="px-4 py-2 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition">
                        <span>Done</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- 2. RECENT COMMUNITY BACKERS                              -->
        <!-- ======================================================== -->
        @if($recentDonations->count() > 0)
            <section class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-2.5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 flex items-center space-x-2">
                            <i class="fa-solid fa-award text-amber-500"></i>
                            <span>Recent Community Supporters</span>
                        </h3>
                        <p class="text-xs text-slate-500">Developers backing the open-source PocketSQL engine.</p>
                    </div>
                    <span class="text-xs font-mono font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-[6px]">
                        {{ $donorCount }} Verified Backers
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($recentDonations as $recent)
                        <div class="p-3.5 rounded-[10px] bg-white border border-slate-200 space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2 overflow-hidden">
                                    <div class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 font-bold text-[11px] flex items-center justify-center flex-shrink-0">
                                        {{ strtoupper(substr($recent->donor_name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-xs text-slate-900 truncate">{{ $recent->donor_name }}</span>
                                </div>
                                <span class="font-mono text-xs font-bold text-emerald-600 flex-shrink-0">{{ $recent->formatted_amount }}</span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-slate-400">
                                <span class="truncate"><i class="{{ $recent->method_icon }} mr-1 text-[10px] text-slate-400"></i>{{ $recent->payment_method ?: 'Razorpay' }}</span>
                                <span class="font-mono text-[10px] flex-shrink-0">{{ $recent->created_at->diffForHumans() }}</span>
                            </div>
                            @if($recent->message)
                                <p class="text-[11px] text-slate-600 italic bg-slate-50 p-1.5 rounded-[6px] border border-slate-100 line-clamp-2" title="{{ $recent->message }}">
                                    "{{ $recent->message }}"
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

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
            return {
                amount: {{ $minAmount }},
                donorName: '',
                donorEmail: '',
                donorMessage: '',
                isProcessing: false,
                processingStep: '',
                errorMessage: '',
                showReceipt: false,
                receiptData: {},

                selectPreset(val) {
                    this.amount = val;
                    this.errorMessage = '';
                },

                getImpactHeading() {
                    if (this.amount >= 2500) return 'Champion Sponsor Tier';
                    if (this.amount >= 1000) return 'Advocate Sponsor Tier';
                    if (this.amount >= 500) return 'Backer Sponsor Tier';
                    return 'Community Supporter';
                },

                getImpactText() {
                    if (this.amount >= 2500) return 'Directly covers physical Android OEM test hardware acquisition and long-term daemon stability testing.';
                    if (this.amount >= 1000) return 'Funds native cryptographic TLS certificate updates and continuous background API benchmarking.';
                    if (this.amount >= 500) return 'Maintains high-speed global APK download server bandwidth and automated release pipelines.';
                    return 'Covers essential open-source operational costs and keeps PocketSQL 100% free with zero advertisements.';
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
                            amount: orderData.amount_paise,
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

                                    self.receiptData = {
                                        donor_name: verifyData.donation.donor_name,
                                        amount: verifyData.donation.formatted_amount,
                                        payment_method: verifyData.donation.payment_method,
                                        payment_id: verifyData.donation.razorpay_payment_id,
                                        date: new Date().toLocaleString()
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
                }
            };
        }
    </script>

</x-layout>
