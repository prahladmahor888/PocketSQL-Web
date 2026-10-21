<x-layout 
    title="Documentation &amp; REST API Reference — PocketSQL"
    description="Complete developer handbook and HTTP REST API documentation for PocketSQL. Learn how to query an Android SQL database via cURL, Python, Node.js, Go, and PHP over LAN/Wi-Fi."
    keywords="android sql rest api docs, query android sqlite over http, python android sql client, curl sqlite android, android lan database api"
>

    <!-- Page Header -->
    <div class="bg-slate-50 border-b border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-white px-3 py-1 rounded-[10px] border border-slate-200">Developer Handbook</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">HTTP &amp; REST API Reference</h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Connect external laptops, web services, microservices, and scripts to your PocketSQL database over the local network.
            </p>
        </div>
    </div>

    <!-- Docs Layout Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Left Sticky Sidebar Navigation -->
            <div class="lg:col-span-3">
                <div class="sticky top-28 space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 px-3">On This Page</h4>
                    <nav class="space-y-1 text-sm">
                        <a href="#getting-started" class="block px-3 py-2 rounded-[8px] text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition">
                            1. Getting Started
                        </a>
                        <a href="#api-specification" class="block px-3 py-2 rounded-[8px] text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition">
                            2. API Specification
                        </a>
                        <a href="#request-payload" class="block px-3 py-2 rounded-[8px] text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition">
                            3. Request Body Payload
                        </a>
                        <a href="#response-schema" class="block px-3 py-2 rounded-[8px] text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition">
                            4. Response Schemas
                        </a>
                        <a href="#client-sdk-code" class="block px-3 py-2 rounded-[8px] text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition">
                            5. Client Connectors (5 Languages)
                        </a>
                        <a href="#troubleshooting" class="block px-3 py-2 rounded-[8px] text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition">
                            6. Networking &amp; Firewall Tips
                        </a>
                    </nav>

                    <div class="p-4 rounded-[10px] bg-blue-50 border border-blue-200 space-y-2">
                        <div class="text-xs font-bold text-blue-900">Need Live Help?</div>
                        <p class="text-xs text-blue-700 leading-relaxed">
                            Join our community Discord or check GitHub issues for troubleshooting network connections.
                        </p>
                        <a href="https://discord.gg/pocketsql" target="_blank" rel="noopener" class="text-xs font-semibold text-blue-700 hover:underline block pt-1">
                            Join Discord Community &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Main Documentation Body -->
            <div class="lg:col-span-9 space-y-16">
                
                <!-- 1. Getting Started Guide -->
                <section id="getting-started" class="space-y-6 scroll-mt-28">
                    <div class="space-y-2 border-b border-slate-200 pb-4">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Step 1</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Getting Started with the Background Server</h2>
                    </div>

                    <div class="space-y-4 text-sm text-slate-600 leading-relaxed">
                        <p>
                            To allow other devices (such as your development computer or another phone) to send queries to PocketSQL, you must start the embedded HTTP API server:
                        </p>
                        <ol class="list-decimal pl-5 space-y-3">
                            <li>
                                <strong>Ensure Same Wi-Fi Network:</strong> Make sure both your Android phone and the querying device are on the same local Wi-Fi router (or connect your PC to your phone's Wi-Fi Hotspot).
                            </li>
                            <li>
                                <strong>Start the Server in App:</strong> Open PocketSQL on your device, navigate to the <strong>Server</strong> tab, and tap <strong>Start API Server</strong>. A persistent notification will appear in your Android status bar.
                            </li>
                            <li>
                                <strong>Note the IP &amp; Port:</strong> The active IP address and port will be displayed clearly (e.g., <code class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-800 font-mono text-xs">http://192.168.1.100:8080</code>).
                            </li>
                            <li>
                                <strong>Generate an API Key:</strong> Under <strong>API Keys</strong>, tap <em>Generate Token</em>, select your target database (or all databases), and choose <em>Read/Write</em> or <em>Read-Only</em> permissions.
                            </li>
                        </ol>
                    </div>
                </section>

                <!-- 2. HTTP API Reference Specification -->
                <section id="api-specification" class="space-y-6 scroll-mt-28">
                    <div class="space-y-2 border-b border-slate-200 pb-4">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Step 2</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">HTTP API Specification</h2>
                    </div>

                    <!-- Endpoint Card -->
                    <div class="bg-white border border-slate-200 rounded-[10px] p-6 shadow-sm space-y-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="px-3 py-1 bg-blue-600 text-white font-mono font-bold text-xs rounded-[6px]">POST</span>
                            <span class="font-mono text-sm sm:text-base font-semibold text-slate-900">/api/query</span>
                            <span class="ml-auto text-xs font-semibold px-2.5 py-0.5 rounded-[10px] bg-emerald-50 text-emerald-700 border border-emerald-200">Auth Required</span>
                        </div>
                        <p class="text-sm text-slate-600">
                            Executes a SQL query against the specified database and returns the result columns and rows as structured JSON.
                        </p>
                    </div>

                    <!-- Headers Table -->
                    <div class="space-y-3">
                        <h3 class="text-base font-bold text-slate-900">HTTP Request Headers</h3>
                        <div class="overflow-x-auto border border-slate-200 rounded-[10px]">
                            <table class="w-full text-left text-xs font-mono">
                                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 uppercase font-sans">
                                    <tr>
                                        <th class="px-4 py-3">Header</th>
                                        <th class="px-4 py-3">Value</th>
                                        <th class="px-4 py-3">Description</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 text-slate-600">
                                    <tr>
                                        <td class="px-4 py-3 font-bold text-slate-900">Authorization</td>
                                        <td class="px-4 py-3 text-blue-600">Bearer &lt;API_KEY&gt;</td>
                                        <td class="px-4 py-3 font-sans">Required bearer token generated in the PocketSQL app.</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 font-bold text-slate-900">Content-Type</td>
                                        <td class="px-4 py-3 text-emerald-600">application/json</td>
                                        <td class="px-4 py-3 font-sans">Must be set to `application/json`.</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 font-bold text-slate-900">Accept</td>
                                        <td class="px-4 py-3 text-slate-600">application/json</td>
                                        <td class="px-4 py-3 font-sans">Optional. Default is `application/json`.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- 3. Request Payload -->
                <section id="request-payload" class="space-y-6 scroll-mt-28">
                    <div class="space-y-2 border-b border-slate-200 pb-4">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Step 3</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Request Body Payload</h2>
                    </div>

                    <p class="text-sm text-slate-600">
                        The request body must be a valid JSON object containing the target database name and the SQL statement string:
                    </p>

                    <div class="bg-slate-900 border border-slate-800 rounded-[10px] overflow-hidden text-xs font-mono text-slate-200 p-5 relative">
                        <button type="button" 
                                onclick="copyToClipboard(this.nextElementSibling.innerText, this)"
                                class="absolute top-3 right-3 px-2 py-1 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-[6px] transition text-[11px]">
                            Copy Payload
                        </button>
                        <pre><code>{
  "database": "ecommerce",
  "sql": "SELECT id, product_name, price, stock FROM products WHERE stock > 0 LIMIT 5;"
}</code></pre>
                    </div>

                    <!-- Fields Breakdown -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-4 rounded-[10px] bg-slate-50 border border-slate-200 space-y-1">
                            <div class="font-mono font-bold text-slate-900">database <span class="text-red-500">*string</span></div>
                            <p class="text-slate-600">The name of the database file on the phone to execute the query against.</p>
                        </div>
                        <div class="p-4 rounded-[10px] bg-slate-50 border border-slate-200 space-y-1">
                            <div class="font-mono font-bold text-slate-900">sql <span class="text-red-500">*string</span></div>
                            <p class="text-slate-600">The ANSI SQL query (e.g., SELECT, INSERT, UPDATE, DELETE, CREATE TABLE).</p>
                        </div>
                    </div>
                </section>

                <!-- 4. Response Schemas -->
                <section id="response-schema" class="space-y-6 scroll-mt-28">
                    <div class="space-y-2 border-b border-slate-200 pb-4">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Step 4</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Response Schemas</h2>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 rounded-[6px] bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-mono font-bold">200 OK</span>
                            <span class="text-sm font-bold text-slate-900">Success Response Schema</span>
                        </div>

                        <div class="bg-slate-900 border border-slate-800 rounded-[10px] p-5 font-mono text-xs text-slate-200">
<pre><code>{
  "success": true,
  "columns": ["id", "product_name", "price", "stock"],
  "rows": [
    {"id": 1, "product_name": "Mechanical Keyboard", "price": 129.99, "stock": 45},
    {"id": 2, "product_name": "Ergonomic Mouse", "price": 89.50, "stock": 20}
  ],
  "affected_rows": 0,
  "executionTimeMs": 2.14
}</code></pre>
                        </div>
                    </div>

                    <div class="space-y-4 pt-4">
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 rounded-[6px] bg-red-50 text-red-700 border border-red-200 text-xs font-mono font-bold">400 / 403 / 500</span>
                            <span class="text-sm font-bold text-slate-900">Error Response Schema</span>
                        </div>

                        <div class="bg-slate-900 border border-slate-800 rounded-[10px] p-5 font-mono text-xs text-slate-200">
<pre><code>{
  "success": false,
  "error": "Error 1146 (42S02): Table 'ecommerce.invalid_table' doesn't exist"
}</code></pre>
                        </div>
                    </div>
                </section>

                <!-- 5. Client Connectors -->
                <section id="client-sdk-code" class="space-y-6 scroll-mt-28">
                    <div class="space-y-2 border-b border-slate-200 pb-4">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Step 5</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Copy-Paste Client Connectors</h2>
                    </div>

                    <p class="text-sm text-slate-600">
                        Choose your favorite programming language to copy a complete, production-ready snippet for interacting with PocketSQL:
                    </p>

                    <div class="bg-slate-900 border border-slate-800 rounded-[10px] overflow-hidden shadow-xl" x-data="{ activeTab: 'python' }">
                        <!-- Language Header -->
                        <div class="flex items-center justify-between px-4 py-2.5 bg-slate-950 border-b border-slate-800">
                            <div class="flex items-center space-x-1 sm:space-x-2 overflow-x-auto">
                                @foreach($codeSnippets as $snippet)
                                    <button type="button"
                                            @click="activeTab = '{{ $snippet->language }}'"
                                            :class="activeTab === '{{ $snippet->language }}' ? 'bg-blue-600 text-white font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800'"
                                            class="px-3 py-1.5 text-xs rounded-[8px] transition font-mono whitespace-nowrap">
                                        {{ $snippet->title }}
                                    </button>
                                @endforeach
                            </div>

                            <button type="button" 
                                    @click="
                                        let currentEl = document.querySelector('#docs-snippet-' + activeTab);
                                        if (currentEl) copyToClipboard(currentEl.innerText, $el);
                                    "
                                    class="inline-flex items-center px-3 py-1 text-xs font-mono text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 rounded-[8px] transition ml-2">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span>Copy Code</span>
                            </button>
                        </div>

                        <!-- Code Body -->
                        <div class="p-5 font-mono text-xs leading-relaxed overflow-x-auto text-slate-200 bg-slate-900">
                            @foreach($codeSnippets as $snippet)
                                <div x-show="activeTab === '{{ $snippet->language }}'" 
                                     x-cloak 
                                     id="docs-snippet-{{ $snippet->language }}">
                                    <pre class="font-mono"><code>{{ $snippet->code_content }}</code></pre>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <!-- 6. Troubleshooting & Networking Tips -->
                <section id="troubleshooting" class="space-y-6 scroll-mt-28">
                    <div class="space-y-2 border-b border-slate-200 pb-4">
                        <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">Troubleshooting</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Networking &amp; Firewall Tips</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-slate-600">
                        <x-card class="space-y-2">
                            <h4 class="font-bold text-slate-900">Router AP Client Isolation</h4>
                            <p class="leading-relaxed text-xs">
                                Some public university or office Wi-Fi networks enable "AP Client Isolation", which blocks devices on the same Wi-Fi from talking to each other. If you cannot reach your phone, enable <strong>Mobile Hotspot</strong> on your phone and connect your laptop directly to it.
                            </p>
                        </x-card>

                        <x-card class="space-y-2">
                            <h4 class="font-bold text-slate-900">TLS Self-Signed Warning</h4>
                            <p class="leading-relaxed text-xs">
                                When using HTTPS on port 8443, client libraries like cURL or Python will warn that the self-signed certificate is untrusted. Pass <code class="font-mono bg-slate-100 px-1 py-0.5 rounded text-[11px]">-k</code> in cURL or <code class="font-mono bg-slate-100 px-1 py-0.5 rounded text-[11px]">verify=False</code> in Python requests.
                            </p>
                        </x-card>
                    </div>
                </section>

            </div>

        </div>
    </div>

</x-layout>
