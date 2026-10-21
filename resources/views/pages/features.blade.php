<x-layout 
    title="Features — In-Depth SQL Engine &amp; REST Server Specifications"
    description="Explore the technical capabilities of PocketSQL: SQLite standard SQL dialect, analytical window functions, ACID transactions, 40+ system tables, and built-in TLS REST daemon for Android."
    keywords="android sqlite features, android sql engine specs, mobile sql window functions, android rest api daemon, offline android sql performance"
>

    <!-- Page Header -->
    <div class="bg-slate-50 border-b border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-white px-3 py-1 rounded-[10px] border border-slate-200">Capabilities</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Full Technical Feature Matrix</h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Explore the complete technical specifications and engineering features powering the PocketSQL runtime.
            </p>
        </div>
    </div>

    <!-- Features Content Container -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">
        
        <!-- Module 1: SQL Language & Engine -->
        <section class="space-y-6">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-[8px] bg-blue-600 text-white flex items-center justify-center font-bold text-sm">01</div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">SQL Language &amp; Execution Engine</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card class="space-y-3">
                    <h3 class="text-base font-bold text-slate-900">Comprehensive CRUD &amp; Complex Joins</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Full implementation of `SELECT`, `INSERT`, `UPDATE`, `DELETE`, and `REPLACE INTO`. Perform relational multi-table `INNER JOIN`, `LEFT OUTER JOIN`, `RIGHT OUTER JOIN`, and Cartesian `CROSS JOIN` operations with subquery filtering.
                    </p>
                    <div class="pt-2 font-mono text-xs text-blue-600 bg-blue-50/60 p-3 rounded-[8px] border border-blue-100">
                        SELECT u.name, o.total FROM users u LEFT JOIN orders o ON u.id = o.user_id;
                    </div>
                </x-card>

                <x-card class="space-y-3">
                    <h3 class="text-base font-bold text-slate-900">Analytical Window Functions</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Execute advanced analytical partitioning queries with `PERCENT_RANK()`, `NTILE()`, `DENSE_RANK()`, and `ROW_NUMBER() OVER (PARTITION BY ... ORDER BY ...)` without loading datasets into client memory.
                    </p>
                    <div class="pt-2 font-mono text-xs text-emerald-600 bg-emerald-50/60 p-3 rounded-[8px] border border-emerald-100">
                        SELECT id, score, NTILE(4) OVER (ORDER BY score DESC) as quartile FROM leaderboard;
                    </div>
                </x-card>

                <x-card class="space-y-3">
                    <h3 class="text-base font-bold text-slate-900">Strict Constraint Enforcement</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Relational integrity is guarded with `PRIMARY KEY`, `FOREIGN KEY` (with `ON DELETE CASCADE` and `SET NULL`), `UNIQUE`, `NOT NULL`, and custom boolean `CHECK (...)` expression validation.
                    </p>
                </x-card>

                <x-card class="space-y-3">
                    <h3 class="text-base font-bold text-slate-900">Temporal &amp; Auto-Timestamp Triggers</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Automatic timestamp updating with `DEFAULT CURRENT_TIMESTAMP` and `ON UPDATE CURRENT_TIMESTAMP`. Precise ISO-8601 millisecond date calculations.
                    </p>
                </x-card>
            </div>
        </section>

        <!-- Module 2: Interactive Terminal Console -->
        <section class="space-y-6 pt-8 border-t border-slate-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-[8px] bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">02</div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Interactive Terminal Console</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-card class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900">JetBrains Mono Typography</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        High-legibility programming font tailored for mobile screens with clear distinction between 0/O, 1/l, and aligned table borders.
                    </p>
                </x-card>

                <x-card class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900">Real-Time Autocomplete</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Powered by `SqlKeywordSuggester.java`. Intelligently suggests keywords, table names, and column identifiers as you type in real time.
                    </p>
                </x-card>

                <x-card class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900">200+ Built-in Help Topics</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Type `HELP <topic>;` (e.g., `HELP SELECT;`, `HELP JOINS;`) for instant syntax documentation without needing an internet connection.
                    </p>
                </x-card>
            </div>
        </section>

        <!-- Module 3: Embedded HTTP & TLS REST API -->
        <section class="space-y-6 pt-8 border-t border-slate-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-[8px] bg-purple-600 text-white flex items-center justify-center font-bold text-sm">03</div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Embedded HTTP &amp; TLS REST API Server</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card class="space-y-3">
                    <h3 class="text-base font-bold text-slate-900">Android Foreground Service</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Runs continuously in the background with persistent notification status. Features a one-tap "Stop Server" toggle directly from your phone's notification shade.
                    </p>
                </x-card>

                <x-card class="space-y-3">
                    <h3 class="text-base font-bold text-slate-900">Auto Port-Failover (8080 - 8099)</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        If port 8080 is utilized by another service, PocketSQL automatically scans incrementally and binds to the first free port up to 8099 without crashing.
                    </p>
                </x-card>

                <x-card class="space-y-3">
                    <h3 class="text-base font-bold text-slate-900">On-Device TLS 1.3 Generator</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        `AndroidCertGenerator.java` creates self-signed 2048-bit RSA X.509 certificates directly on the device, providing secure HTTPS connectivity over untrusted local Wi-Fi.
                    </p>
                </x-card>

                <x-card class="space-y-3">
                    <h3 class="text-base font-bold text-slate-900">Scoped Bearer API Keys</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Generate granular tokens with read-only or read/write privileges scoped to individual databases, managed via `SqlApiKeyManager.java`.
                    </p>
                </x-card>
            </div>
        </section>

        <!-- Module 4: 40+ MySQL System Tables Emulation -->
        <section class="space-y-6 pt-8 border-t border-slate-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-[8px] bg-amber-600 text-white flex items-center justify-center font-bold text-sm">04</div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">40+ MySQL System Tables Emulation</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-5 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2">
                    <div class="text-xs font-mono font-bold text-blue-600">information_schema</div>
                    <p class="text-xs text-slate-600">`TABLES`, `COLUMNS`, `SCHEMATA`, `STATISTICS`, `KEY_COLUMN_USAGE`, `ROUTINES`</p>
                </div>

                <div class="p-5 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2">
                    <div class="text-xs font-mono font-bold text-emerald-600">mysql</div>
                    <p class="text-xs text-slate-600">`user`, `db`, `tables_priv`, `columns_priv`, `general_log`, `slow_log`</p>
                </div>

                <div class="p-5 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2">
                    <div class="text-xs font-mono font-bold text-purple-600">performance_schema</div>
                    <p class="text-xs text-slate-600">`threads`, `events_statements_current`, `table_io_waits_summary_by_table`</p>
                </div>

                <div class="p-5 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2">
                    <div class="text-xs font-mono font-bold text-amber-600">sys</div>
                    <p class="text-xs text-slate-600">`version`, `metrics`, `statement_analysis`, `schema_table_statistics`</p>
                </div>
            </div>
        </section>

        <!-- Module 5: Export & Import Engine -->
        <section class="space-y-6 pt-8 border-t border-slate-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-[8px] bg-cyan-600 text-white flex items-center justify-center font-bold text-sm">05</div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Export &amp; Import Engine</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900">Raw .sql DDL &amp; DML Dumps</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Export entire databases or selected tables into standard `.sql` script files ready to be imported directly into MySQL, MariaDB, or PostgreSQL.
                    </p>
                </x-card>

                <x-card class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900">Encrypted SQLite &amp; SQLCipher (.db)</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Export databases into standard SQLite binary format or encrypt with SQLCipher 256-bit AES for zero-knowledge data sharing.
                    </p>
                </x-card>

                <x-card class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900">Formatted Excel Spreadsheets (.xlsx)</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Generate stylized Microsoft Excel workbooks on the phone with styled column headers and auto-adjusted cell widths.
                    </p>
                </x-card>

                <x-card class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900">ZIP-Compressed CSV Archives</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Batch export all tables into cleanly formatted comma-separated `.csv` files bundled inside a lightweight `.zip` archive.
                    </p>
                </x-card>
            </div>
        </section>

        <!-- Module 6: Mobile Security & Performance -->
        <section class="space-y-6 pt-8 border-t border-slate-200">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-[8px] bg-red-600 text-white flex items-center justify-center font-bold text-sm">06</div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Mobile Security &amp; Performance</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-card class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900">AES-256 Android Keystore</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        All master configurations and API secret keys are encrypted with hardware-backed AES-256 GCM (`EncryptedSharedPreferences`).
                    </p>
                </x-card>

                <x-card class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900">Play Integrity Verification</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        `AppIntegrityManager.java` verifies that the running binary has not been tampered with or repackaged with malicious injections.
                    </p>
                </x-card>

                <x-card class="space-y-2">
                    <h3 class="text-base font-bold text-slate-900">Thread Priority Scheduler</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Background execution runs on prioritized background threads to ensure your phone's UI never stutters, even under heavy query execution.
                    </p>
                </x-card>
            </div>
        </section>

        <!-- Bottom CTA -->
        <div class="p-8 rounded-[10px] bg-slate-50 border border-slate-200 text-center space-y-4">
            <h3 class="text-2xl font-bold text-slate-900">Ready to Experience PocketSQL?</h3>
            <p class="text-sm text-slate-600">Download the APK directly or install the verified build from Google Play Store.</p>
            <div class="flex items-center justify-center space-x-4">
                <x-button variant="primary" href="{{ route('download') }}">Download Releases &rarr;</x-button>
                <x-button variant="secondary" href="{{ route('docs') }}">Read API Documentation</x-button>
            </div>
        </div>

    </div>

</x-layout>
