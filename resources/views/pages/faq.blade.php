<x-layout 
    title="Frequently Asked Questions (FAQ) — PocketSQL"
    description="Frequently asked questions about PocketSQL: root requirement, background daemon battery impact, TLS security, Wi-Fi connectivity, export formats, and SQLite compatibilities."
    keywords="pocketsql faq, android sql questions, does pocketsql require root, android rest api database battery life, sqlite android faq"
>

    <!-- Page Header -->
    <div class="bg-slate-50 border-b border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-white px-3 py-1 rounded-[10px] border border-slate-200">Knowledge Base</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Frequently Asked Questions</h1>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Find clear answers to common questions regarding permissions, root status, networking, battery usage, and query performance.
            </p>
        </div>
    </div>

    <!-- FAQ Interactive Section (Alpine.js Filter & Accordions) -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-8" 
         x-data="{ 
             selectedCategory: 'All', 
             openFaqId: null 
         }">

        <!-- Category Filter Tabs (Max 10px Radius) -->
        <div class="flex flex-wrap items-center justify-center gap-2 pb-4">
            <button type="button" 
                    @click="selectedCategory = 'All'"
                    :class="selectedCategory === 'All' ? 'bg-blue-600 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                    class="px-4 py-2 rounded-[10px] text-xs transition">
                All Topics
            </button>
            @foreach($categories as $category)
                <button type="button" 
                        @click="selectedCategory = '{{ $category }}'"
                        :class="selectedCategory === '{{ $category }}' ? 'bg-blue-600 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-[10px] text-xs transition">
                    {{ $category }}
                </button>
            @endforeach
        </div>

        <!-- FAQ Accordion List -->
        <div class="space-y-3">
            @foreach($faqs as $faq)
                <div class="border border-slate-200 rounded-[10px] overflow-hidden bg-white shadow-xs transition"
                     x-show="selectedCategory === 'All' || selectedCategory === '{{ $faq->category }}'"
                     x-cloak>
                    
                    <button type="button" 
                            @click="openFaqId = (openFaqId === {{ $faq->id }} ? null : {{ $faq->id }})"
                            class="w-full px-5 py-4 text-left flex items-center justify-between text-slate-900 font-bold text-sm sm:text-base hover:bg-slate-50 transition">
                        <div class="flex items-center space-x-3">
                            <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-[6px] bg-slate-100 text-slate-500 font-mono">
                                {{ $faq->category }}
                            </span>
                            <span>{{ $faq->question }}</span>
                        </div>
                        <svg class="w-5 h-5 text-slate-500 transition-transform duration-200 flex-shrink-0 ml-4"
                             :class="openFaqId === {{ $faq->id }} ? 'rotate-180 text-blue-600' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="openFaqId === {{ $faq->id }}" 
                         x-cloak 
                         class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        {{ $faq->answer }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Still have questions CTA card -->
        <div class="p-8 rounded-[10px] bg-slate-50 border border-slate-200 text-center space-y-3 mt-12">
            <h3 class="text-xl font-bold text-slate-900">Still have unanswered questions?</h3>
            <p class="text-xs text-slate-600 max-w-md mx-auto">
                Feel free to contact our engineering team directly or open an inquiry on our contact page.
            </p>
            <div class="pt-2">
                <x-button variant="primary" href="{{ route('contact') }}">
                    Contact Support Team &rarr;
                </x-button>
            </div>
        </div>

    </div>

    <!-- FAQPage JSON-LD Structured Data for Google SERP Rich Snippets -->
    @php
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->map(function($f) {
                return [
                    '@type' => 'Question',
                    'name' => $f->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $f->answer,
                    ],
                ];
            })->values()->toArray(),
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT) !!}
    </script>

</x-layout>
