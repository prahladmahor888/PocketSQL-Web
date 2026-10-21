<x-layout 
    title="Contact Us &amp; Technical Support — PocketSQL"
    description="Get in touch with the PocketSQL core engineering team. Submit bug reports, request features, or discuss custom enterprise Android database implementations."
    keywords="contact pocketsql, pocketsql support, pocketsql bug report, android sql support"
>

    <!-- Page Header -->
    <div class="bg-slate-50 border-b border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-white px-3 py-1 rounded-[10px] border border-slate-200">Get in Touch</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Contact &amp; Engineering Support</h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Have a question, encountered a bug, or want to discuss enterprise sponsorship? We'd love to hear from you.
            </p>
        </div>
    </div>

    <!-- Contact Grid Container -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left Column: Support Channels (Max 10px Radius Cards) -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">Communication Channels</h2>
                    <p class="text-sm text-slate-600 mt-1">Direct ways to get assistance from the core team.</p>
                </div>

                <!-- Email Card -->
                <x-card class="space-y-2">
                    <div class="flex items-center space-x-3 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <h3 class="text-sm font-bold text-slate-900">Official Email</h3>
                    </div>
                    <p class="text-xs text-slate-600">Send inquiries directly to our developer inbox:</p>
                    <a href="mailto:{{ $settings->contact_email ?? 'support@pocketsql.app' }}" class="text-sm font-mono font-bold text-blue-600 hover:underline block pt-1">
                        {{ $settings->contact_email ?? 'support@pocketsql.app' }}
                    </a>
                </x-card>

                <!-- GitHub Issues Card -->
                <x-card class="space-y-2">
                    <div class="flex items-center space-x-3 text-slate-900">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                        <h3 class="text-sm font-bold text-slate-900">GitHub Issues &amp; Bugs</h3>
                    </div>
                    <p class="text-xs text-slate-600">Track source code, report engine edge cases, or review PRs:</p>
                    <a href="{{ $settings->github_issues_url }}" target="_blank" rel="noopener" class="text-xs font-semibold text-blue-600 hover:underline block pt-1">
                        Open GitHub Issue Tracker &rarr;
                    </a>
                </x-card>

                <!-- Community Chat Card -->
                <x-card class="space-y-2">
                    <div class="flex items-center space-x-3 text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                        <h3 class="text-sm font-bold text-slate-900">Real-Time Community</h3>
                    </div>
                    <p class="text-xs text-slate-600">Join our Discord server or official Telegram discussion channel:</p>
                    <div class="flex items-center space-x-3 pt-1 text-xs">
                        <a href="https://discord.gg/pocketsql" target="_blank" rel="noopener" class="text-indigo-600 font-semibold hover:underline">Discord Server</a>
                        <span class="text-slate-300">•</span>
                        <a href="https://t.me/pocketsql_official" target="_blank" rel="noopener" class="text-blue-500 font-semibold hover:underline">Telegram Group</a>
                    </div>
                </x-card>

                <!-- Response SLA notice -->
                <div class="p-4 rounded-[10px] bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 space-y-1">
                    <div class="font-bold flex items-center">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                        Response Commitment
                    </div>
                    <p>All direct inquiries receive an answer within 24 to 48 business hours.</p>
                </div>
            </div>

            <!-- Right Column: Interactive Contact Form (Max 10px Radius Card) -->
            <div class="lg:col-span-7">
                <div class="bg-white border border-slate-200 rounded-[10px] p-6 sm:p-8 shadow-sm space-y-6">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900">Send Us a Direct Message</h2>
                        <p class="text-sm text-slate-600 mt-1">Fill out the form below to transmit an inquiry to our team.</p>
                    </div>

                    @if($errors->any())
                        <div class="p-4 rounded-[10px] bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
                            <div class="font-bold">Please correct the following errors:</div>
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Honeypot Anti-Spam Field (Hidden) -->
                        <div class="hidden" aria-hidden="true">
                            <input type="text" name="website_hp" tabindex="-1" autocomplete="off">
                        </div>

                        <!-- Name & Email Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       required 
                                       value="{{ old('name') }}"
                                       placeholder="e.g. Alex Johnson"
                                       class="w-full px-3.5 py-2.5 rounded-[10px] border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-slate-900 placeholder:text-slate-400">
                            </div>

                            <div class="space-y-1.5">
                                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       required 
                                       value="{{ old('email') }}"
                                       placeholder="alex@example.com"
                                       class="w-full px-3.5 py-2.5 rounded-[10px] border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-slate-900 placeholder:text-slate-400">
                            </div>
                        </div>

                        <!-- Inquiry Type Dropdown -->
                        <div class="space-y-1.5">
                            <label for="inquiry_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Inquiry Type <span class="text-red-500">*</span>
                            </label>
                            <select id="inquiry_type" 
                                    name="inquiry_type" 
                                    required 
                                    class="w-full px-3.5 py-2.5 rounded-[10px] border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-slate-900 bg-white">
                                <option value="General Inquiry" {{ old('inquiry_type') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Bug Report" {{ old('inquiry_type') == 'Bug Report' ? 'selected' : '' }}>Bug Report &amp; Issue</option>
                                <option value="Feature Request" {{ old('inquiry_type') == 'Feature Request' ? 'selected' : '' }}>Feature Request</option>
                                <option value="Sponsorship/Donation" {{ old('inquiry_type') == 'Sponsorship/Donation' ? 'selected' : '' }}>Sponsorship &amp; Donation</option>
                                <option value="Enterprise Support" {{ old('inquiry_type') == 'Enterprise Support' ? 'selected' : '' }}>Enterprise / Custom Embedding</option>
                            </select>
                        </div>

                        <!-- Subject -->
                        <div class="space-y-1.5">
                            <label for="subject" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   required 
                                   value="{{ old('subject') }}"
                                   placeholder="Brief overview of your message"
                                   class="w-full px-3.5 py-2.5 rounded-[10px] border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-slate-900 placeholder:text-slate-400">
                        </div>

                        <!-- Message Textarea -->
                        <div class="space-y-1.5">
                            <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required 
                                      placeholder="Provide as much context as possible..."
                                      class="w-full px-3.5 py-2.5 rounded-[10px] border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-slate-900 placeholder:text-slate-400">{{ old('message') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <x-button type="submit" variant="primary" class="w-full py-3 text-base">
                                Send Message Directly &rarr;
                            </x-button>
                        </div>

                        <p class="text-[11px] text-slate-400 text-center">
                            We respect your privacy. Inquiries are stored strictly for support follow-up and are never shared.
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>

</x-layout>
