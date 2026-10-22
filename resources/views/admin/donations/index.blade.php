<x-admin.layout title="Community Donations — PocketSQL Admin">

    <!-- Page Header & Statistics -->
    <div class="space-y-6">
        
        <!-- Top Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center space-x-2.5">
                    <span class="w-9 h-9 rounded-[10px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm shadow-xs border border-emerald-200">
                        <i class="fa-solid fa-heart"></i>
                    </span>
                    <span>Community Donations &amp; Sponsorships</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">Live tracking of Razorpay contributions across UPI, Debit/Credit Cards, and Netbanking.</p>
            </div>

            <div class="flex items-center space-x-2">
                <a href="{{ route('donate') }}" target="_blank" class="px-3.5 py-2 rounded-[8px] bg-white border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-xs transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-slate-400"></i>
                    <span>Public Donate Page</span>
                </a>
                <a href="{{ route('admin.donation-tiers.index') }}" class="px-3.5 py-2 rounded-[8px] bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs shadow-emerald-500/20 transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-layer-group text-[11px]"></i>
                    <span>Amount Cards &amp; Presets</span>
                </a>
                <a href="{{ route('admin.settings') }}#razorpay-config" class="px-3.5 py-2 rounded-[8px] bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs shadow-blue-500/20 transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-key text-[11px]"></i>
                    <span>Razorpay Keys</span>
                </a>
            </div>
        </div>

        @if(session('status'))
            <div class="p-3.5 rounded-[10px] bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <!-- 4 Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- 1. Total Raised -->
            <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Total Amount Raised</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">₹{{ number_format($totalCollected, 2) }}</span>
                    <span class="text-[11px] text-emerald-600 font-semibold flex items-center mt-0.5">
                        <i class="fa-solid fa-shield-halved mr-1 text-[10px]"></i> Verified via Razorpay
                    </span>
                </div>
                <div class="w-12 h-12 rounded-[10px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg border border-emerald-100 shadow-xs">
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                </div>
            </div>

            <!-- 2. Successful Donors -->
            <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Total Donors</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ number_format($successfulCount) }}</span>
                    <span class="text-[11px] text-slate-400 mt-0.5 block">Community supporters</span>
                </div>
                <div class="w-12 h-12 rounded-[10px] bg-blue-50 text-blue-600 flex items-center justify-center text-lg border border-blue-100 shadow-xs">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

            <!-- 3. Today's Collections -->
            <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Today's Collections</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">₹{{ number_format($todayCollected, 2) }}</span>
                    <span class="text-[11px] text-slate-400 mt-0.5 block">Received in past 24h</span>
                </div>
                <div class="w-12 h-12 rounded-[10px] bg-amber-50 text-amber-600 flex items-center justify-center text-lg border border-amber-100 shadow-xs">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
            </div>

            <!-- 4. Average Donation -->
            <div class="bg-white border border-slate-200 rounded-[10px] p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Average Contribution</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">₹{{ number_format($averageDonation, 0) }}</span>
                    <span class="text-[11px] text-slate-400 mt-0.5 block">Per supporter</span>
                </div>
                <div class="w-12 h-12 rounded-[10px] bg-purple-50 text-purple-600 flex items-center justify-center text-lg border border-purple-100 shadow-xs">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>

        </div>

        <!-- Filter & Search Controls -->
        <div class="bg-white border border-slate-200 rounded-[10px] p-4 shadow-xs">
            <form action="{{ route('admin.donations.index') }}" method="GET" class="flex flex-col md:flex-row items-center justify-between gap-3">
                
                <!-- Status Pills -->
                <div class="flex items-center space-x-1.5 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
                    <a href="{{ route('admin.donations.index', array_merge(request()->except('status', 'page'), [])) }}" 
                       class="px-3 py-1.5 rounded-[8px] text-xs font-bold transition {{ !request()->filled('status') ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        All ({{ \App\Models\Donation::count() }})
                    </a>
                    <a href="{{ route('admin.donations.index', array_merge(request()->except('page'), ['status' => 'successful'])) }}" 
                       class="px-3 py-1.5 rounded-[8px] text-xs font-bold transition {{ request('status') === 'successful' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                        <i class="fa-solid fa-circle-check text-[10px] mr-1"></i>
                        Successful ({{ $successfulCount }})
                    </a>
                    <a href="{{ route('admin.donations.index', array_merge(request()->except('page'), ['status' => 'pending'])) }}" 
                       class="px-3 py-1.5 rounded-[8px] text-xs font-bold transition {{ request('status') === 'pending' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                        <i class="fa-solid fa-clock text-[10px] mr-1"></i>
                        Pending ({{ $pendingCount }})
                    </a>
                    <a href="{{ route('admin.donations.index', array_merge(request()->except('page'), ['status' => 'failed'])) }}" 
                       class="px-3 py-1.5 rounded-[8px] text-xs font-bold transition {{ request('status') === 'failed' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                        <i class="fa-solid fa-circle-xmark text-[10px] mr-1"></i>
                        Failed
                    </a>
                </div>

                <!-- Search Input -->
                <div class="relative w-full md:w-72">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search donor, email, pay_id..." 
                           class="w-full pl-9 pr-3.5 py-2 rounded-[8px] border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                    @if(request()->filled('search'))
                        <a href="{{ route('admin.donations.index', request()->except('search', 'page')) }}" 
                           class="absolute right-2.5 top-2 text-slate-400 hover:text-slate-600 text-xs">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Detailed Donations Table -->
        <div class="bg-white border border-slate-200 rounded-[10px] shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4">Donor &amp; Contact</th>
                            <th class="py-3.5 px-4">Amount</th>
                            <th class="py-3.5 px-4">Method</th>
                            <th class="py-3.5 px-4">Razorpay Reference</th>
                            <th class="py-3.5 px-4">Date &amp; Time</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($donations as $donation)
                            <tr class="hover:bg-slate-50/80 transition">
                                
                                <!-- Donor Name & Email & Note -->
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-[8px] bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($donation->donor_name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="font-bold text-slate-900 block truncate">{{ $donation->donor_name }}</span>
                                            <span class="text-[11px] text-slate-500 font-mono block truncate">{{ $donation->donor_email }}</span>
                                            @if($donation->message)
                                                <div class="mt-1 text-[11px] text-slate-600 bg-slate-50 px-2 py-0.5 rounded-[6px] border border-slate-200 inline-block max-w-xs truncate" title="{{ $donation->message }}">
                                                    <i class="fa-solid fa-comment-dots text-slate-400 mr-1"></i>"{{ $donation->message }}"
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Amount (bold ₹) -->
                                <td class="py-3.5 px-4">
                                    <span class="font-mono text-sm font-extrabold {{ $donation->status === 'successful' ? 'text-emerald-600' : ($donation->status === 'failed' ? 'text-slate-400 line-through' : 'text-slate-800') }}">
                                        {{ $donation->formatted_amount }}
                                    </span>
                                </td>

                                <!-- Payment Method -->
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        <i class="{{ $donation->method_icon }} text-[10px] mr-1.5 text-slate-500"></i>
                                        <span>{{ $donation->payment_method ?: 'Razorpay Standard' }}</span>
                                    </span>
                                </td>

                                <!-- Razorpay Reference IDs -->
                                <td class="py-3.5 px-4">
                                    <div class="space-y-0.5 font-mono text-[11px]">
                                        @if($donation->razorpay_payment_id)
                                            <div class="flex items-center space-x-1 text-slate-800">
                                                <span class="text-[9px] uppercase font-bold text-slate-400">Pay:</span>
                                                <span class="font-semibold select-all">{{ $donation->razorpay_payment_id }}</span>
                                            </div>
                                        @endif
                                        @if($donation->razorpay_order_id)
                                            <div class="flex items-center space-x-1 text-slate-400 text-[10px]">
                                                <span class="text-[9px] uppercase font-bold">Ord:</span>
                                                <span class="select-all">{{ $donation->razorpay_order_id }}</span>
                                            </div>
                                        @endif
                                        @if(!$donation->razorpay_payment_id && !$donation->razorpay_order_id)
                                            <span class="text-slate-400 italic">No reference</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Date & Time (Kab donate kiya) -->
                                <td class="py-3.5 px-4 text-slate-600 whitespace-nowrap">
                                    <span class="font-medium block text-slate-900">{{ $donation->formatted_date }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $donation->created_at->diffForHumans() }}</span>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($donation->status === 'successful')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                            Successful
                                        </span>
                                    @elseif($donation->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-[11px] font-bold bg-red-50 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                            Failed
                                        </span>
                                    @endif
                                </td>

                                <!-- Action Buttons -->
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <form action="{{ route('admin.donations.destroy', $donation) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this donation record?');" 
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                title="Delete record" 
                                                class="w-7 h-7 rounded-[6px] bg-slate-100 hover:bg-red-50 text-slate-500 hover:text-red-600 flex items-center justify-center transition">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="max-w-xs mx-auto space-y-3">
                                        <div class="w-12 h-12 rounded-[10px] bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl">
                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-800">No Donations Found</h3>
                                        <p class="text-xs text-slate-500">
                                            {{ request()->filled('search') || request()->filled('status') ? 'No results matched your filters. Try resetting the search query.' : 'Contributions via Razorpay will be automatically recorded and displayed here.' }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($donations->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>

    </div>

</x-admin.layout>
