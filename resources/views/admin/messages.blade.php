<x-admin.layout title="Contact Inquiries — PocketSQL Admin">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2.5">
                <i class="fa-solid fa-envelope-open-text text-amber-600"></i>
                <span>Contact Messages &amp; Inquiries</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Review bug reports, feature requests, and community support inquiries submitted through the website.</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center gap-1.5 bg-white p-1 rounded-[10px] border border-slate-200 text-xs shadow-xs">
            <a href="{{ route('admin.messages.index') }}" 
               class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-[8px] font-semibold transition {{ empty($status) ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <i class="fa-solid fa-border-all text-[11px]"></i>
                <span>All</span>
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" 
               class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-[8px] font-semibold transition {{ $status === 'unread' ? 'bg-amber-500 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <i class="fa-solid fa-envelope text-[11px]"></i>
                <span>Unread ({{ $unreadCount }})</span>
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'replied']) }}" 
               class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-[8px] font-semibold transition {{ $status === 'replied' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <i class="fa-solid fa-reply text-[11px]"></i>
                <span>Replied</span>
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'archived']) }}" 
               class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-[8px] font-semibold transition {{ $status === 'archived' ? 'bg-slate-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <i class="fa-solid fa-box-archive text-[11px]"></i>
                <span>Archived</span>
            </a>
        </div>
    </div>

    <!-- Messages List Card -->
    <div class="bg-white border border-slate-200 rounded-[10px] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs min-w-[700px]">
                <thead class="bg-slate-50 text-slate-600 uppercase font-bold border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-user text-slate-400 text-[10px]"></i>
                                <span>Sender</span>
                            </span>
                        </th>
                        <th class="px-5 py-3.5">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-tag text-slate-400 text-[10px]"></i>
                                <span>Category</span>
                            </span>
                        </th>
                        <th class="px-5 py-3.5">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-heading text-slate-400 text-[10px]"></i>
                                <span>Subject</span>
                            </span>
                        </th>
                        <th class="px-5 py-3.5">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-globe text-slate-400 text-[10px]"></i>
                                <span>Client IP</span>
                            </span>
                        </th>
                        <th class="px-5 py-3.5">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-clock text-slate-400 text-[10px]"></i>
                                <span>Received</span>
                            </span>
                        </th>
                        <th class="px-5 py-3.5">
                            <span class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-shield-halved text-slate-400 text-[10px]"></i>
                                <span>Status</span>
                            </span>
                        </th>
                        <th class="px-5 py-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/70 transition {{ $msg->status === 'unread' ? 'bg-amber-50/20 font-medium' : '' }}">
                            <td class="px-5 py-3.5 text-slate-900 font-semibold">
                                <div class="flex items-center space-x-2">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-[11px] flex-shrink-0">
                                        {{ strtoupper(substr($msg->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div>{{ $msg->name }}</div>
                                        <div class="text-[11px] text-slate-400 font-normal font-mono">{{ $msg->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded-[6px] bg-slate-100 text-slate-700 font-mono text-[11px]">
                                    {{ $msg->inquiry_type }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 truncate max-w-xs font-medium">{{ $msg->subject }}</td>
                            <td class="px-5 py-3.5 font-mono text-[11px] text-slate-400">{{ $msg->ip_address ?? '127.0.0.1' }}</td>
                            <td class="px-5 py-3.5 font-mono text-[11px] text-slate-400">{{ $msg->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-5 py-3.5">
                                @if($msg->status === 'unread')
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-[6px] bg-amber-100 text-amber-800 font-bold text-[10px]">
                                        <i class="fa-solid fa-envelope text-[9px]"></i>
                                        <span>Unread</span>
                                    </span>
                                @elseif($msg->status === 'replied')
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-[6px] bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                        <i class="fa-solid fa-reply text-[9px]"></i>
                                        <span>Replied</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-[6px] bg-slate-100 text-slate-600 font-semibold text-[10px] capitalize">
                                        <i class="fa-solid fa-check text-[9px]"></i>
                                        <span>{{ $msg->status }}</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <a href="{{ route('admin.messages.show', $msg, false) }}" 
                                       class="inline-flex items-center px-2.5 py-1.5 rounded-[6px] bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white font-bold text-xs transition">
                                        <i class="fa-solid fa-envelope-open mr-1 text-[10px]"></i>
                                        <span>View</span>
                                    </a>
                                    <div x-data="{ confirming: false }" class="inline-block">
                                        <button type="button" 
                                                x-show="!confirming" 
                                                @click="confirming = true"
                                                title="Delete inquiry"
                                                class="inline-flex items-center p-1.5 rounded-[6px] text-red-600 bg-red-50 hover:bg-red-600 hover:text-white text-xs transition cursor-pointer">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>

                                        <div x-show="confirming" x-cloak class="flex items-center space-x-1">
                                            <form action="{{ route('admin.messages.destroy', $msg, false) }}" method="POST" class="inline">
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
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400 space-y-2">
                                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-lg">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <div class="font-medium text-slate-600">No contact messages in this category.</div>
                                <div class="text-xs">Incoming user feedback and support queries will appear here.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin.layout>
