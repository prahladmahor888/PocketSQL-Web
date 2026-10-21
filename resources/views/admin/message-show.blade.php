<x-admin.layout title="Inquiry #{{ $message->id }} — PocketSQL Admin">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.messages.index') }}" 
               class="inline-flex items-center px-3 py-1.5 rounded-[8px] text-xs font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 transition">
                <i class="fa-solid fa-arrow-left mr-1.5"></i>
                <span>Back to Inquiries</span>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2">
                    <span>Inquiry #{{ $message->id }}:</span>
                    <span class="text-slate-700 truncate max-w-md">{{ $message->subject }}</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5 flex items-center space-x-1.5">
                    <i class="fa-solid fa-clock text-[10px]"></i>
                    <span>Received on {{ $message->created_at->format('F d, Y \a\t H:i:s') }}</span>
                </p>
            </div>
        </div>

        <div x-data="{ confirming: false }" class="inline-block">
            <button type="button" 
                    x-show="!confirming" 
                    @click="confirming = true"
                    class="inline-flex items-center px-3 py-1.5 rounded-[8px] text-xs font-bold text-red-600 bg-red-50 border border-red-200 hover:bg-red-100 transition cursor-pointer">
                <i class="fa-solid fa-trash-can mr-1.5"></i>
                <span>Delete Message</span>
            </button>

            <div x-show="confirming" x-cloak class="flex items-center space-x-1.5">
                <form action="{{ route('admin.messages.destroy', $message, false) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 rounded-[8px] bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                        Confirm Delete
                    </button>
                </form>
                <button type="button" 
                        @click="confirming = false" 
                        class="px-2 py-1.5 rounded-[8px] bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs transition cursor-pointer" 
                        title="Cancel">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Message Details Card (Max 10px Radius) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Full Message Body -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-[10px] p-5 sm:p-7 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center space-x-1.5">
                    <i class="fa-solid fa-message text-blue-600 text-[11px]"></i>
                    <span>Message Body</span>
                </span>
                <div class="mt-4 p-5 rounded-[8px] bg-slate-50 border border-slate-200 text-sm font-sans text-slate-800 leading-relaxed whitespace-pre-wrap">
{{ $message->message }}
                </div>
            </div>

            <!-- Quick Email Reply Link -->
            <div class="flex items-center justify-between pt-1">
                <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-[8px] shadow-sm shadow-blue-500/20 transition">
                    <i class="fa-solid fa-paper-plane mr-2"></i>
                    <span>Compose Email Reply to {{ $message->email }}</span>
                </a>
            </div>
        </div>

        <!-- Right: Metadata & Status Update -->
        <div class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-[10px] p-5 sm:p-6 shadow-xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center space-x-1.5">
                    <i class="fa-solid fa-id-card text-slate-500 text-[11px]"></i>
                    <span>Sender Profile</span>
                </h3>
                
                <div class="space-y-3.5 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Sender Name:</span>
                        <div class="font-bold text-slate-900 text-sm flex items-center space-x-1.5">
                            <i class="fa-solid fa-user text-blue-600 text-xs"></i>
                            <span>{{ $message->name }}</span>
                        </div>
                    </div>

                    <div>
                        <span class="text-slate-400 block mb-0.5">Email Address:</span>
                        <a href="mailto:{{ $message->email }}" class="font-mono text-blue-600 hover:underline flex items-center space-x-1.5 font-semibold">
                            <i class="fa-solid fa-envelope text-slate-400 text-xs"></i>
                            <span>{{ $message->email }}</span>
                        </a>
                    </div>

                    <div>
                        <span class="text-slate-400 block mb-0.5">Inquiry Type:</span>
                        <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-[6px] bg-slate-100 text-slate-800 font-mono text-[11px] font-semibold">
                            <i class="fa-solid fa-tag text-slate-400 text-[10px]"></i>
                            <span>{{ $message->inquiry_type }}</span>
                        </span>
                    </div>

                    <div>
                        <span class="text-slate-400 block mb-0.5">Sender IP Address:</span>
                        <span class="font-mono text-slate-600 flex items-center space-x-1.5">
                            <i class="fa-solid fa-network-wired text-slate-400 text-xs"></i>
                            <span>{{ $message->ip_address ?? '127.0.0.1' }}</span>
                        </span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <form action="{{ route('admin.messages.status', $message) }}" method="POST" class="space-y-2">
                        @csrf
                        @method('PATCH')

                        <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center space-x-1.5">
                            <i class="fa-solid fa-arrows-rotate text-slate-400 text-[11px]"></i>
                            <span>Update Message Status</span>
                        </label>
                        <select name="status" id="status" class="w-full text-xs rounded-[8px] border-slate-300 p-2.5 bg-white focus:ring-2 focus:ring-blue-500">
                            <option value="unread" {{ $message->status === 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ $message->status === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ $message->status === 'replied' ? 'selected' : '' }}>Replied</option>
                            <option value="archived" {{ $message->status === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>

                        <button type="submit" class="w-full mt-2 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-[8px] shadow-sm transition flex items-center justify-center space-x-2">
                            <i class="fa-solid fa-check"></i>
                            <span>Update Status</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</x-admin.layout>
