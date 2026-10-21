<x-admin.layout title="App Screenshots Management — PocketSQL Admin">

    <!-- Header -->
    <div class="border-b border-slate-200 pb-5">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2.5">
            <i class="fa-solid fa-mobile-screen text-purple-600"></i>
            <span>Mobile Screenshots &amp; Showcase Manager</span>
        </h1>
        <p class="text-xs text-slate-500 mt-1">Upload, edit, reorder, or remove application showcase screenshots displayed across the website and hero mockup.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
        
        <!-- Left: Upload / Add New Screenshot Form -->
        <div class="lg:col-span-5 bg-white border border-slate-200 rounded-[10px] p-5 sm:p-6 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                    <i class="fa-solid fa-cloud-arrow-up text-blue-600"></i>
                    <span>Upload New Screenshot</span>
                </h3>
                <p class="text-xs text-slate-500">Add an image directly to the public showcase.</p>
            </div>

            @if($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-[8px] flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('admin.screenshots.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf

                <div class="space-y-1">
                    <label for="title" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-heading text-slate-400 text-[11px]"></i>
                        <span>Screenshot Title</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" required value="{{ old('title') }}" placeholder="e.g. Interactive Terminal Console" class="w-full p-2.5 rounded-[8px] border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="space-y-1">
                    <label for="subtitle" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-align-left text-slate-400 text-[11px]"></i>
                        <span>Subtitle / Description</span>
                    </label>
                    <textarea id="subtitle" name="subtitle" rows="2" placeholder="Brief caption explaining the screen..." class="w-full p-2.5 rounded-[8px] border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">{{ old('subtitle') }}</textarea>
                </div>

                <!-- File Upload -->
                <div class="space-y-1">
                    <label for="image_file" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-file-image text-slate-400 text-[11px]"></i>
                        <span>Upload Image File (PNG / JPG / WEBP)</span>
                    </label>
                    <input type="file" id="image_file" name="image_file" accept="image/*" class="w-full p-2 rounded-[8px] border border-slate-300 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-[6px] file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <span class="text-[11px] text-slate-400">Max size: 8 MB. Mobile screenshots are automatically optimized.</span>
                </div>

                <!-- Alternative Image URL / Path -->
                <div class="space-y-1">
                    <label for="image_path" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-link text-slate-400 text-[11px]"></i>
                        <span>Or Existing Image URL / Path</span>
                    </label>
                    <input type="text" id="image_path" name="image_path" value="{{ old('image_path') }}" placeholder="/images/screenshots/sample.png" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                    <div class="space-y-1">
                        <label for="sort_order" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-arrow-down-1-9 text-slate-400 text-[11px]"></i>
                            <span>Display Order</span>
                        </label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', count($screenshots) + 1) }}" min="0" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="pt-2 sm:pt-4">
                        <label class="flex items-center space-x-2 text-slate-700 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span class="font-bold flex items-center space-x-1">
                                <i class="fa-solid fa-star text-amber-500 text-xs"></i>
                                <span>Feature on Home</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-[8px] shadow-sm shadow-blue-500/20 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>Add Screenshot to Gallery</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Right: Current Active Screenshots Grid -->
        <div class="lg:col-span-7 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                        <i class="fa-solid fa-images text-purple-600"></i>
                        <span>Current Showcase ({{ count($screenshots) }} Screens)</span>
                    </h3>
                    <p class="text-xs text-slate-500">Screenshots visible in the homepage carousel, modal lightbox, and features breakdown.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($screenshots as $ss)
                    <div class="bg-white border border-slate-200 rounded-[10px] overflow-hidden shadow-xs hover:border-slate-300 transition flex flex-col justify-between">
                        <!-- Image Container with Mobile Frame Look -->
                        <div class="aspect-[9/16] max-h-72 bg-slate-950 relative overflow-hidden flex items-center justify-center group">
                            <img src="{{ asset($ss->image_path) }}" 
                                 alt="{{ $ss->title }}" 
                                 class="w-full h-full object-contain p-2">

                            <!-- Floating Badges -->
                            <div class="absolute top-2 left-2 flex items-center space-x-1.5">
                                <span class="bg-slate-900/80 text-white text-[10px] font-mono px-2 py-0.5 rounded-[6px] backdrop-blur-xs flex items-center space-x-1">
                                    <i class="fa-solid fa-hashtag text-[8px]"></i>
                                    <span>{{ $ss->sort_order }}</span>
                                </span>
                                @if($ss->is_featured)
                                    <span class="bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-[6px] shadow-xs flex items-center space-x-1">
                                        <i class="fa-solid fa-star text-[8px]"></i>
                                        <span>Featured</span>
                                    </span>
                                @endif
                            </div>

                            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
                                <a href="{{ asset($ss->image_path) }}" target="_blank" 
                                   class="px-3 py-1.5 rounded-[8px] bg-white text-slate-900 font-bold text-xs flex items-center space-x-1 hover:bg-slate-100 transition">
                                    <i class="fa-solid fa-up-right-and-down-left-from-center text-[11px]"></i>
                                    <span>Zoom</span>
                                </a>
                            </div>
                        </div>

                        <!-- Card Content & Actions -->
                        <div class="p-4 space-y-3 bg-white">
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm truncate">{{ $ss->title }}</h4>
                                <p class="text-xs text-slate-500 line-clamp-2 mt-0.5">{{ $ss->subtitle ?? 'No caption provided.' }}</p>
                            </div>

                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                                <!-- Feature Toggle Form -->
                                <form action="{{ route('admin.screenshots.toggle', $ss, false) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center space-x-1 font-semibold px-2 py-1 rounded-[6px] text-xs transition cursor-pointer {{ $ss->is_featured ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-slate-600 bg-slate-100 hover:bg-slate-200' }}">
                                        <i class="fa-solid fa-star text-[10px] {{ $ss->is_featured ? 'text-amber-500' : 'text-slate-400' }}"></i>
                                        <span>{{ $ss->is_featured ? 'Featured' : 'Mark Featured' }}</span>
                                    </button>
                                </form>

                                <!-- Delete Action with Bulletproof In-Place Confirmation -->
                                <div x-data="{ confirming: false }" class="inline-block">
                                    <button type="button" 
                                            x-show="!confirming" 
                                            @click="confirming = true"
                                            class="inline-flex items-center space-x-1 text-red-600 hover:text-red-700 font-bold px-2 py-1 rounded-[6px] hover:bg-red-50 transition cursor-pointer">
                                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                                        <span>Delete</span>
                                    </button>

                                    <div x-show="confirming" x-cloak class="flex items-center space-x-1">
                                        <form action="{{ route('admin.screenshots.destroy', $ss, false) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-2 py-1 rounded-[6px] bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                                                Confirm
                                            </button>
                                        </form>
                                        <button type="button" 
                                                @click="confirming = false" 
                                                class="px-1.5 py-1 rounded-[6px] bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition cursor-pointer" 
                                                title="Cancel">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-dashed border-slate-300 rounded-[10px] p-8 text-center text-slate-400 space-y-2">
                        <i class="fa-solid fa-images text-3xl text-slate-300"></i>
                        <div class="font-medium text-slate-600">No screenshots added yet.</div>
                        <div class="text-xs">Use the upload form on the left to add your first mobile screenshot.</div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</x-admin.layout>
