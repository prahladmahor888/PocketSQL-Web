<x-admin.layout title="Social Media Channels — PocketSQL Admin">

    <div x-data="{
        addModalOpen: false,
        editModalOpen: false,
        activeLink: {
            id: null,
            platform: '',
            label: '',
            url: '',
            icon_svg: '',
            sort_order: 1,
            is_active: true
        },
        openAdd() {
            this.activeLink = {
                id: null,
                platform: '',
                label: '',
                url: '',
                icon_svg: '',
                sort_order: {{ $socialLinks->count() + 1 }},
                is_active: true
            };
            this.addModalOpen = true;
        },
        openEdit(link) {
            this.activeLink = JSON.parse(JSON.stringify(link));
            this.editModalOpen = true;
        },
        getPreviewIcon(val) {
            if (!val || typeof val !== 'string') return '';
            let s = val.trim();
            if (s === '' || s.startsWith('<svg')) return '';
            
            // Full FontAwesome class like 'fa-brands fa-instagram' or 'fa-solid fa-globe' or 'fab fa-...'
            if (s.includes(' ')) {
                return s;
            }
            
            // Shorthand 'fa-instagram' or 'fa-globe'
            if (s.startsWith('fa-')) {
                let name = s.replace(/^fa-/, '').toLowerCase();
                let solids = ['globe', 'phone', 'envelope', 'mail', 'link', 'location-dot', 'map-pin', 'comment', 'comments', 'headset', 'share-nodes', 'heart', 'star', 'user', 'gear', 'paper-plane', 'magnifying-glass', 'shield-halved'];
                if (solids.includes(name)) {
                    return 'fa-solid fa-' + name;
                }
                return 'fa-brands fa-' + name;
            }
            
            // Single word like 'instagram', 'youtube', 'discord', 'globe'
            let name = s.toLowerCase();
            let solids = ['globe', 'phone', 'envelope', 'mail', 'link', 'location', 'map', 'comment', 'chat'];
            if (solids.includes(name)) {
                return 'fa-solid fa-' + (name === 'mail' ? 'envelope' : name);
            }
            return 'fa-brands fa-' + name;
        },
        isSvg(val) {
            return typeof val === 'string' && val.trim().startsWith('<svg');
        }
    }" class="space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2.5">
                    <span class="w-9 h-9 rounded-[10px] bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm shadow-xs border border-indigo-200">
                        <i class="fa-solid fa-share-nodes"></i>
                    </span>
                    <span>Social Media Channels &amp; Community Icons</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">Manage public social icons across site footers and contact channels. Enter any FontAwesome class name to display icons instantly.</p>
            </div>

            <div class="flex items-center space-x-2">
                <a href="{{ route('contact') }}" target="_blank" class="px-3.5 py-2 rounded-[8px] bg-white border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-xs transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-slate-400"></i>
                    <span>Preview Contact Page</span>
                </a>
                <button type="button" 
                        @click="openAdd()"
                        class="px-4 py-2 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs shadow-blue-500/20 transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Add Social Channel</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-3.5 rounded-[10px] bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="p-3.5 rounded-[10px] bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
                <div class="font-bold flex items-center space-x-1.5">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Please correct the errors below:</span>
                </div>
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Summary Stat Pills -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="p-3.5 bg-white rounded-[10px] border border-slate-200 shadow-xs">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Total Channels</span>
                <span class="text-xl font-extrabold text-slate-900 font-mono">{{ $socialLinks->count() }}</span>
            </div>
            <div class="p-3.5 bg-white rounded-[10px] border border-slate-200 shadow-xs">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Active Online</span>
                <span class="text-xl font-extrabold text-emerald-600 font-mono">{{ $socialLinks->where('is_active', true)->count() }}</span>
            </div>
            <div class="p-3.5 bg-white rounded-[10px] border border-slate-200 shadow-xs">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Icon Engine</span>
                <span class="text-xs font-bold text-indigo-600 truncate block mt-1">FontAwesome 6 Free</span>
            </div>
            <div class="p-3.5 bg-white rounded-[10px] border border-slate-200 shadow-xs">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Active Channels</span>
                <span class="text-xs font-bold text-slate-700 truncate block mt-1">
                    {{ $socialLinks->pluck('label')->take(3)->join(', ') }}
                </span>
            </div>
        </div>

        <!-- Social Links Table -->
        <div class="bg-white border border-slate-200 rounded-[10px] shadow-xs overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-bold text-slate-900">Current Social Media Channels</span>
                    <span class="text-[11px] text-slate-400 font-mono">({{ $socialLinks->count() }} channels)</span>
                </div>
                <span class="text-[11px] text-slate-400">Order controls display sequence in footer</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4 w-16 text-center">Icon Preview</th>
                            <th class="py-3 px-4">Channel / Label</th>
                            <th class="py-3 px-4">Platform Key</th>
                            <th class="py-3 px-4">FontAwesome Class</th>
                            <th class="py-3 px-4">Destination Link</th>
                            <th class="py-3 px-3 text-center">Order</th>
                            <th class="py-3 px-3 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($socialLinks as $link)
                            <tr class="hover:bg-slate-50/80 transition">
                                <!-- Rendered Icon Preview -->
                                <td class="py-3 px-4 text-center">
                                    <div class="w-9 h-9 rounded-[8px] bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-600 border border-slate-200 flex items-center justify-center mx-auto text-base shadow-2xs transition">
                                        @if(str_starts_with(trim($link->icon_svg), '<svg'))
                                            <span class="w-4 h-4 inline-flex items-center justify-center fill-current">{!! $link->icon_svg !!}</span>
                                        @elseif(!empty($link->icon_svg))
                                            <i class="{{ $link->icon_svg }}"></i>
                                        @else
                                            <i class="fa-brands fa-{{ strtolower($link->platform) }}"></i>
                                        @endif
                                    </div>
                                </td>

                                <!-- Channel Label -->
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    <span class="text-sm">{{ $link->label }}</span>
                                </td>

                                <!-- Platform Key -->
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded-[4px] bg-slate-100 text-slate-700 font-mono text-[10px] font-bold uppercase">
                                        {{ $link->platform }}
                                    </span>
                                </td>

                                <!-- FontAwesome Class Badge -->
                                <td class="py-3.5 px-4 font-mono text-[11px]">
                                    @if(str_starts_with(trim($link->icon_svg), '<svg'))
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-[4px] bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-bold">
                                            <i class="fa-solid fa-code mr-1"></i> Custom SVG
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] bg-indigo-50 text-indigo-700 border border-indigo-200 text-[11px] font-bold">
                                            <i class="{{ $link->icon_svg }} mr-1.5 text-indigo-600 text-xs"></i>
                                            <code>{{ $link->icon_svg }}</code>
                                        </span>
                                    @endif
                                </td>

                                <!-- Destination URL -->
                                <td class="py-3.5 px-4 max-w-xs">
                                    <a href="{{ $link->url }}" target="_blank" rel="noopener" class="text-blue-600 hover:underline truncate block font-mono text-[11px]" title="{{ $link->url }}">
                                        {{ $link->url }}
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px] ml-1 opacity-70"></i>
                                    </a>
                                </td>

                                <!-- Sort Order -->
                                <td class="py-3.5 px-3 text-center font-mono font-bold text-slate-600">
                                    {{ $link->sort_order }}
                                </td>

                                <!-- Status -->
                                <td class="py-3.5 px-3 text-center">
                                    @if($link->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] bg-slate-100 text-slate-500 text-[10px] font-bold border border-slate-200">
                                            Hidden
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center space-x-1.5">
                                        <button type="button" 
                                                @click="openEdit({{ $link->toJson() }})"
                                                class="px-2.5 py-1.5 rounded-[6px] bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-600 border border-slate-200 transition text-[11px] font-semibold flex items-center space-x-1">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Edit</span>
                                        </button>

                                        <form action="{{ route('admin.social-links.destroy', $link) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this social link ({{ $link->label }})?');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-2.5 py-1.5 rounded-[6px] bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 transition text-[11px] font-semibold flex items-center space-x-1">
                                                <i class="fa-solid fa-trash"></i>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-10 text-slate-400">
                                    <i class="fa-solid fa-share-nodes text-3xl mb-2 block"></i>
                                    <span>No social media links added. Click "Add Social Channel" to create one.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- 1. ADD MODAL (100% BULLETPROOF RESPONSIVE, ZERO PRE-ADDED ICONS) -->
        <!-- ============================================================ -->
        <div x-show="addModalOpen" 
             x-cloak 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="add-modal-title" role="dialog" aria-modal="true"
             @keydown.escape.window="addModalOpen = false">
            
            <!-- Backdrop Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" 
                 @click="addModalOpen = false"
                 aria-hidden="true"></div>

            <!-- Centering flex shell with min-h-full for smooth mobile scrolling without cutoff -->
            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
                
                <!-- Modal Card (Strictly constrained compact width: max 480px) -->
                <div @click.stop
                     style="max-width: 480px; width: 100%;"
                     class="relative transform rounded-[10px] bg-white text-left shadow-2xl border border-slate-200 transition-all w-full max-w-md p-4 sm:p-5 my-auto flex flex-col max-h-[90vh]">
                    
                    <!-- Fixed Header -->
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 flex-shrink-0">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-8 h-8 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-xs flex-shrink-0">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <div>
                                <h3 id="add-modal-title" class="text-sm font-bold text-slate-900">Add Social Media Channel</h3>
                                <p class="text-[11px] text-slate-500">Type any class name to render the icon live.</p>
                            </div>
                        </div>
                        <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-[6px] hover:bg-slate-100 transition">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <!-- Scrollable Form Container -->
                    <form action="{{ route('admin.social-links.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden mt-3">
                        @csrf

                        <div class="overflow-y-auto pr-1 flex-1 space-y-3.5">
                            
                            <!-- ICON CLASS INPUT: NO PRE-ADDED ICONS, INSTANT LIVE PREVIEW -->
                            <div class="p-3 sm:p-3.5 bg-slate-50 rounded-[10px] border border-slate-200 space-y-2">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold text-slate-800 flex items-center space-x-1.5">
                                        <i class="fa-solid fa-font-awesome text-indigo-600"></i>
                                        <span>FontAwesome Class Name <span class="text-red-500">*</span></span>
                                    </label>
                                    <span class="text-[10px] font-semibold text-emerald-600 flex items-center" x-show="getPreviewIcon(activeLink.icon_svg)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span>
                                        Live Icon Preview
                                    </span>
                                </div>

                                <div class="flex items-center gap-2.5">
                                    <!-- Big Live Icon Preview Box -->
                                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-[8px] bg-white border border-slate-300 flex items-center justify-center flex-shrink-0 shadow-2xs transition">
                                        <template x-if="getPreviewIcon(activeLink.icon_svg) && !isSvg(activeLink.icon_svg)">
                                            <i :class="getPreviewIcon(activeLink.icon_svg)" class="text-xl sm:text-2xl text-blue-600"></i>
                                        </template>
                                        <template x-if="isSvg(activeLink.icon_svg)">
                                            <span class="w-6 h-6 inline-flex items-center justify-center fill-current text-blue-600" x-html="activeLink.icon_svg"></span>
                                        </template>
                                        <template x-if="!activeLink.icon_svg || activeLink.icon_svg.trim() === ''">
                                            <i class="fa-solid fa-icons text-slate-300 text-lg sm:text-xl"></i>
                                        </template>
                                    </div>

                                    <!-- Clean Class Input Field -->
                                    <div class="flex-1 min-w-0">
                                        <input type="text" 
                                               name="icon_svg" 
                                               required 
                                               x-model="activeLink.icon_svg" 
                                               placeholder="e.g. fa-brands fa-instagram"
                                               class="w-full px-3 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 bg-white text-xs font-mono font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <p class="text-[10px] text-slate-400">
                                    Enter class name (e.g. <code class="font-mono text-indigo-600 bg-indigo-50/80 px-1 py-0.5 rounded font-bold">fa-brands fa-instagram</code>, <code class="font-mono text-indigo-600 bg-indigo-50/80 px-1 py-0.5 rounded font-bold">fa-brands fa-youtube</code>, or <code class="font-mono text-indigo-600 bg-indigo-50/80 px-1 py-0.5 rounded font-bold">fa-solid fa-globe</code>).
                                </p>
                            </div>

                            <!-- DISPLAY LABEL & PLATFORM KEY (Responsive: 1 col on mobile, 2 cols on sm+) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-slate-700">Display Label <span class="text-red-500">*</span></label>
                                    <input type="text" name="label" required x-model="activeLink.label" placeholder="e.g. Instagram"
                                           class="w-full px-3 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-slate-700">Platform Identifier <span class="text-red-500">*</span></label>
                                    <input type="text" name="platform" required x-model="activeLink.platform" placeholder="e.g. instagram"
                                           class="w-full px-3 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <!-- DESTINATION URL -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Destination URL <span class="text-red-500">*</span></label>
                                <input type="url" name="url" required x-model="activeLink.url" placeholder="https://instagram.com/yourhandle"
                                       class="w-full px-3 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- SORT ORDER & STATUS -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-slate-700">Display Priority Order</label>
                                    <input type="number" name="sort_order" x-model="activeLink.sort_order" min="0"
                                           class="w-full px-3 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="pt-1 sm:pt-5">
                                    <label class="flex items-center space-x-2.5 cursor-pointer text-xs p-2 rounded-[8px] bg-slate-50 border border-slate-200">
                                        <input type="checkbox" name="is_active" value="1" checked class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4">
                                        <span class="font-bold text-slate-800">Visible on Public Site</span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <!-- Fixed Action Buttons Footer (Responsive: full width on mobile, inline on desktop) -->
                        <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2 pt-3 mt-3 border-t border-slate-100 flex-shrink-0">
                            <button type="button" @click="addModalOpen = false"
                                    class="w-full sm:w-auto px-4 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 bg-white text-slate-700 font-bold text-xs hover:bg-slate-50 text-center transition">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="w-full sm:w-auto px-5 py-2 sm:py-2.5 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs text-center transition">
                                Add Social Channel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- 2. EDIT MODAL (100% BULLETPROOF RESPONSIVE, ZERO PRE-ADDED ICONS) -->
        <!-- ============================================================ -->
        <div x-show="editModalOpen" 
             x-cloak 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="edit-modal-title" role="dialog" aria-modal="true"
             @keydown.escape.window="editModalOpen = false">
            
            <!-- Backdrop Overlay -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" 
                 @click="editModalOpen = false"
                 aria-hidden="true"></div>

            <!-- Centering flex shell with min-h-full for smooth mobile scrolling without cutoff -->
            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
                
                <!-- Modal Card (Strictly constrained compact width: max 480px) -->
                <div @click.stop
                     style="max-width: 480px; width: 100%;"
                     class="relative transform rounded-[10px] bg-white text-left shadow-2xl border border-slate-200 transition-all w-full max-w-md p-4 sm:p-5 my-auto flex flex-col max-h-[90vh]">
                    
                    <!-- Fixed Header -->
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 flex-shrink-0">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-8 h-8 rounded-[8px] bg-amber-50 text-amber-600 flex items-center justify-center text-xs flex-shrink-0">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div>
                                <h3 id="edit-modal-title" class="text-sm font-bold text-slate-900">Edit Social Channel</h3>
                                <p class="text-[11px] text-slate-500">Update class name, URL, or channel details.</p>
                            </div>
                        </div>
                        <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-[6px] hover:bg-slate-100 transition">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <!-- Scrollable Form Container -->
                    <form :action="'{{ url('/admin/social-links') }}/' + activeLink.id" method="POST" class="flex flex-col flex-1 overflow-hidden mt-3">
                        @csrf
                        @method('PUT')

                        <div class="overflow-y-auto pr-1 flex-1 space-y-3.5">
                            
                            <!-- ICON CLASS INPUT: NO PRE-ADDED ICONS, INSTANT LIVE PREVIEW -->
                            <div class="p-3 sm:p-3.5 bg-slate-50 rounded-[10px] border border-slate-200 space-y-2">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold text-slate-800 flex items-center space-x-1.5">
                                        <i class="fa-solid fa-font-awesome text-indigo-600"></i>
                                        <span>FontAwesome Class Name <span class="text-red-500">*</span></span>
                                    </label>
                                    <span class="text-[10px] font-semibold text-emerald-600 flex items-center" x-show="getPreviewIcon(activeLink.icon_svg)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span>
                                        Live Icon Preview
                                    </span>
                                </div>

                                <div class="flex items-center gap-2.5">
                                    <!-- Big Live Icon Preview Box -->
                                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-[8px] bg-white border border-slate-300 flex items-center justify-center flex-shrink-0 shadow-2xs transition">
                                        <template x-if="getPreviewIcon(activeLink.icon_svg) && !isSvg(activeLink.icon_svg)">
                                            <i :class="getPreviewIcon(activeLink.icon_svg)" class="text-xl sm:text-2xl text-blue-600"></i>
                                        </template>
                                        <template x-if="isSvg(activeLink.icon_svg)">
                                            <span class="w-6 h-6 inline-flex items-center justify-center fill-current text-blue-600" x-html="activeLink.icon_svg"></span>
                                        </template>
                                        <template x-if="!activeLink.icon_svg || activeLink.icon_svg.trim() === ''">
                                            <i class="fa-solid fa-icons text-slate-300 text-lg sm:text-xl"></i>
                                        </template>
                                    </div>

                                    <!-- Clean Class Input Field -->
                                    <div class="flex-1 min-w-0">
                                        <input type="text" 
                                               name="icon_svg" 
                                               required 
                                               x-model="activeLink.icon_svg" 
                                               placeholder="e.g. fa-brands fa-instagram"
                                               class="w-full px-3 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 bg-white text-xs font-mono font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <p class="text-[10px] text-slate-400">
                                    Enter class name (e.g. <code class="font-mono text-indigo-600 bg-indigo-50/80 px-1 py-0.5 rounded font-bold">fa-brands fa-instagram</code>, <code class="font-mono text-indigo-600 bg-indigo-50/80 px-1 py-0.5 rounded font-bold">fa-brands fa-youtube</code>, or <code class="font-mono text-indigo-600 bg-indigo-50/80 px-1 py-0.5 rounded font-bold">fa-solid fa-globe</code>).
                                </p>
                            </div>

                            <!-- DISPLAY LABEL & PLATFORM KEY (Responsive: 1 col on mobile, 2 cols on sm+) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-slate-700">Display Label <span class="text-red-500">*</span></label>
                                    <input type="text" name="label" required x-model="activeLink.label"
                                           class="w-full px-3 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-slate-700">Platform Identifier <span class="text-red-500">*</span></label>
                                    <input type="text" name="platform" required x-model="activeLink.platform"
                                           class="w-full px-3 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <!-- DESTINATION URL -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Destination URL <span class="text-red-500">*</span></label>
                                <input type="url" name="url" required x-model="activeLink.url"
                                       class="w-full px-3 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- SORT ORDER & STATUS -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-slate-700">Display Priority Order</label>
                                    <input type="number" name="sort_order" x-model="activeLink.sort_order" min="0"
                                           class="w-full px-3 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="pt-1 sm:pt-5">
                                    <label class="flex items-center space-x-2.5 cursor-pointer text-xs p-2 rounded-[8px] bg-slate-50 border border-slate-200">
                                        <input type="checkbox" name="is_active" value="1" :checked="activeLink.is_active" class="rounded text-blue-600 focus:ring-blue-500 w-4 h-4">
                                        <span class="font-bold text-slate-800">Visible on Public Site</span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <!-- Fixed Action Buttons Footer (Responsive: full width on mobile, inline on desktop) -->
                        <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2 pt-3 mt-3 border-t border-slate-100 flex-shrink-0">
                            <button type="button" @click="editModalOpen = false"
                                    class="w-full sm:w-auto px-4 py-2 sm:py-2.5 rounded-[8px] border border-slate-300 bg-white text-slate-700 font-bold text-xs hover:bg-slate-50 text-center transition">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="w-full sm:w-auto px-5 py-2 sm:py-2.5 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs text-center transition">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</x-admin.layout>
