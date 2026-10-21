<x-admin.layout title="Releases Management — PocketSQL Admin">

    <!-- Header -->
    <div class="border-b border-slate-200 pb-5">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2.5">
            <i class="fa-solid fa-code-branch text-emerald-600"></i>
            <span>Android Releases Management</span>
        </h1>
        <p class="text-xs text-slate-500 mt-1">Publish new APK releases, update changelogs, and manage SHA-256 integrity checksums.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
        
        <!-- Left: Create New Release Form (Max 10px Radius) -->
        <div class="lg:col-span-5 bg-white border border-slate-200 rounded-[10px] p-5 sm:p-6 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                    <i class="fa-solid fa-circle-plus text-emerald-600"></i>
                    <span>Publish New Release</span>
                </h3>
                <p class="text-xs text-slate-500">Add an APK build to the public download archive.</p>
            </div>

            <form action="{{ route('admin.releases.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf

                <!-- Drag & Drop APK File Upload with Automatic Size Detection -->
                <div x-data="{
                    isDragging: false,
                    fileName: '',
                    fileSizeFormatted: '',
                    sha256Status: '',
                    handleFiles(files) {
                        if (!files || files.length === 0) return;
                        const file = files[0];
                        if (!file.name.toLowerCase().endsWith('.apk')) {
                            alert('Please upload a valid .apk file.');
                            return;
                        }
                        this.fileName = file.name;
                        
                        // Automatic size calculation and population
                        const mb = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                        this.fileSizeFormatted = mb;
                        const sizeInput = document.getElementById('apk_size');
                        if (sizeInput) {
                            sizeInput.value = mb;
                        }

                        // Auto version suggestion if in filename (e.g. PocketSQL-v1.0.6.apk)
                        const match = file.name.match(/v?(\d+\.\d+\.\d+)/i);
                        const versionInput = document.getElementById('version');
                        if (match && versionInput && !versionInput.value) {
                            versionInput.value = match[0].startsWith('v') ? match[0] : 'v' + match[0];
                        }

                        // Calculate SHA-256 hash using browser Web Crypto API
                        const hashInput = document.getElementById('sha256_hash');
                        if (hashInput && window.crypto && window.crypto.subtle) {
                            this.sha256Status = 'Calculating SHA-256...';
                            const reader = new FileReader();
                            reader.onload = async (e) => {
                                try {
                                    const hashBuffer = await crypto.subtle.digest('SHA-256', e.target.result);
                                    const hashArray = Array.from(new Uint8Array(hashBuffer));
                                    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
                                    hashInput.value = hashHex;
                                    this.sha256Status = 'SHA-256 auto-computed';
                                } catch(err) {
                                    this.sha256Status = '';
                                }
                            };
                            reader.readAsArrayBuffer(file);
                        }
                    }
                }" class="space-y-1.5">
                    <label class="font-bold text-slate-700 uppercase tracking-wider flex items-center justify-between">
                        <span class="flex items-center space-x-1.5">
                            <i class="fa-solid fa-file-arrow-up text-emerald-600 text-[11px]"></i>
                            <span>Upload APK File (Drag &amp; Drop)</span>
                        </span>
                        <span class="text-[10px] text-emerald-700 font-mono font-bold">Auto-adds size</span>
                    </label>

                    <!-- Drag & Drop Zone -->
                    <div @dragover.prevent="isDragging = true"
                         @dragleave.prevent="isDragging = false"
                         @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files); $refs.fileInput.files = $event.dataTransfer.files"
                         @click="$refs.fileInput.click()"
                         :class="isDragging ? 'border-emerald-500 bg-emerald-50/60 ring-2 ring-emerald-300' : (fileName ? 'border-emerald-400 bg-emerald-50/30' : 'border-slate-300 hover:border-slate-400 bg-slate-50/60 hover:bg-slate-50')"
                         class="border-2 border-dashed rounded-[10px] p-4 text-center cursor-pointer transition flex flex-col items-center justify-center space-y-2 relative group">
                        
                        <input type="file" 
                               name="apk_file" 
                               id="apk_file" 
                               x-ref="fileInput" 
                               accept=".apk"
                               @change="handleFiles($event.target.files)"
                               class="hidden">

                        <template x-if="!fileName">
                            <div class="space-y-1 text-center py-1">
                                <div class="w-10 h-10 mx-auto rounded-[8px] bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg group-hover:scale-105 transition-transform shadow-xs">
                                    <i class="fa-brands fa-android text-emerald-600"></i>
                                </div>
                                <div class="text-xs font-bold text-slate-800">
                                    Drag &amp; Drop your <span class="text-emerald-700 font-mono">.apk</span> file here
                                </div>
                                <div class="text-[11px] text-slate-500">
                                    or <span class="text-blue-600 underline font-semibold">browse computer</span>
                                </div>
                                <p class="text-[10px] text-slate-400 font-mono pt-0.5">
                                    Auto-calculates file size and checksum
                                </p>
                            </div>
                        </template>

                        <template x-if="fileName">
                            <div class="w-full flex items-center justify-between p-2.5 rounded-[8px] bg-white border border-emerald-200 text-left shadow-xs">
                                <div class="flex items-center space-x-2.5 min-w-0">
                                    <div class="w-8 h-8 rounded-[6px] bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm flex-shrink-0">
                                        <i class="fa-brands fa-android"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-slate-900 truncate font-mono" x-text="fileName"></div>
                                        <div class="text-[10px] text-emerald-700 font-semibold flex items-center space-x-1.5">
                                            <span class="bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded font-mono" x-text="fileSizeFormatted"></span>
                                            <span class="text-slate-300">•</span>
                                            <span class="text-emerald-600 font-normal" x-text="sha256Status || 'Ready to upload'"></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" 
                                        @click.stop="fileName = ''; fileSizeFormatted = ''; $refs.fileInput.value = ''"
                                        class="text-slate-400 hover:text-red-500 p-1.5 rounded transition" 
                                        title="Remove file">
                                    <i class="fa-solid fa-xmark text-sm"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="version" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-tag text-slate-400 text-[11px]"></i>
                        <span>Version Tag</span>
                    </label>
                    <input type="text" id="version" name="version" required placeholder="v1.0.6" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="space-y-1">
                    <label for="version_code" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-hashtag text-slate-400 text-[11px]"></i>
                        <span>Version Code (Build Number)</span>
                    </label>
                    <input type="number" id="version_code" name="version_code" required placeholder="12" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label for="release_date" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-calendar-days text-slate-400 text-[11px]"></i>
                            <span>Release Date</span>
                        </label>
                        <input type="text" id="release_date" name="release_date" required placeholder="October 2026" class="w-full p-2.5 rounded-[8px] border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="space-y-1">
                        <label for="apk_size" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-file-zipper text-slate-400 text-[11px]"></i>
                            <span>APK File Size (Auto-Added)</span>
                        </label>
                        <input type="text" id="apk_size" name="apk_size" placeholder="Auto-calculated from APK" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500 bg-slate-50">
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="sha256_hash" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-shield-halved text-slate-400 text-[11px]"></i>
                        <span>SHA-256 Checksum</span>
                    </label>
                    <input type="text" id="sha256_hash" name="sha256_hash" required placeholder="e.g. 9b8c73e4..." class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="space-y-1">
                    <label for="download_url" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-cloud-arrow-down text-slate-400 text-[11px]"></i>
                        <span>Download Path / CDN URL</span>
                    </label>
                    <input type="text" id="download_url" name="download_url" required value="/download/apk" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="space-y-1">
                    <label for="changelog" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                        <i class="fa-solid fa-file-lines text-slate-400 text-[11px]"></i>
                        <span>Changelog / Release Notes</span>
                    </label>
                    <textarea id="changelog" name="changelog" rows="4" required placeholder="• Fixed daemon connection timeout&#10;• Added dark mode terminal palette" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex items-center space-x-2 pt-1">
                    <input type="checkbox" id="is_latest" name="is_latest" value="1" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <label for="is_latest" class="font-bold text-slate-700 flex items-center space-x-1">
                        <i class="fa-solid fa-crown text-amber-500 text-xs"></i>
                        <span>Set as Featured Latest Release</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-[8px] shadow-sm shadow-emerald-500/20 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-circle-arrow-up"></i>
                        <span>Publish Release Build</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Right: Current Releases Table (Max 10px Radius) -->
        <div class="lg:col-span-7 bg-white border border-slate-200 rounded-[10px] p-5 sm:p-6 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                    <i class="fa-solid fa-clock-rotate-left text-blue-600"></i>
                    <span>Release History Archive</span>
                </h3>
                <p class="text-xs text-slate-500">All registered builds accessible to the public download hub.</p>
            </div>

            <div class="overflow-x-auto -mx-5 sm:mx-0">
                <table class="w-full text-left text-xs min-w-[580px]">
                    <thead class="bg-slate-50 border-y border-slate-200 text-slate-600 uppercase font-bold">
                        <tr>
                            <th class="px-3.5 py-3">Version</th>
                            <th class="px-3.5 py-3">Date</th>
                            <th class="px-3.5 py-3">Size</th>
                            <th class="px-3.5 py-3">Downloads</th>
                            <th class="px-3.5 py-3">Status</th>
                            <th class="px-3.5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        @foreach($releases as $rel)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-3.5 py-3 font-bold text-slate-900">
                                    <div class="flex items-center space-x-1.5">
                                        <i class="fa-brands fa-android text-emerald-600 text-sm"></i>
                                        <span class="font-mono">{{ $rel->version }}</span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-mono pl-5">Build #{{ $rel->version_code }}</div>
                                </td>
                                <td class="px-3.5 py-3 font-sans">{{ $rel->release_date }}</td>
                                <td class="px-3.5 py-3 font-mono">{{ $rel->apk_size }}</td>
                                <td class="px-3.5 py-3 font-sans">
                                    <span class="inline-flex items-center space-x-1 font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded-[6px]">
                                        <i class="fa-solid fa-cloud-arrow-down text-[10px] text-blue-600"></i>
                                        <span>{{ number_format($rel->downloads_count) }}</span>
                                    </span>
                                </td>
                                <td class="px-3.5 py-3">
                                    @if($rel->is_latest)
                                        <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-[6px] bg-emerald-100 text-emerald-800 font-sans font-bold text-[10px]">
                                            <i class="fa-solid fa-crown text-amber-500 text-[9px]"></i>
                                            <span>Latest</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] bg-slate-100 text-slate-600 font-sans font-medium text-[10px]">
                                            Archived
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3.5 py-3 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ $rel->download_url }}" 
                                           title="Download APK"
                                           class="p-1.5 rounded-[6px] text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white transition">
                                            <i class="fa-solid fa-download text-xs"></i>
                                        </a>

                                        <div x-data="{ confirming: false }" class="inline-block">
                                            <button type="button" 
                                                    x-show="!confirming" 
                                                    @click="confirming = true"
                                                    title="Delete release {{ $rel->version }}"
                                                    class="p-1.5 rounded-[6px] text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition cursor-pointer">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>

                                            <div x-show="confirming" x-cloak class="flex items-center space-x-1">
                                                <form action="{{ route('admin.releases.destroy', $rel, false) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="px-2 py-1 rounded-[6px] bg-red-600 hover:bg-red-700 text-white font-bold text-[10px] transition cursor-pointer">
                                                        Confirm
                                                    </button>
                                                </form>
                                                <button type="button" 
                                                        @click="confirming = false" 
                                                        class="p-1 rounded-[6px] bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition cursor-pointer" 
                                                        title="Cancel">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-admin.layout>
