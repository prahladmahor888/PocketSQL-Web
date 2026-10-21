@php
    $currentRoute = Route::currentRouteName();
    $navLinks = [
        ['name' => 'Home', 'route' => 'home', 'icon' => 'fa-solid fa-house'],
        ['name' => 'Features', 'route' => 'features', 'icon' => 'fa-solid fa-cubes'],
        ['name' => 'About', 'route' => 'about', 'icon' => 'fa-solid fa-circle-info'],
        ['name' => 'Documentation', 'route' => 'docs', 'icon' => 'fa-solid fa-book-bookmark'],
        ['name' => 'Download', 'route' => 'download', 'icon' => 'fa-solid fa-download'],
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

            <!-- Desktop Navigation Links (Large Screens >= 1024px) -->
            <nav class="hidden lg:flex items-center space-x-1 xl:space-x-2">
                @foreach($navLinks as $link)
                    @php
                        $isActive = ($currentRoute === $link['route']);
                    @endphp
                    <a href="{{ route($link['route']) }}" 
                       class="px-3 py-2 text-sm font-semibold rounded-[8px] transition duration-150 {{ $isActive ? 'text-blue-600 bg-blue-50 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        {{ $link['name'] }}
                    </a>
                @endforeach
            </nav>

            <!-- Action Area: Donate Button + Tablet & Mobile Hamburger Button -->
            <div class="flex items-center space-x-2 sm:space-x-3 flex-shrink-0">
                <a href="{{ route('donate') }}" 
                   class="inline-flex items-center justify-center px-3.5 py-2 text-sm font-semibold rounded-[8px] text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-all duration-200 shadow-2xs hover:-translate-y-0.5 active:scale-95">
                    <i class="fa-solid fa-heart mr-1.5 text-blue-600 transition-transform group-hover:scale-110"></i>
                    <span>Donate</span>
                </a>

                <!-- Tablet & Mobile Hamburger Button (Visible on screens < 1024px) -->
                <div class="flex items-center lg:hidden">
                    <button type="button" 
                            @click="mobileOpen = !mobileOpen"
                            class="p-2 rounded-[8px] text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none transition"
                            aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars text-xl" x-show="!mobileOpen"></i>
                        <i class="fa-solid fa-xmark text-xl" x-show="mobileOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablet & Mobile Navigation Drawer (Visible on screens < 1024px when opened) -->
    <div class="lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-1 shadow-lg" 
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
               class="flex items-center space-x-3 px-3.5 py-3 text-base font-semibold rounded-[8px] transition {{ $isActive ? 'text-blue-600 bg-blue-50' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="{{ $link['icon'] }} w-5 text-center {{ $isActive ? 'text-blue-600' : 'text-slate-400' }}"></i>
                <span>{{ $link['name'] }}</span>
            </a>
        @endforeach
        
        <div class="pt-4 mt-2 border-t border-slate-100">
            <a href="{{ route('donate') }}" class="flex items-center justify-center w-full px-4 py-3 text-sm font-semibold rounded-[8px] text-blue-600 bg-blue-50 border border-blue-200 hover:bg-blue-100 transition shadow-2xs">
                <i class="fa-solid fa-heart mr-2 text-blue-600"></i>
                <span>Donate &amp; Sponsor PocketSQL</span>
            </a>
        </div>
    </div>
</header>
