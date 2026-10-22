<x-admin.layout title="Releases Management — PocketSQL Admin">

    <!-- Clean Script Defined Component (Zero HTML attribute escaping issues) -->
    <script>
    function releaseManager() {
        return {
            releases: {!! $releases->toJson() !!},
            
            form: {
                version: '',
                version_code: {{ ($releases->max('version_code') ?? 0) + 1 }},
                apk_size: '',
                sha256_hash: '',
                download_url: '/download/apk',
                changelog: '',
                is_latest: true
            },
            
            selectedFile: null,
            fileName: '',
            fileSizeFormatted: '',
            sha256Status: '',
            isDragging: false,

            isUploading: false,
            uploadPercent: 0,
            uploadMbLoaded: '0',
            uploadMbTotal: '0',
            uploadStatusText: '',
            successMessage: {!! json_encode(session('success') ?? '') !!},
            errorMessage: '',

            handleFiles(files) {
                if (!files || files.length === 0) return;
                const file = files[0];
                if (!file.name.toLowerCase().endsWith('.apk')) {
                    alert('Please upload a valid .apk package.');
                    return;
                }
                this.selectedFile = file;
                this.fileName = file.name;
                
                const mb = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                this.fileSizeFormatted = mb;
                this.form.apk_size = mb;

                const match = file.name.match(/v?(\d+\.\d+\.\d+)/i);
                if (match && !this.form.version) {
                    this.form.version = match[0].startsWith('v') ? match[0] : 'v' + match[0];
                }

                if (window.crypto && window.crypto.subtle) {
                    this.sha256Status = 'Calculating SHA-256...';
                    const reader = new FileReader();
                    reader.onload = async (e) => {
                        try {
                            const hashBuffer = await crypto.subtle.digest('SHA-256', e.target.result);
                            const hashArray = Array.from(new Uint8Array(hashBuffer));
                            const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
                            this.form.sha256_hash = hashHex;
                            this.sha256Status = 'SHA-256 auto-computed';
                        } catch(err) {
                            this.sha256Status = '';
                        }
                    };
                    reader.readAsArrayBuffer(file);
                }
            },

            removeFile() {
                this.selectedFile = null;
                this.fileName = '';
                this.fileSizeFormatted = '';
                this.sha256Status = '';
                this.form.apk_size = '';
                this.form.sha256_hash = '';
                const input = document.getElementById('apk_file');
                if (input) input.value = '';
            },

            resetForm() {
                this.removeFile();
                this.form.version = '';
                const maxCode = this.releases.length > 0 ? Math.max(...this.releases.map(r => r.version_code || 0)) : 0;
                this.form.version_code = maxCode + 1;
                this.form.download_url = '/download/apk';
                this.form.changelog = '';
                this.form.is_latest = true;
                this.uploadPercent = 0;
                this.uploadMbLoaded = '0';
                this.uploadMbTotal = '0';
                this.uploadStatusText = '';
            },

            uploadRelease() {
                if (!this.form.version || !this.form.version_code || !this.form.changelog) {
                    this.errorMessage = 'Please provide version tag, build number, and changelog notes.';
                    return;
                }

                this.errorMessage = '';
                this.successMessage = '';
                this.isUploading = true;
                this.uploadPercent = 0;
                this.uploadStatusText = 'Initiating APK upload...';

                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

                const formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('version', this.form.version);
                formData.append('version_code', this.form.version_code);
                if (this.selectedFile) {
                    formData.append('apk_file', this.selectedFile);
                }
                if (this.form.apk_size) {
                    formData.append('apk_size', this.form.apk_size);
                }
                if (this.form.sha256_hash) {
                    formData.append('sha256_hash', this.form.sha256_hash);
                }
                formData.append('download_url', this.form.download_url || '/download/apk');
                formData.append('changelog', this.form.changelog);
                if (this.form.is_latest) {
                    formData.append('is_latest', '1');
                }

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.releases.store') }}');
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.upload.onprogress = (e) => {
                    if (e.lengthComputable) {
                        const pct = Math.round((e.loaded / e.total) * 100);
                        this.uploadPercent = pct;
                        this.uploadMbLoaded = (e.loaded / (1024 * 1024)).toFixed(1);
                        this.uploadMbTotal = (e.total / (1024 * 1024)).toFixed(1);

                        if (pct < 100) {
                            this.uploadStatusText = 'Uploading APK: ' + this.uploadMbLoaded + ' MB of ' + this.uploadMbTotal + ' MB (' + pct + '%)';
                        } else {
                            this.uploadStatusText = '100% Uploaded! Server is verifying checksum and finalizing...';
                        }
                    }
                };

                xhr.onload = () => {
                    this.isUploading = false;
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            const res = JSON.parse(xhr.responseText);
                            if (res.release) {
                                if (res.release.is_latest) {
                                    this.releases.forEach(r => r.is_latest = false);
                                }
                                res.release.justAdded = true;
                                this.releases.unshift(res.release);
                                setTimeout(() => {
                                    const found = this.releases.find(r => r.id === res.release.id);
                                    if (found) found.justAdded = false;
                                }, 3500);
                            }
                            this.successMessage = res.message || 'New release and APK package published successfully.';
                            this.resetForm();
                        } catch(err) {
                            this.successMessage = 'Release build published successfully.';
                            this.resetForm();
                        }
                    } else {
                        try {
                            const err = JSON.parse(xhr.responseText);
                            let msg = err.message || 'Failed to publish release. Please review form fields.';
                            if (err.errors) {
                                const firstKey = Object.keys(err.errors)[0];
                                if (firstKey && err.errors[firstKey][0]) {
                                    msg = err.errors[firstKey][0];
                                }
                            }
                            this.errorMessage = msg;
                        } catch(e) {
                            this.errorMessage = 'Server error during upload (HTTP ' + xhr.status + ').';
                        }
                    }
                };

                xhr.onerror = () => {
                    this.isUploading = false;
                    this.errorMessage = 'Network connection interrupted during upload. Please try again.';
                };

                xhr.send(formData);
            },

            async deleteRelease(rel) {
                if (!confirm('Are you sure you want to delete release build (' + rel.version + ')?')) {
                    return;
                }
                try {
                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

                    const res = await fetch('/admin/releases/' + rel.id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await res.json();
                    if (res.ok && data.success) {
                        this.releases = this.releases.filter(r => r.id !== rel.id);
                        if (data.next_latest_id) {
                            const next = this.releases.find(r => r.id === data.next_latest_id);
                            if (next) next.is_latest = true;
                        }
                        this.successMessage = data.message;
                        this.errorMessage = '';
                    } else {
                        alert(data.message || 'Could not delete release.');
                    }
                } catch(e) {
                    alert('Network connection error while deleting release.');
                }
            }
        };
    }
    </script>

    <div x-data="releaseManager()" class="space-y-6">

        <!-- Header -->
        <div class="border-b border-slate-200 pb-5">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2.5">
                <i class="fa-solid fa-code-branch text-emerald-600"></i>
                <span>Android Releases Management</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Publish new APK releases with real-time upload progress tracking. No full page reloads.</p>
        </div>

        <!-- Dynamic Success Alert (Zero Reload) -->
        <div x-show="successMessage" 
             x-cloak 
             x-transition
             class="p-3.5 rounded-[10px] bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-xs">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                <span class="font-bold" x-text="successMessage"></span>
            </div>
            <button type="button" @click="successMessage = ''" class="text-emerald-500 hover:text-emerald-700 p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Dynamic Error Alert (Zero Reload) -->
        <div x-show="errorMessage" 
             x-cloak 
             x-transition
             class="p-3.5 rounded-[10px] bg-red-50 border border-red-200 text-red-700 text-xs flex items-center justify-between shadow-xs">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-triangle-exclamation text-red-600 text-sm"></i>
                <span class="font-bold" x-text="errorMessage"></span>
            </div>
            <button type="button" @click="errorMessage = ''" class="text-red-400 hover:text-red-600 p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
            
            <!-- Left: Create New Release Form (AJAX Upload with Real-Time Progress) -->
            <div class="lg:col-span-5 bg-white border border-slate-200 rounded-[10px] p-5 sm:p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                            <i class="fa-solid fa-circle-plus text-emerald-600"></i>
                            <span>Publish New Release</span>
                        </h3>
                        <p class="text-xs text-slate-500">Upload an APK build with live progress tracking.</p>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-[6px] bg-emerald-50 text-emerald-700 border border-emerald-200 font-mono">
                        Instant AJAX
                    </span>
                </div>

                <form @submit.prevent="uploadRelease()" class="space-y-4 text-xs">
                    
                    <!-- Drag & Drop APK File Upload with Automatic Size Detection -->
                    <div class="space-y-1.5">
                        <label class="font-bold text-slate-700 uppercase tracking-wider flex items-center justify-between">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-file-arrow-up text-emerald-600 text-[11px]"></i>
                                <span>Upload APK File (Drag &amp; Drop)</span>
                            </span>
                            <span class="text-[10px] text-emerald-700 font-mono font-bold">Auto-adds size &amp; checksum</span>
                        </label>

                        <!-- Drag & Drop Zone -->
                        <div @dragover.prevent="if(!isUploading) isDragging = true"
                             @dragleave.prevent="isDragging = false"
                             @drop.prevent="isDragging = false; if(!isUploading) { handleFiles($event.dataTransfer.files); }"
                             @click="if(!isUploading) $refs.fileInput.click()"
                             :class="isDragging ? 'border-emerald-500 bg-emerald-50/60 ring-2 ring-emerald-300' : (fileName ? 'border-emerald-400 bg-emerald-50/30' : 'border-slate-300 hover:border-slate-400 bg-slate-50/60 hover:bg-slate-50')"
                             class="border-2 border-dashed rounded-[10px] p-4 text-center cursor-pointer transition flex flex-col items-center justify-center space-y-2 relative group">
                            
                            <input type="file" 
                                   id="apk_file" 
                                   x-ref="fileInput" 
                                   accept=".apk"
                                   :disabled="isUploading"
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
                                        Max size: 100MB • Auto-calculates size &amp; SHA-256
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
                                            x-show="!isUploading"
                                            @click.stop="removeFile()"
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
                            <span>Version Tag <span class="text-red-500">*</span></span>
                        </label>
                        <input type="text" id="version" x-model="form.version" required :disabled="isUploading" placeholder="v1.0.6" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label for="version_code" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-hashtag text-slate-400 text-[11px]"></i>
                            <span>Version Code (Build Number) <span class="text-red-500">*</span></span>
                        </label>
                        <input type="number" id="version_code" x-model="form.version_code" required :disabled="isUploading" placeholder="12" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label for="apk_size" class="font-bold text-slate-700 uppercase tracking-wider flex items-center justify-between">
                                <span class="flex items-center space-x-1.5">
                                    <i class="fa-solid fa-file-zipper text-slate-400 text-[11px]"></i>
                                    <span>APK File Size</span>
                                </span>
                            </label>
                            <input type="text" id="apk_size" x-model="form.apk_size" :disabled="isUploading" placeholder="Auto-detected on upload" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500 bg-slate-50">
                        </div>
                        <div class="space-y-1">
                            <label for="sha256_hash" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                                <i class="fa-solid fa-shield-halved text-slate-400 text-[11px]"></i>
                                <span>SHA-256 Checksum</span>
                            </label>
                            <input type="text" id="sha256_hash" x-model="form.sha256_hash" :disabled="isUploading" placeholder="Auto-calculated if APK uploaded" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="download_url" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-cloud-arrow-down text-slate-400 text-[11px]"></i>
                            <span>Download Path / CDN URL</span>
                        </label>
                        <input type="text" id="download_url" x-model="form.download_url" required :disabled="isUploading" value="/download/apk" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label for="changelog" class="font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-file-lines text-slate-400 text-[11px]"></i>
                            <span>Changelog / Release Notes <span class="text-red-500">*</span></span>
                        </label>
                        <textarea id="changelog" x-model="form.changelog" rows="3" required :disabled="isUploading" placeholder="• Fixed connection timeout&#10;• Added fast storage indexing" class="w-full p-2.5 rounded-[8px] border-slate-300 font-mono text-xs focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="flex items-center space-x-2 pt-1">
                        <input type="checkbox" id="is_latest" x-model="form.is_latest" :disabled="isUploading" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <label for="is_latest" class="font-bold text-slate-700 flex items-center space-x-1 cursor-pointer">
                            <i class="fa-solid fa-crown text-amber-500 text-xs"></i>
                            <span>Set as Featured Latest Release</span>
                        </label>
                    </div>

                    <!-- ============================================== -->
                    <!-- LIVE REAL-TIME UPLOAD PROGRESS PROCESSING CARD -->
                    <!-- ============================================== -->
                    <div x-show="isUploading" 
                         x-cloak 
                         x-transition
                         class="p-4 rounded-[10px] bg-slate-900 text-white space-y-2.5 shadow-lg border border-slate-800">
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                                <span class="font-bold text-xs tracking-wide text-slate-100 flex items-center">
                                    <i class="fa-solid fa-cloud-arrow-up text-emerald-400 mr-1.5"></i>
                                    Uploading APK Package...
                                </span>
                            </div>
                            <span class="font-mono text-sm font-extrabold text-emerald-400" x-text="uploadPercent + '%'"></span>
                        </div>

                        <!-- Smooth Animated Gradient Progress Bar -->
                        <div class="w-full h-3 bg-slate-800 rounded-full overflow-hidden p-0.5 border border-slate-700">
                            <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 via-teal-400 to-emerald-400 transition-all duration-150 relative overflow-hidden"
                                 :style="'width: ' + uploadPercent + '%'">
                                <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                            </div>
                        </div>

                        <!-- Progress Stats Detail -->
                        <div class="flex items-center justify-between text-[11px] text-slate-400 font-mono pt-0.5">
                            <span class="text-slate-300 font-medium truncate max-w-[240px]" x-text="uploadStatusText"></span>
                            <span class="text-emerald-300 font-bold flex-shrink-0" x-text="uploadMbLoaded + ' / ' + uploadMbTotal + ' MB'"></span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-1">
                        <button type="submit" 
                                :disabled="isUploading"
                                :class="isUploading ? 'opacity-70 cursor-not-allowed bg-emerald-700' : 'bg-emerald-600 hover:bg-emerald-700'"
                                class="w-full py-2.5 text-white font-bold rounded-[8px] shadow-sm shadow-emerald-500/20 transition flex items-center justify-center space-x-2 cursor-pointer">
                            <template x-if="!isUploading">
                                <span class="flex items-center space-x-2">
                                    <i class="fa-solid fa-circle-arrow-up"></i>
                                    <span>Publish Release Build</span>
                                </span>
                            </template>
                            <template x-if="isUploading">
                                <span class="flex items-center space-x-2">
                                    <i class="fa-solid fa-circle-notch fa-spin text-sm"></i>
                                    <span x-text="'Processing Upload (' + uploadPercent + '%)...'"></span>
                                </span>
                            </template>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Current Releases Table (Dynamically Updated Without Page Reload) -->
            <div class="lg:col-span-7 bg-white border border-slate-200 rounded-[10px] p-5 sm:p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 flex items-center space-x-2">
                            <i class="fa-solid fa-clock-rotate-left text-blue-600"></i>
                            <span>Release History Archive</span>
                        </h3>
                        <p class="text-xs text-slate-500">All registered builds accessible to the public download hub.</p>
                    </div>
                    <span class="text-xs font-mono font-bold text-slate-400" x-text="'(' + releases.length + ' builds)'"></span>
                </div>

                <div class="overflow-x-auto -mx-5 sm:mx-0">
                    <table class="w-full text-left text-xs min-w-[580px]">
                        <thead class="bg-slate-50 border-y border-slate-200 text-slate-600 uppercase font-bold text-[10px]">
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
                            <template x-for="rel in releases" :key="rel.id">
                                <tr :class="rel.justAdded ? 'bg-emerald-50/80 ring-2 ring-emerald-300' : 'hover:bg-slate-50/70'" class="transition">
                                    <td class="px-3.5 py-3 font-bold text-slate-900">
                                        <div class="flex items-center space-x-1.5">
                                            <i class="fa-brands fa-android text-emerald-600 text-sm"></i>
                                            <span class="font-mono" x-text="rel.version"></span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-mono pl-5" x-text="'Build #' + rel.version_code"></div>
                                    </td>
                                    <td class="px-3.5 py-3 font-sans" x-text="rel.release_date"></td>
                                    <td class="px-3.5 py-3 font-mono" x-text="rel.apk_size"></td>
                                    <td class="px-3.5 py-3 font-sans">
                                        <span class="inline-flex items-center space-x-1 font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded-[6px]">
                                            <i class="fa-solid fa-cloud-arrow-down text-[10px] text-blue-600"></i>
                                            <span x-text="Number(rel.downloads_count || 0).toLocaleString()"></span>
                                        </span>
                                    </td>
                                    <td class="px-3.5 py-3">
                                        <template x-if="rel.is_latest">
                                            <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-[6px] bg-emerald-100 text-emerald-800 font-sans font-bold text-[10px]">
                                                <i class="fa-solid fa-crown text-amber-500 text-[9px]"></i>
                                                <span>Latest</span>
                                            </span>
                                        </template>
                                        <template x-if="!rel.is_latest">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] bg-slate-100 text-slate-600 font-sans font-medium text-[10px]">
                                                Archived
                                            </span>
                                        </template>
                                    </td>
                                    <td class="px-3.5 py-3 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a :href="rel.download_url" 
                                               target="_blank"
                                               title="Download APK"
                                               class="p-1.5 rounded-[6px] text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white transition">
                                                <i class="fa-solid fa-download text-xs"></i>
                                            </a>

                                            <button type="button" 
                                                    @click="deleteRelease(rel)"
                                                    title="Delete release"
                                                    class="p-1.5 rounded-[6px] text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition cursor-pointer">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            <template x-if="releases.length === 0">
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-slate-400">
                                        <i class="fa-brands fa-android text-2xl mb-1 block"></i>
                                        <span>No releases found. Upload an APK above to create your first release.</span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</x-admin.layout>
