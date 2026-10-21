<div x-cloak
     x-show="$store.lightbox.isOpen" 
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @keydown.escape.window="$store.lightbox.close()"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-slate-950/80 backdrop-blur-sm">
     
    <!-- Overlay Click Close -->
    <div class="fixed inset-0" @click="$store.lightbox.close()"></div>

    <!-- Modal Container (Max 10px radius) -->
    <div class="relative bg-white border border-slate-200 rounded-[10px] max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden shadow-2xl z-10"
         @click.stop>
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 bg-slate-50">
            <div>
                <h3 class="text-base font-bold text-slate-900" x-text="$store.lightbox.title"></h3>
                <p class="text-xs text-slate-500 mt-0.5" x-text="$store.lightbox.subtitle"></p>
            </div>
            <button type="button" 
                    @click="$store.lightbox.close()" 
                    class="p-2 text-slate-400 hover:text-slate-700 rounded-[10px] hover:bg-slate-200 transition focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Image Viewer Body -->
        <div class="p-6 bg-slate-900 flex items-center justify-center overflow-auto max-h-[calc(90vh-120px)]">
            <img :src="$store.lightbox.imageSrc" 
                 :alt="$store.lightbox.title" 
                 class="max-w-full max-h-full object-contain rounded-[10px] shadow-lg border border-slate-800">
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-3 bg-white border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
            <span>Click outside or press <kbd class="px-1.5 py-0.5 bg-slate-100 border border-slate-300 rounded text-slate-700 font-mono text-[10px]">Esc</kbd> to exit</span>
            <button type="button" 
                    @click="$store.lightbox.close()"
                    class="px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-[10px] transition">
                Close Preview
            </button>
        </div>
    </div>
</div>
