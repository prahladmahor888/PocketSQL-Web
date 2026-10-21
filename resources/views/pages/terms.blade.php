<x-layout title="Terms of Service — PocketSQL">

    <!-- Page Header -->
    <div class="bg-slate-50 border-b border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-white px-3 py-1 rounded-[10px] border border-slate-200">Legal Agreement</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Terms of Service</h1>
            <p class="text-xs sm:text-sm text-slate-500 font-mono">
                Last Updated: October 2026 • MIT Open Source License
            </p>
        </div>
    </div>

    <!-- Terms Content Container -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white border border-slate-200 rounded-[10px] p-8 sm:p-12 shadow-sm space-y-10 text-slate-700 leading-relaxed text-sm">
            
            <!-- MIT License Section -->
            <section class="space-y-4">
                <h2 class="text-lg font-bold text-slate-900">1. Software License &amp; Copyright</h2>
                <p>
                    PocketSQL is free, open-source software licensed under the terms of the <strong>MIT License</strong>.
                </p>
                <div class="bg-slate-50 border border-slate-200 rounded-[10px] p-5 font-mono text-xs text-slate-600 leading-relaxed">
                    <p class="font-bold text-slate-900">Copyright &copy; {{ date('Y') }} PocketSQL Contributors</p>
                    <p class="mt-2">
                        Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
                    </p>
                    <p class="mt-2">
                        The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
                    </p>
                </div>
            </section>

            <!-- Disclaimer of Warranty -->
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-slate-900">2. "As-Is" Warranty Disclaimer</h2>
                <div class="p-4 rounded-[10px] bg-amber-50 border border-amber-200 text-xs text-amber-900 space-y-2">
                    <div class="font-bold uppercase tracking-wider text-[11px]">Important Notice</div>
                    <p class="leading-relaxed font-mono">
                        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
                    </p>
                </div>
            </section>

            <!-- Limitation of Liability -->
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-slate-900">3. Limitation of Liability &amp; Data Safeguarding</h2>
                <p>
                    While PocketSQL incorporates atomic transactional storage mechanisms and write-ahead logs, the authors shall not be held liable for any data corruption, accidental deletion, system instability, or loss of profits arising from the execution of SQL queries, power interruptions, or memory-pressure termination on mobile devices.
                </p>
                <p>
                    Users are strongly advised to maintain external backups of essential databases by exporting `.sql` or `.db` files regularly using the in-app export tools.
                </p>
            </section>

            <!-- Acceptable Use -->
            <section class="space-y-3">
                <h2 class="text-lg font-bold text-slate-900">4. Acceptable Network Use</h2>
                <p>
                    You agree to use the embedded HTTP API server only on networks you own or have explicit authorization to utilize. You must not configure the server to listen on insecure public networks without proper bearer token protection and TLS certificate enforcement.
                </p>
            </section>

            <!-- Contact -->
            <section class="space-y-2 pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-500">
                    Questions concerning these terms may be directed to <a href="mailto:{{ $settings->contact_email ?? 'support@pocketsql.app' }}" class="text-blue-600 font-mono font-bold hover:underline">{{ $settings->contact_email ?? 'support@pocketsql.app' }}</a>.
                </p>
            </section>

        </div>
    </div>

</x-layout>
