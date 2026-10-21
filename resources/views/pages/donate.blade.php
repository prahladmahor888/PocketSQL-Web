<x-layout title="Community Support &amp; Donations — Sponsor PocketSQL">

    <!-- Page Header -->
    <div class="bg-slate-50 border-b border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-white px-3 py-1 rounded-[10px] border border-slate-200">Open-Source Sponsorship</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Sponsor PocketSQL Development</h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                PocketSQL is 100% free and open-source. Your generous support keeps the software independent, covers Android test devices, and accelerates new feature development.
            </p>
        </div>
    </div>

    <!-- Main Donation Options Container -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">
        
        <!-- 1. UPI Payment Card (India Featured Channel - Max 10px Radius) -->
        <div class="bg-white border-2 border-emerald-500 rounded-[10px] p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                
                <!-- Left: Instructions & Copyable ID -->
                <div class="space-y-4 text-center md:text-left flex-1">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-[8px] bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                        <span>🇮🇳 Instant UPI Payment (Zero Gateway Fees)</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Scan &amp; Pay with Any UPI App</h2>
                    
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Supporters in India can scan the QR code using Google Pay, PhonePe, Paytm, BHIM, or any banking app for zero-fee instant contributions.
                    </p>

                    <!-- UPI ID Box with 1-Click Copy -->
                    <div class="p-3.5 rounded-[10px] bg-slate-50 border border-slate-200 flex items-center justify-between gap-3 max-w-md mx-auto md:mx-0">
                        <div class="overflow-hidden">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">UPI ID:</span>
                            <span class="font-mono text-sm sm:text-base font-bold text-slate-900">pocketsql@upi</span>
                        </div>
                        <button type="button" 
                                onclick="copyToClipboard('pocketsql@upi', this)"
                                class="px-3.5 py-1.5 bg-white border border-slate-300 hover:bg-slate-100 rounded-[8px] text-xs font-bold text-slate-700 transition flex items-center space-x-1 flex-shrink-0">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span>Copy UPI ID</span>
                        </button>
                    </div>

                    <!-- Supported Apps Pill badges -->
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 pt-1 text-xs text-slate-500">
                        <span class="px-2 py-0.5 rounded-[6px] bg-slate-100 border border-slate-200 font-medium">Google Pay</span>
                        <span class="px-2 py-0.5 rounded-[6px] bg-slate-100 border border-slate-200 font-medium">PhonePe</span>
                        <span class="px-2 py-0.5 rounded-[6px] bg-slate-100 border border-slate-200 font-medium">Paytm</span>
                        <span class="px-2 py-0.5 rounded-[6px] bg-slate-100 border border-slate-200 font-medium">BHIM</span>
                    </div>
                </div>

                <!-- Right: High-Res QR Code Image (10px Radius) -->
                <div class="flex-shrink-0 text-center">
                    <div class="p-3 bg-white border border-slate-200 rounded-[10px] shadow-sm inline-block">
                        <img src="{{ asset('images/upi_qr.svg') }}" alt="PocketSQL UPI QR" class="w-56 h-56 object-contain rounded-[6px]">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-2 font-mono">Scan via camera or UPI app</p>
                </div>

            </div>
        </div>

        <!-- 2. Global Donation Channels (3 Cards - Max 10px Radius) -->
        <section class="space-y-6">
            <div>
                <h3 class="text-2xl font-extrabold text-slate-900">International Sponsorship Channels</h3>
                <p class="text-sm text-slate-600 mt-1">Convenient payment methods for developers and companies around the globe.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Buy Me A Coffee -->
                <x-card class="space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-[10px] bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-mug-saucer"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">Buy Me a Coffee</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Support with a friendly one-time coffee contribution via credit/debit card, Apple Pay, or Google Pay.
                        </p>
                    </div>
                    <div class="pt-2">
                        <x-button variant="secondary" href="https://buymeacoffee.com/pocketsql" target="_blank" rel="noopener" class="w-full text-xs">
                            <i class="fa-solid fa-heart text-red-500 mr-1.5"></i> Support via Coffee &rarr;
                        </x-button>
                    </div>
                </x-card>

                <!-- PayPal -->
                <x-card class="space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-[10px] bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                            <i class="fa-brands fa-paypal"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">PayPal Direct</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Send direct international donations via PayPal in USD, EUR, GBP, AUD, or other major fiat currencies.
                        </p>
                    </div>
                    <div class="pt-2">
                        <x-button variant="secondary" href="https://paypal.me/pocketsql" target="_blank" rel="noopener" class="w-full text-xs">
                            <i class="fa-brands fa-paypal text-blue-600 mr-1.5"></i> Donate with PayPal &rarr;
                        </x-button>
                    </div>
                </x-card>

                <!-- GitHub Sponsors -->
                <x-card class="space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-[10px] bg-pink-50 text-pink-600 flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-heart text-pink-500"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">GitHub Sponsors</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Become a recurring monthly backer or sponsor with zero platform fees, and get an official Sponsor badge on GitHub.
                        </p>
                    </div>
                    <div class="pt-2">
                        <x-button variant="secondary" href="https://github.com/sponsors/pocketsql" target="_blank" rel="noopener" class="w-full text-xs">
                            <i class="fa-brands fa-github mr-1.5"></i> Sponsor on GitHub &rarr;
                        </x-button>
                    </div>
                </x-card>

            </div>
        </section>

        <!-- 3. Crypto Donations (USDT & BTC) -->
        <section class="space-y-4">
            <h3 class="text-xl font-bold text-slate-900">Decentralized Crypto Addresses</h3>
            <p class="text-xs text-slate-500">For privacy-conscious developers who prefer peer-to-peer cryptocurrency transactions.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-xs text-slate-900">USDT (TRC-20 Network)</span>
                        <button type="button" 
                                onclick="copyToClipboard('TQzPocketSQL3981Gj90124KLa', this)"
                                class="text-[11px] font-semibold text-blue-600 hover:underline">
                            Copy Address
                        </button>
                    </div>
                    <div class="font-mono text-xs text-slate-600 break-all bg-white p-2.5 rounded-[6px] border border-slate-200">
                        TQzPocketSQL3981Gj90124KLa
                    </div>
                </div>

                <div class="p-4 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-xs text-slate-900">Bitcoin (BTC Native SegWit)</span>
                        <button type="button" 
                                onclick="copyToClipboard('bc1qpocketsql89124098124jklm', this)"
                                class="text-[11px] font-semibold text-blue-600 hover:underline">
                            Copy Address
                        </button>
                    </div>
                    <div class="font-mono text-xs text-slate-600 break-all bg-white p-2.5 rounded-[6px] border border-slate-200">
                        bc1qpocketsql89124098124jklm
                    </div>
                </div>
            </div>
        </section>

        <!-- Transparency / Usage of Funds -->
        <div class="p-6 rounded-[10px] bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-2">
            <h4 class="font-bold text-slate-900 text-sm">Where Does Your Contribution Go?</h4>
            <p class="leading-relaxed">
                100% of all contributions go directly toward hardware testing devices (testing compatibility across Samsung OneUI, Google Pixel, Xiaomi HyperOS, and Android 10-15), server hosting for APK distribution, and ongoing open-source maintenance. We publish our annual financial report transparently on GitHub.
            </p>
        </div>

    </div>

</x-layout>
