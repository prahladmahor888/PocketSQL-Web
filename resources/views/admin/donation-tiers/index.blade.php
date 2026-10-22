<x-admin.layout title="Donation Amount Cards — PocketSQL Admin">

    <div x-data="{
        addModalOpen: false,
        editModalOpen: false,
        activeTier: {
            id: null,
            amount: 500,
            name: '',
            badge: '',
            impact_heading: '',
            impact_text: '',
            sort_order: 1,
            is_popular: false,
            is_active: true
        },
        openEdit(tier) {
            this.activeTier = JSON.parse(JSON.stringify(tier));
            this.editModalOpen = true;
        }
    }" class="space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2.5">
                    <span class="w-9 h-9 rounded-[10px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm shadow-xs border border-emerald-200">
                        <i class="fa-solid fa-layer-group"></i>
                    </span>
                    <span>Donation Amount Cards &amp; Presets</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">Configure preset amount buttons shown on the public donation portal. Add new cards, edit amounts, badges, or delete tiers dynamically.</p>
            </div>

            <div class="flex items-center space-x-2">
                <a href="{{ route('donate') }}" target="_blank" class="px-3.5 py-2 rounded-[8px] bg-white border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-xs transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-slate-400"></i>
                    <span>Preview /donate</span>
                </a>
                <button type="button" 
                        @click="addModalOpen = true"
                        class="px-4 py-2 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs shadow-blue-500/20 transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Add New Card</span>
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
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Total Cards</span>
                <span class="text-xl font-extrabold text-slate-900 font-mono">{{ $tiers->count() }}</span>
            </div>
            <div class="p-3.5 bg-white rounded-[10px] border border-slate-200 shadow-xs">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Active Online</span>
                <span class="text-xl font-extrabold text-emerald-600 font-mono">{{ $tiers->where('is_active', true)->count() }}</span>
            </div>
            <div class="p-3.5 bg-white rounded-[10px] border border-slate-200 shadow-xs">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Popular Highlight</span>
                @php $popular = $tiers->firstWhere('is_popular', true); @endphp
                <span class="text-xs font-bold text-blue-600 truncate block mt-1">
                    {{ $popular ? '₹' . number_format($popular->amount) . ' (' . $popular->name . ')' : 'None Set' }}
                </span>
            </div>
            <div class="p-3.5 bg-white rounded-[10px] border border-slate-200 shadow-xs">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Preset Range</span>
                <span class="text-xs font-bold text-slate-700 font-mono block mt-1">
                    @if($tiers->isNotEmpty())
                        ₹{{ number_format($tiers->min('amount')) }} — ₹{{ number_format($tiers->max('amount')) }}
                    @else
                        N/A
                    @endif
                </span>
            </div>
        </div>

        <!-- Tiers Cards & Table Container -->
        <div class="bg-white border border-slate-200 rounded-[10px] shadow-xs overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-bold text-slate-900">Current Preset Cards</span>
                    <span class="text-[11px] text-slate-400 font-mono">({{ $tiers->count() }} cards)</span>
                </div>
                <span class="text-[11px] text-slate-400">Order by sort priority</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4">Live Card Preview</th>
                            <th class="py-3 px-4">Tier Name</th>
                            <th class="py-3 px-4">Amount</th>
                            <th class="py-3 px-4">Badge / Highlight</th>
                            <th class="py-3 px-4">Impact Description</th>
                            <th class="py-3 px-3 text-center">Order</th>
                            <th class="py-3 px-3 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tiers as $tier)
                            <tr class="hover:bg-slate-50/80 transition">
                                <!-- Card Preview (Rendered exactly as on /donate) -->
                                <td class="py-3.5 px-4 w-40">
                                    <div class="w-28 py-2 px-2.5 rounded-[8px] border text-center transition flex flex-col items-center justify-center space-y-0.5 relative {{ $tier->is_popular ? 'bg-blue-50 border-blue-300 ring-2 ring-blue-500/20' : 'bg-slate-50 border-slate-200' }}">
                                        @if($tier->badge || $tier->is_popular)
                                            <span class="absolute -top-2 px-1.5 py-0.2 rounded-[4px] bg-blue-700 text-white text-[8px] font-bold uppercase tracking-wider">
                                                {{ $tier->badge ?: 'Popular' }}
                                            </span>
                                        @endif
                                        <span class="font-mono text-sm font-bold text-slate-900">₹{{ number_format($tier->amount) }}</span>
                                        <span class="text-[9px] text-slate-600 truncate max-w-full">{{ $tier->name }}</span>
                                    </div>
                                </td>

                                <!-- Tier Name -->
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    <span class="text-sm">{{ $tier->name }}</span>
                                    @if($tier->is_popular)
                                        <span class="inline-flex items-center ml-1.5 px-1.5 py-0.5 rounded-[4px] bg-blue-100 text-blue-800 text-[10px] font-bold">
                                            Default Selected
                                        </span>
                                    @endif
                                </td>

                                <!-- Amount -->
                                <td class="py-3.5 px-4">
                                    <span class="font-mono text-sm font-extrabold text-blue-600">₹{{ number_format($tier->amount) }}</span>
                                </td>

                                <!-- Badge -->
                                <td class="py-3.5 px-4">
                                    @if($tier->badge)
                                        <span class="px-2 py-0.5 rounded-[6px] bg-amber-50 text-amber-700 border border-amber-200 font-bold text-[10px]">
                                            {{ $tier->badge }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic text-[11px]">—</span>
                                    @endif
                                </td>

                                <!-- Impact Heading & Text -->
                                <td class="py-3.5 px-4 max-w-xs">
                                    @if($tier->impact_heading)
                                        <div class="font-bold text-slate-800 text-[11px] truncate">{{ $tier->impact_heading }}</div>
                                    @endif
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">
                                        {{ $tier->impact_text ?: 'Default community impact text.' }}
                                    </p>
                                </td>

                                <!-- Sort Order -->
                                <td class="py-3.5 px-3 text-center font-mono font-bold text-slate-600">
                                    {{ $tier->sort_order }}
                                </td>

                                <!-- Status -->
                                <td class="py-3.5 px-3 text-center">
                                    @if($tier->is_active)
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
                                                @click="openEdit({{ $tier->toJson() }})"
                                                class="px-2.5 py-1.5 rounded-[6px] bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-600 border border-slate-200 transition text-[11px] font-semibold flex items-center space-x-1">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Edit</span>
                                        </button>

                                        <form action="{{ route('admin.donation-tiers.destroy', $tier) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this preset donation card (₹{{ number_format($tier->amount) }})?');"
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
                                    <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                                    <span>No donation amount cards configured. Click "Add New Card" to create one.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- ADD MODAL                                      -->
        <!-- ============================================== -->
        <div x-show="addModalOpen" 
             x-cloak 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
            
            <div @click.away="addModalOpen = false" 
                 style="max-width: 500px; width: 100%;"
                 class="bg-white rounded-[10px] max-w-lg w-full p-6 shadow-xl border border-slate-200 space-y-4 relative">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-[8px] bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Add New Donation Card</h3>
                            <p class="text-[11px] text-slate-500">Creates a preset amount button on the /donate page.</p>
                        </div>
                    </div>
                    <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <form action="{{ route('admin.donation-tiers.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Amount (₹) <span class="text-red-500">*</span></label>
                            <input type="number" name="amount" required min="1" step="1" placeholder="e.g. 500"
                                   class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Tier Label / Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required placeholder="e.g. Backer, Supporter"
                                   class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Card Badge <span class="text-[10px] text-slate-400 font-normal">(Optional)</span></label>
                            <input type="text" name="badge" placeholder="e.g. Popular, Recommended"
                                   class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Sort Priority Order</label>
                            <input type="number" name="sort_order" value="{{ $tiers->count() + 1 }}" min="0"
                                   class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Impact Heading</label>
                        <input type="text" name="impact_heading" placeholder="e.g. Backer Sponsor Tier"
                               class="w-full px-3 py-2 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Impact Description Text</label>
                        <textarea name="impact_text" rows="2" placeholder="Explain how this specific contribution level helps the project..."
                                  class="w-full px-3 py-2 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="p-3 rounded-[8px] bg-slate-50 border border-slate-200 space-y-2">
                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs">
                            <input type="checkbox" name="is_popular" value="1" class="rounded text-blue-600 focus:ring-blue-500">
                            <span class="font-bold text-slate-800">Set as Popular / Default Selection</span>
                        </label>
                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded text-blue-600 focus:ring-blue-500">
                            <span class="font-bold text-slate-800">Card is Active &amp; Visible on Website</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end space-x-2 pt-2 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false"
                                class="px-3.5 py-2 rounded-[8px] border border-slate-300 bg-white text-slate-700 font-bold text-xs hover:bg-slate-50">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs">
                            Create Card
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- EDIT MODAL                                     -->
        <!-- ============================================== -->
        <div x-show="editModalOpen" 
             x-cloak 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
            
            <div @click.away="editModalOpen = false" 
                 style="max-width: 500px; width: 100%;"
                 class="bg-white rounded-[10px] max-w-lg w-full p-6 shadow-xl border border-slate-200 space-y-4 relative">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-8 h-8 rounded-[8px] bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Edit Donation Card</h3>
                            <p class="text-[11px] text-slate-500">Update amount, badges, or tier copy.</p>
                        </div>
                    </div>
                    <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <form :action="'{{ url('/admin/donation-tiers') }}/' + activeTier.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Amount (₹) <span class="text-red-500">*</span></label>
                            <input type="number" name="amount" required min="1" step="1" x-model="activeTier.amount"
                                   class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Tier Label / Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required x-model="activeTier.name"
                                   class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Card Badge</label>
                            <input type="text" name="badge" x-model="activeTier.badge" placeholder="e.g. Popular"
                                   class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Sort Priority Order</label>
                            <input type="number" name="sort_order" x-model="activeTier.sort_order" min="0"
                                   class="w-full px-3.5 py-2.5 rounded-[8px] border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Impact Heading</label>
                        <input type="text" name="impact_heading" x-model="activeTier.impact_heading"
                               class="w-full px-3 py-2 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Impact Description Text</label>
                        <textarea name="impact_text" rows="2" x-model="activeTier.impact_text"
                                  class="w-full px-3 py-2 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="p-3 rounded-[8px] bg-slate-50 border border-slate-200 space-y-2">
                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs">
                            <input type="checkbox" name="is_popular" value="1" :checked="activeTier.is_popular" class="rounded text-blue-600 focus:ring-blue-500">
                            <span class="font-bold text-slate-800">Set as Popular / Default Selection</span>
                        </label>
                        <label class="flex items-center space-x-2.5 cursor-pointer text-xs">
                            <input type="checkbox" name="is_active" value="1" :checked="activeTier.is_active" class="rounded text-blue-600 focus:ring-blue-500">
                            <span class="font-bold text-slate-800">Card is Active &amp; Visible on Website</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end space-x-2 pt-2 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false"
                                class="px-3.5 py-2 rounded-[8px] border border-slate-300 bg-white text-slate-700 font-bold text-xs hover:bg-slate-50">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</x-admin.layout>
