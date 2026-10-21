@php
    $currentRoute = Route::currentRouteName();
    $navLinks = [
        ['name' => 'Home', 'route' => 'home', 'icon' => 'fa-solid fa-house'],
        ['name' => 'Features', 'route' => 'features', 'icon' => 'fa-solid fa-cubes'],
        ['name' => 'About', 'route' => 'about', 'icon' => 'fa-solid fa-circle-info'],
        ['name' => 'Documentation', 'route' => 'docs', 'icon' => 'fa-solid fa-book-bookmark'],
        ['name' => 'Download', 'route' => 'download', 'icon' => 'fa-solid fa-download'],
        ['name' => 'Donate', 'route' => 'donate', 'icon' => 'fa-solid fa-heart'],
        ['name' => 'FAQ', 'route' => 'faq', 'icon' => 'fa-solid fa-circle-question'],
        ['name' => 'Contact', 'route' => 'contact', 'icon' => 'fa-solid fa-envelope'],
    ];
@endphp

<header class="sticky top-0 z-40 bg-white border-b border-slate-200 transition duration-200 shadow-xs" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Brand Logo -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="PocketSQL Logo" class="h-10 w-10 rounded-[10px] object-cover shadow-xs transition-transform group-hover:scale-105 border border-slate-200">
                    <div class="flex flex-col">
                        <span class="text-xl font-extrabold tracking-tight text-slate-900 leading-none">
                            Pocket<span class="text-blue-600">SQL</span>
                        </span>
                        <span class="text-[9px] font-mono font-bold uppercase tracking-wider text-slate-400 mt-1">
                            Android Engine
                        </span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation Links (Clean Flex Gap) -->
            <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                @foreach($navLinks as $link)
                    @php
                        $isActive = ($currentRoute === $link['route']);
                    @endphp
                    <a href="{{ route($link['route']) }}" 
                       class="px-2.5 py-1.5 lg:px-3 lg:py-2 text-xs lg:text-sm font-semibold rounded-[8px] transition duration-150 {{ $isActive ? 'text-blue-600 bg-blue-50 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        {{ $link['name'] }}
                    </a>
                @endforeach
            </nav>

            <!-- Desktop Action Buttons with Font Awesome -->
            <div class="hidden lg:flex items-center gap-2.5 flex-shrink-0">
                <a href="{{ route('download.apk') }}" 
                   class="inline-flex items-center justify-center px-3.5 py-2 text-xs font-semibold rounded-[8px] text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:border-slate-400 shadow-xs transition">
                    <i class="fa-solid fa-download mr-1.5 text-blue-600"></i>
                    <span>APK Direct</span>
                </a>
                <a href="https://play.google.com/store/apps/details?id=app.pocketsql.database" target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold rounded-[8px] text-white bg-blue-600 hover:bg-blue-700 shadow-xs shadow-blue-500/20 transition">
                    <i class="fa-brands fa-google-play mr-1.5 text-white"></i>
                    <span>Google Play</span>
                </a>
            </div>

            <!-- Mobile Hamburger Button with Font Awesome Icons -->
            <div class="flex items-center md:hidden">
                <button type="button" 
                        @click="mobileOpen = !mobileOpen"
                        class="p-2 rounded-[8px] text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none transition"
                        aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars text-xl" x-show="!mobileOpen"></i>
                    <i class="fa-solid fa-xmark text-xl" x-show="mobileOpen" x-cloak></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div class="md:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-1 shadow-lg" 
         x-show="mobileOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.away="mobileOpen = false">
        
        @foreach($navLinks as $link)
            @php
                $isActive = ($currentRoute === $link['route']);
            @endphp
            <a href="{{ route($link['route']) }}" 
               class="flex items-center space-x-3 px-3 py-2.5 text-sm font-semibold rounded-[8px] transition {{ $isActive ? 'text-blue-600 bg-blue-50' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="{{ $link['icon'] }} w-5 text-center {{ $isActive ? 'text-blue-600' : 'text-slate-400' }}"></i>
                <span>{{ $link['name'] }}</span>
            </a>
        @endforeach
        
        <div class="pt-4 mt-2 border-t border-slate-100 grid grid-cols-2 gap-2">
            <a href="{{ route('download.apk') }}" class="flex items-center justify-center px-4 py-2.5 text-xs font-bold rounded-[8px] text-slate-700 bg-slate-50 border border-slate-300 hover:bg-slate-100 transition">
                <i class="fa-solid fa-download mr-1.5 text-blue-600"></i>
                <span>Direct APK</span>
            </a>
            <a href="https://play.google.com/store/apps/details?id=app.pocketsql.database" target="_blank" rel="noopener" class="flex items-center justify-center px-4 py-2.5 text-xs font-bold rounded-[8px] text-white bg-blue-600 hover:bg-blue-700 shadow-xs shadow-blue-500/20 transition">
                <i class="fa-brands fa-google-play mr-1.5"></i>
                <span>Google Play</span>
            </a>
        </div>
    </div>
</header>
