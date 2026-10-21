<x-layout title="About Us — The PocketSQL Story &amp; Architecture">

    <!-- Page Header -->
    <div class="bg-slate-50 border-b border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-white px-3 py-1 rounded-[10px] border border-slate-200">Our Mission</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">The Story Behind PocketSQL</h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Empowering students, developers, and makers with a self-contained, enterprise-grade relational database running locally on Android.
            </p>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">
        
        <!-- 1. The PocketSQL Story -->
        <section class="space-y-6">
            <div class="space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Origins</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Why We Built PocketSQL</h2>
            </div>
            <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed space-y-4">
                <p>
                    Every database learner and mobile engineer encounters the same obstacle: setting up an SQL database server typically requires either a running desktop workstation or a paid cloud instance on AWS, Google Cloud, or Heroku. For millions of engineering students and indie developers, renting cloud instances or keeping laptops running simply to test an API endpoint is cumbersome and costly.
                </p>
                <p>
                    Modern smartphones contain quad-core and octa-core processors with multi-gigabyte RAM, sitting idle in pockets for hours. <strong>PocketSQL was born from a simple realization:</strong> your mobile phone has more than enough processing power to run a fully functional, high-speed relational database and HTTP server.
                </p>
                <p>
                    Instead of bundling slow, bloated virtual machines or emulators, we engineered a native, pure-Java SQL engine that executes queries in user space without requiring root privileges.
                </p>
            </div>
        </section>

        <!-- 2. Architecture Philosophy (Grid Cards - Max 10px Radius) -->
        <section class="space-y-6">
            <div class="space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Under the Hood</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Architecture Philosophy</h2>
                <p class="text-sm text-slate-600">The four foundational pillars of PocketSQL's embedded execution model:</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Parser Card -->
                <x-card class="space-y-3">
                    <div class="w-10 h-10 rounded-[10px] bg-blue-50 text-blue-600 flex items-center justify-center font-bold">1</div>
                    <h3 class="text-lg font-bold text-slate-900">Pure-Java AST Parser</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Lexes and parses standard ANSI SQL syntax into an abstract syntax tree without JNI overhead or external binary dependencies. Handles nested subqueries, joins, and expressions directly on Android ART.
                    </p>
                </x-card>

                <!-- Storage Engine Card -->
                <x-card class="space-y-3">
                    <div class="w-10 h-10 rounded-[10px] bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">2</div>
                    <h3 class="text-lg font-bold text-slate-900">B-Tree Indexed Page Storage</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Data is organized in structured binary pages with fast index seeks and write-ahead logging (WAL). Reads execute in sub-milliseconds with minimal storage fragmentation on flash memory.
                    </p>
                </x-card>

                <!-- Transaction Manager Card -->
                <x-card class="space-y-3">
                    <div class="w-10 h-10 rounded-[10px] bg-purple-50 text-purple-600 flex items-center justify-center font-bold">3</div>
                    <h3 class="text-lg font-bold text-slate-900">ACID Transaction Coordinator</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Provides strict Atomicity, Consistency, Isolation, and Durability. Features checkpoint rollbacks, foreign key constraint verification, and atomic commit semantics.
                    </p>
                </x-card>

                <!-- Foreground Daemon Card -->
                <x-card class="space-y-3">
                    <div class="w-10 h-10 rounded-[10px] bg-amber-50 text-amber-600 flex items-center justify-center font-bold">4</div>
                    <h3 class="text-lg font-bold text-slate-900">Android Foreground Service</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Runs as an official Android persistent foreground service with a persistent notification. Ensures the operating system does not kill the HTTP/TLS API server while your phone is asleep.
                    </p>
                </x-card>
            </div>
        </section>

        <!-- 3. Core Principles -->
        <section class="space-y-6">
            <div class="space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Core Values</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Our Guiding Principles</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="p-6 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2">
                    <div class="text-blue-600 font-bold text-sm">🔒 100% Privacy First</div>
                    <h4 class="font-bold text-slate-900">Zero Cloud Uploads</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        No telemetry, no tracking, and no external servers. Everything stays on the device you own.
                    </p>
                </div>

                <div class="p-6 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2">
                    <div class="text-emerald-600 font-bold text-sm">🔓 Open Formats</div>
                    <h4 class="font-bold text-slate-900">Zero Vendor Lock-in</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Export your databases anytime as standard SQL scripts, SQLite `.db` binaries, or Excel sheets.
                    </p>
                </div>

                <div class="p-6 rounded-[10px] bg-slate-50 border border-slate-200 space-y-2">
                    <div class="text-purple-600 font-bold text-sm">❤️ Permissive MIT</div>
                    <h4 class="font-bold text-slate-900">Community Driven</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Free for commercial and personal usage forever. Built for and supported by the global dev community.
                    </p>
                </div>
            </div>
        </section>

        <!-- 4. Developer & Contributors Section -->
        <section class="p-8 rounded-[10px] bg-white border border-slate-200 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-[10px] bg-blue-600 text-white flex items-center justify-center font-extrabold text-2xl shadow-md">
                        PS
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">The PocketSQL Core Team</h3>
                        <p class="text-xs text-slate-500 font-medium">Independent Open-Source Software Engineers</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-[8px] bg-emerald-50 text-emerald-700 border border-emerald-200">
                                🇮🇳 Made with ❤️ in India
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="https://github.com/pocketsql/pocketsql" target="_blank" rel="noopener" 
                       class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-[10px] bg-slate-900 text-white hover:bg-slate-800 transition">
                        GitHub Profile
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-[10px] bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-300 transition">
                        Contact Developers
                    </a>
                </div>
            </div>
        </section>

    </div>

</x-layout>
