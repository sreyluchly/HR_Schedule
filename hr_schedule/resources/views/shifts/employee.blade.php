<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <!-- Fixed Header -->
        <div class="fixed top-0 left-0 right-0 z-50 bg-gray-50 px-6 pt-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-xl shadow-xs border border-gray-100 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">🧑‍💻 Employee Dashboard</h1>
                    <p class="text-sm text-gray-500">Post, search and track your shift changes</p>
                </div>
                <a href="{{ route('hr.dashboard') }}" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-900 transition">
                    Go to HR Dashboard 🛡️
                </a>
            </div>
        </div>

        <!-- System Alerts Group -->
        <div class="space-y-4 pt-28">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm font-medium shadow-xs">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm font-medium shadow-xs flex items-center gap-2">
                    🛑 {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Dashboard Actions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Request Form -->
            <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200">
                <h2 class="font-bold text-blue-600 mb-4 text-lg">✍️ Post a Shift Change Request</h2>
                <form action="{{ route('shifts.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Employee ID</label>
                            <input type="text" name="employee_id" value="{{ old('employee_id') }}" placeholder="e.g. EMP-001" class="w-full border border-gray-300 p-2.5 rounded-lg text-sm bg-gray-50 focus:bg-white focus:outline-blue-500" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Your Name</label>
                            <input type="text" name="posted_by" value="{{ old('posted_by') }}" placeholder="Enter your name..." class="w-full border border-gray-300 p-2.5 rounded-lg text-sm bg-gray-50 focus:bg-white focus:outline-blue-500" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Select Date</label>
                            <input type="date" name="shift_date" value="{{ old('shift_date') }}" class="w-full border border-gray-300 p-2.5 rounded-lg text-sm bg-gray-50 focus:bg-white focus:outline-blue-500 text-gray-700" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-red-600 uppercase mb-1">Current Shift (Original)</label>
                            <select name="original_shift" class="w-full border border-gray-300 p-2.5 rounded-lg text-sm bg-gray-50 focus:bg-white focus:outline-blue-500 text-gray-700" required>
                                <option value="" disabled selected>-- Select Original Shift --</option>
                                <option value="7:00 AM - 4:00 PM" {{ old('original_shift') == '7:00 AM - 4:00 PM' ? 'selected' : '' }}>7:00 AM - 4:00 PM</option>
                                <option value="8:00 AM - 5:00 PM" {{ old('original_shift') == '8:00 AM - 5:00 PM' ? 'selected' : '' }}>8:00 AM - 5:00 PM</option>
                                <option value="1:00 PM - 10:00 PM" {{ old('original_shift') == '1:00 PM - 10:00 PM' ? 'selected' : '' }}>1:00 PM - 10:00 PM</option>
                                <option value="9:00 PM - 6:00 AM" {{ old('original_shift') == '9:00 PM - 6:00 AM' ? 'selected' : '' }}>9:00 PM - 6:00 AM</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-green-600 uppercase mb-1">Requested Shift (New)</label>
                            <select name="new_shift" class="w-full border border-gray-300 p-2.5 rounded-lg text-sm bg-gray-50 focus:bg-white focus:outline-blue-500 text-gray-700" required>
                                <option value="" disabled selected>-- Select New Shift --</option>
                                <option value="7:00 AM - 4:00 PM" {{ old('new_shift') == '7:00 AM - 4:00 PM' ? 'selected' : '' }}>7:00 AM - 4:00 PM</option>
                                <option value="8:00 AM - 5:00 PM" {{ old('new_shift') == '8:00 AM - 5:00 PM' ? 'selected' : '' }}>8:00 AM - 5:00 PM</option>
                                <option value="1:00 PM - 10:00 PM" {{ old('new_shift') == '1:00 PM - 10:00 PM' ? 'selected' : '' }}>1:00 PM - 10:00 PM</option>
                                <option value="9:00 PM - 6:00 AM" {{ old('new_shift') == '9:00 PM - 6:00 AM' ? 'selected' : '' }}>9:00 PM - 6:00 AM</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700 transition cursor-pointer">
                        Submit Request
                    </button>
                </form>
            </div>

            <!-- Status Lookup -->
            <div class="bg-white p-6 rounded-xl shadow-xs border border-blue-100 bg-blue-50/20 flex flex-col justify-between">
                <div>
                    <h2 class="font-bold text-blue-800 mb-2 text-lg">🔍 Check Your Shift Change Status</h2>
                    <p class="text-xs text-gray-500 mb-4">Enter your name to view your requests</p>
                </div>
                
                <form action="{{ route('shifts.employee') }}" method="GET" class="flex gap-2">
                    <input type="text" id="search-input" name="my_name" value="{{ $searchName ?? '' }}" placeholder="Enter your name here..." class="flex-1 border border-gray-300 p-2.5 rounded-lg text-sm bg-white focus:outline-blue-500" autocomplete="off" required>
                    <button type="submit" class="bg-blue-800 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-900 transition cursor-pointer">
                        Search
                    </button>
                </form>
            </div>
        </div>

        <!-- Search History Output -->
        @if(!empty($searchName))
        
            @php
                $pendingShifts = $myPostedShifts->where('status', 'pending');
                $reviewingPosted = $myPostedShifts->where('status', 'reviewing');
                $reviewingClaimed = $myClaimedShifts->where('status', 'reviewing');

                $approvedPosted = $myPostedShifts->where('status', 'approved');
                $approvedClaimed = $myClaimedShifts->where('status', 'approved');

                $rejectedPosted = $myPostedShifts->where('status', 'rejected');
                $rejectedClaimed = $myClaimedShifts->where('status', 'rejected');
            @endphp

            <div id="search-results" class="bg-white p-6 rounded-xl shadow border border-gray-200 space-y-8">
                <h2 class="text-xl font-bold text-gray-800 border-b pb-3">
                    📊 Shift Change Data and History for: "<span class="text-blue-600">{{ $searchName }}</span>"
                </h2>

                <!-- 1. Active/Pending -->
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        1. Active / Pending Requests
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <h4 class="text-xs font-semibold text-gray-500">➡️ Shifts You Posted for Exchange</h4>
                            @forelse($pendingShifts->merge($reviewingPosted) as $shift)
                                <div class="p-3 rounded-lg border text-sm flex justify-between items-center bg-gray-50 border-gray-200">
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium">📅 {{ $shift->shift_date }}</p>
                                        <p class="font-semibold text-gray-800 mt-0.5"><span class="text-red-600 line-through text-xs">{{ $shift->original_shift }}</span> ➔ <span class="text-green-600 font-bold">{{ $shift->new_shift }}</span></p>
                                        <p class="text-xs text-gray-500">Requestor: <span class="font-medium text-gray-700">{{ $shift->claimed_by ?? 'Not yet' }}</span></p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-md text-xs font-bold {{ $shift->status == 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $shift->status == 'pending' ? 'Waiting for Requestor' : 'Waiting for HR Review' }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic py-1">No pending requests.</p>
                            @endforelse
                        </div>

                        <div class="space-y-2">
                            <h4 class="text-xs font-semibold text-gray-500">⬅️ Shifts You Requested to Take From Others</h4>
                            @forelse($reviewingClaimed as $shift)
                                <div class="p-3 rounded-lg border text-sm flex justify-between items-center bg-gray-50 border-gray-200">
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium">📅 {{ $shift->shift_date }}</p>
                                        <p class="font-semibold text-gray-800 mt-0.5"><span class="text-red-500 font-medium">{{ $shift->original_shift }}</span> ➔ <span class="text-green-600 font-bold">{{ $shift->new_shift }}</span></p>
                                        <p class="text-xs text-gray-500">Original Shift Owner: <span class="font-medium text-gray-700">{{ $shift->posted_by }}</span></p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-yellow-100 text-yellow-800">
                                        Waiting for HR Approval
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic py-1">No pending requests to take from others.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- 2. Approved Logs -->
                <div class="space-y-3 pt-2 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-emerald-600 flex items-center gap-1">
                        <span>✅</span> 2. Approved Shift Changes (Approved Logs History)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($approvedPosted->merge($approvedClaimed) as $shift)
                            <div class="p-3 rounded-lg border text-sm flex justify-between items-center bg-emerald-50/30 border-emerald-100">
                                <div>
                                    <p class="text-xs text-emerald-600 font-semibold font-mono">📅 Date: {{ $shift->shift_date }}</p>
                                    <p class="font-semibold text-gray-800 mt-1"><span class="text-red-500 line-through text-xs font-normal">{{ $shift->original_shift }}</span> ➔ <span class="text-emerald-600 font-bold">{{ $shift->new_shift }}</span></p>
                                    <p class="text-xs text-gray-500 mt-0.5">Original Owner: <span class="font-medium">{{ $shift->posted_by }}</span> | Replacement: <span class="font-bold text-emerald-600">{{ $shift->claimed_by }}</span></p>
                                </div>
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-800 shrink-0">
                                    Approved
                                </span>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-2 text-gray-400 italic text-xs">
                                📂 No approved shift changes yet.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- 3. Rejected Logs -->
                <div class="space-y-3 pt-2 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-rose-600 flex items-center gap-1">
                        <span>❌</span> 3. Rejected Request History (Rejected Logs History)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($rejectedPosted->merge($rejectedClaimed) as $shift)
                            <div class="p-3 rounded-lg border text-sm flex flex-col justify-between gap-2 bg-rose-50/20 border-rose-100">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium">📅 Date: {{ $shift->shift_date }}</p>
                                        <p class="font-semibold text-gray-800 mt-0.5"><span class="text-gray-400 line-through text-xs font-normal">{{ $shift->original_shift }}</span> ➔ <span class="text-gray-700 font-semibold">{{ $shift->new_shift }}</span></p>
                                        <p class="text-xs text-gray-500">Original Owner: <span>{{ $shift->posted_by }}</span> | Requestor: <span>{{ $shift->claimed_by }}</span></p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-rose-100 text-rose-800 shrink-0">
                                        Rejected
                                    </span>
                                </div>
                                <div class="text-xs text-rose-700 bg-rose-50/70 p-2 rounded border border-rose-200/60 font-sans">
                                    <b>💬 Reason from HR:</b> {{ $shift->rejection_reason ?? 'No detailed reason provided' }}
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-2 text-gray-400 italic text-xs">
                                🛡️ No rejection history.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        <!-- Marketplace Available Shifts -->
        <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200">
            <h2 class="text-lg font-bold text-amber-600 mb-4">📋 Available Shifts (Need Replacement)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($availableShifts as $shift)
                    <div class="p-4 rounded-xl bg-amber-50/50 border border-amber-100 flex flex-col justify-between">
                        <div>
                            <div class="mb-2">
                                <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-1.5 py-0.5 rounded font-mono">ID: {{ $shift->employee_id }}</span>
                            </div>
                            <p class="font-bold text-gray-800">Posted By: {{ $shift->posted_by }}</p>
                            <p class="text-sm text-gray-600 mt-1">📅 Date: {{ $shift->shift_date }}</p>
                            
                            <div class="mt-2 bg-white/80 p-2 rounded border border-amber-200/50 text-xs">
                                <p class="text-red-600">❌ Current Shift: <b>{{ $shift->original_shift }}</b></p>
                                <p class="text-green-600 mt-0.5">👉 Wants to Exchange to: <b>{{ $shift->new_shift }}</b></p>
                            </div>
                        </div>
                        
                        <form action="{{ route('shifts.claim', $shift->id) }}" method="POST" class="mt-4 pt-3 border-t border-amber-200/60 flex gap-2">
                            @csrf
                            <input type="text" name="claimed_by" placeholder="Enter your name..." class="border border-gray-300 p-2 text-xs rounded-lg bg-white flex-1 focus:outline-amber-500" required>
                            <button type="submit" class="bg-amber-600 text-white text-xs px-3 py-2 rounded-lg font-bold hover:bg-amber-700 transition cursor-pointer">
                                Request
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-8 col-span-1 md:col-span-2 lg:col-span-3">
                        <p class="text-gray-400 italic text-sm">No available shifts in the system.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- JavaScript Handlers -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const searchResults = document.getElementById('search-results');

            if (searchInput && searchResults) {
                searchInput.addEventListener('input', function () {
                    if (this.value.trim() === '') {
                        searchResults.style.display = 'none';
                    }
                });
            }

            // TRIGGER SWEETALERT ONLY ON FRESH SESSION REJECTIONS (Flash Data)
            // Instead of pulling from old logs database logic directly, read a single instance alert if flashed
            @if(session('show_reject_modal'))
                Swal.fire({
                    icon: 'error',
                    title: 'Action Update',
                    html: `<div class="text-left font-sans space-y-2">
                            <p>Your instant request adjustment could not be completed.</p>
                            <div class="bg-red-50 p-3 rounded-lg border border-red-200 mt-2">
                                <p class="text-sm text-red-700"><b>📌 Details:</b> {{ session('show_reject_modal') }}</p>
                            </div>
                           </div>`,
                    confirmButtonText: 'View History Logs',
                    confirmButtonColor: '#d33',
                    background: '#fff',
                    backdrop: `rgba(211, 47, 47, 0.15)`
                });
            @endif
        });
    </script>
</body>
</html>