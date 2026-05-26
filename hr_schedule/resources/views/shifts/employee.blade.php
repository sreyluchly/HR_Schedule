<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-xl shadow-xs border border-gray-100 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">🧑‍💻 ផ្ទាំងបុគ្គលិក (Employee Dashboard)</h1>
                <p class="text-sm text-gray-500">បង្ហោះ ស្វែងរក និងតាមដានការប្ដូរវេនរបស់អ្នក</p>
            </div>
            <a href="{{ route('hr.dashboard') }}" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-900 transition">
                ទៅកាន់ផ្ទាំង HR 🛡️
            </a>
        </div>

        <div class="space-y-3">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm font-medium shadow-xs">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm font-medium shadow-xs flex items-center gap-2">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200">
                <h2 class="font-bold text-blue-600 mb-4 text-lg">✍️ បង្ហោះវេនចង់ប្ដូរ</h2>
                <form action="{{ route('shifts.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">អត្តសញ្ញាណប័ណ្ណ (ID)</label>
                            <input type="text" name="employee_id" value="{{ old('employee_id') }}" placeholder="ឧ. EMP-001" class="w-full border p-2.5 rounded-lg text-sm bg-gray-50 focus:bg-white focus:outline-blue-500" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">ឈ្មោះរបស់អ្នក</label>
                            <input type="text" name="posted_by" value="{{ old('posted_by') }}" placeholder="វាយឈ្មោះរបស់អ្នក..." class="w-full border p-2.5 rounded-lg text-sm bg-gray-50 focus:bg-white focus:outline-blue-500" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">ជ្រើសរើសថ្ងៃខែ</label>
                            <input type="date" name="shift_date" value="{{ old('shift_date') }}" class="w-full border p-2.5 rounded-lg text-sm bg-gray-50 focus:bg-white focus:outline-blue-500 text-gray-700" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-red-600 uppercase mb-1">វេនបច្ចុប្បន្ន (Original)</label>
                            <select name="original_shift" class="w-full border p-2.5 rounded-lg text-sm bg-gray-50 focus:bg-white focus:outline-blue-500 text-gray-700" required>
                                <option value="" disabled selected>-- ជ្រើសរើសវេនដើម --</option>
                                <option value="7:00 AM - 4:00 PM" {{ old('original_shift') == '7:00 AM - 4:00 PM' ? 'selected' : '' }}>7:00 AM - 4:00 PM</option>
                                <option value="8:00 AM - 5:00 PM" {{ old('original_shift') == '8:00 AM - 5:00 PM' ? 'selected' : '' }}>8:00 AM - 5:00 PM</option>
                                <option value="1:00 PM - 10:00 PM" {{ old('original_shift') == '1:00 PM - 10:00 PM' ? 'selected' : '' }}>1:00 PM - 10:00 PM</option>
                                <option value="9:00 PM - 6:00 AM" {{ old('original_shift') == '9:00 PM - 6:00 AM' ? 'selected' : '' }}>9:00 PM - 6:00 AM</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-green-600 uppercase mb-1">វេនដែលចង់បាន (New)</label>
                            <select name="new_shift" class="w-full border p-2.5 rounded-lg text-sm bg-gray-50 focus:bg-white focus:outline-blue-500 text-gray-700" required>
                                <option value="" disabled selected>-- ជ្រើសរើសវេនថ្មី --</option>
                                <option value="7:00 AM - 4:00 PM" {{ old('new_shift') == '7:00 AM - 4:00 PM' ? 'selected' : '' }}>7:00 AM - 4:00 PM</option>
                                <option value="8:00 AM - 5:00 PM" {{ old('new_shift') == '8:00 AM - 5:00 PM' ? 'selected' : '' }}>8:00 AM - 5:00 PM</option>
                                <option value="1:00 PM - 10:00 PM" {{ old('new_shift') == '1:00 PM - 10:00 PM' ? 'selected' : '' }}>1:00 PM - 10:00 PM</option>
                                <option value="9:00 PM - 6:00 AM" {{ old('new_shift') == '9:00 PM - 6:00 AM' ? 'selected' : '' }}>9:00 PM - 6:00 AM</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-bold hover:bg-blue-700 transition cursor-pointer">
                        បង្ហោះចូលប្រព័ន្ធ
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-xs border border-blue-100 bg-blue-50/20 flex flex-col justify-between">
                <div>
                    <h2 class="font-bold text-blue-800 mb-2 text-lg">🔍 ពិនិត្យស្ថានភាពការប្ដូរវេនរបស់អ្នក</h2>
                    <p class="text-xs text-gray-500 mb-4">វាយឈ្មោះរបស់អ្នកដើម្បីមើលសំណើ</p>
                </div>
                
                <form action="{{ route('shifts.employee') }}" method="GET" class="flex gap-2">
                    <input type="text" id="search-input" name="my_name" value="{{ $searchName ?? '' }}" placeholder="វាយឈ្មោះរបស់អ្នកនៅទីនេះ..." class="flex-1 border p-2.5 rounded-lg text-sm bg-white focus:outline-blue-500" autocomplete="off" required>
                    <button type="submit" class="bg-blue-800 text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-900 transition cursor-pointer">
                        ឆែកមើល
                    </button>
                </form>
            </div>
        </div>

        @if(!empty($searchName))
        
            @php
                // ១. ច្រកទិន្នន័យតាមប្រភេទដើម្បីងាយស្រួលបង្ហាញក្នុងប្រវត្តិ (History Filtering)
                $pendingShifts = $myPostedShifts->where('status', 'pending');
                $reviewingPosted = $myPostedShifts->where('status', 'reviewing');
                $reviewingClaimed = $myClaimedShifts->where('status', 'reviewing');

                $approvedPosted = $myPostedShifts->where('status', 'approved');
                $approvedClaimed = $myClaimedShifts->where('status', 'approved');

                $rejectedPosted = $myPostedShifts->where('status', 'rejected');
                $rejectedClaimed = $myClaimedShifts->where('status', 'rejected');

                // ២. ឆែកលក្ខខណ្ឌសម្រាប់លោតផ្ទាំង Alert ព្រមាន (SweetAlert2)
                $isRejected = ($rejectedPosted->isNotEmpty() || $rejectedClaimed->isNotEmpty()) ? 'true' : 'false';
                
                // ស្វែងរកសារមូលហេតុបដិសេធចុងក្រោយគេបង្អស់
                $reason = 'មិនមានការបញ្ជាក់ហេតុផលឡើយ';
                if($rejectedPosted->isNotEmpty() && !empty($rejectedPosted->first()->rejection_reason)) {
                    $reason = $rejectedPosted->first()->rejection_reason;
                } elseif($rejectedClaimed->isNotEmpty() && !empty($rejectedClaimed->first()->rejection_reason)) {
                    $reason = $rejectedClaimed->first()->rejection_reason;
                }
            @endphp

            <input type="hidden" id="reject-status-trigger" value="{{ $isRejected }}">
            <input type="hidden" id="employee-name-trigger" value="{{ $searchName }}">
            <input type="hidden" id="reject-reason-trigger" value="{{ $reason }}">

            <div id="search-results" class="bg-white p-6 rounded-xl shadow border border-gray-200 space-y-8">
                <h2 class="text-xl font-bold text-gray-800 border-b pb-3">
                    📊 ទិន្នន័យ និងប្រវត្តិការប្ដូរវេនសម្រាប់៖ "<span class="text-blue-600">{{ $searchName }}</span>"
                </h2>

                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        ១. សំណើកំពុងរង់ចាំការពិនិត្យ (Active / Pending Requests)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <h4 class="text-xs font-semibold text-gray-500">➡️ វេនដែលអ្នកបានបង្ហោះចង់ប្ដូរចេញ</h4>
                            @forelse($pendingShifts->merge($reviewingPosted) as $shift)
                                <div class="p-3 rounded-lg border text-sm flex justify-between items-center bg-gray-50 border-gray-200">
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium">📅 {{ $shift->shift_date }}</p>
                                        <p class="font-semibold text-gray-800 mt-0.5"><span class="text-red-600 line-through text-xs">{{ $shift->original_shift }}</span> ➔ <span class="text-green-600 font-bold">{{ $shift->new_shift }}</span></p>
                                        <p class="text-xs text-gray-500">អ្នកមកសុំប្ដូរ៖ <span class="font-medium text-gray-700">{{ $shift->claimed_by ?? 'មិនទាន់មាន' }}</span></p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-md text-xs font-bold {{ $shift->status == 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $shift->status == 'pending' ? 'រង់ចាំអ្នកមកសុំ' : 'រង់ចាំ HR ពិនិត្យ' }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic py-1">គ្មានសំណើកំពុងរង់ចាំឡើយ។</p>
                            @endforelse
                        </div>

                        <div class="space-y-2">
                            <h4 class="text-xs font-semibold text-gray-500">⬅️ វេនដែលអ្នកបានទៅស្នើសុំយកពីគេ</h4>
                            @forelse($reviewingClaimed as $shift)
                                <div class="p-3 rounded-lg border text-sm flex justify-between items-center bg-gray-50 border-gray-200">
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium">📅 {{ $shift->shift_date }}</p>
                                        <p class="font-semibold text-gray-800 mt-0.5"><span class="text-red-500 font-medium">{{ $shift->original_shift }}</span> ➔ <span class="text-green-600 font-bold">{{ $shift->new_shift }}</span></p>
                                        <p class="text-xs text-gray-500">ម្ចាស់វេនដើម៖ <span class="font-medium text-gray-700">{{ $shift->posted_by }}</span></p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-yellow-100 text-yellow-800">
                                        រង់ចាំ HR អនុម័ត
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic py-1">គ្មានសំណើកំពុងទៅសុំគេឡើយ។</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="space-y-3 pt-2 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-emerald-600 flex items-center gap-1">
                        <span>✅</span> ២. ប្រវត្តិប្ដូរវេនរួចរាល់ (Approved Logs History)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($approvedPosted->merge($approvedClaimed) as $shift)
                            <div class="p-3 rounded-lg border text-sm flex justify-between items-center bg-emerald-50/30 border-emerald-100">
                                <div>
                                    <p class="text-xs text-emerald-600 font-semibold font-mono">📅 ថ្ងៃទី៖ {{ $shift->shift_date }}</p>
                                    <p class="font-semibold text-gray-800 mt-1"><span class="text-red-500 line-through text-xs font-normal">{{ $shift->original_shift }}</span> ➔ <span class="text-emerald-600 font-bold">{{ $shift->new_shift }}</span></p>
                                    <p class="text-xs text-gray-500 mt-0.5">ម្ចាស់ដើម៖ <span class="font-medium">{{ $shift->posted_by }}</span> | អ្នកជំនួស៖ <span class="font-bold text-emerald-600">{{ $shift->claimed_by }}</span></p>
                                </div>
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-800 shrink-0">
                                    Approved
                                </span>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-2 text-gray-400 italic text-xs">
                                📂 មិនទាន់មានប្រវត្តិប្ដូរវេនជោគជ័យនៅឡើយទេ។
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-3 pt-2 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-rose-600 flex items-center gap-1">
                        <span>❌</span> ៣. ប្រវត្តិបដិសេធសំណើ (Rejected Logs History)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($rejectedPosted->merge($rejectedClaimed) as $shift)
                            <div class="p-3 rounded-lg border text-sm flex flex-col justify-between gap-2 bg-rose-50/20 border-rose-100">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium">📅 ថ្ងៃទី៖ {{ $shift->shift_date }}</p>
                                        <p class="font-semibold text-gray-800 mt-0.5"><span class="text-gray-400 line-through text-xs font-normal">{{ $shift->original_shift }}</span> ➔ <span class="text-gray-700 font-semibold">{{ $shift->new_shift }}</span></p>
                                        <p class="text-xs text-gray-500">ម្ចាស់ដើម៖ <span>{{ $shift->posted_by }}</span> | អ្នកសុំ៖ <span>{{ $shift->claimed_by }}</span></p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-rose-100 text-rose-800 shrink-0">
                                        Rejected
                                    </span>
                                </div>
                                <div class="text-xs text-rose-700 bg-rose-50/70 p-2 rounded border border-rose-200/60 font-sans">
                                    <b>💬 មូលហេតុពី HR៖</b> {{ $shift->rejection_reason ?? 'គ្មានការបញ្ជាក់ហេតុផលលម្អិត' }}
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-2 text-gray-400 italic text-xs">
                                🛡️ គ្មានប្រវត្តិនៃការបដិសេធសំណើឡើយ។
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-200">
            <h2 class="text-lg font-bold text-amber-600 mb-4">📋 វេនការងារកំពុងស្វែងរកអ្នកជំនួស (Available Shifts)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($availableShifts as $shift)
                    <div class="p-4 rounded-xl bg-amber-50/50 border border-amber-100 flex flex-col justify-between">
                        <div>
                            <div class="mb-2">
                                <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-1.5 py-0.5 rounded font-mono">ID: {{ $shift->employee_id }}</span>
                            </div>
                            <p class="font-bold text-gray-800">អ្នកបង្ហោះ៖ {{ $shift->posted_by }}</p>
                            <p class="text-sm text-gray-600 mt-1">📅 ថ្ងៃទី៖ {{ $shift->shift_date }}</p>
                            
                            <div class="mt-2 bg-white/80 p-2 rounded border border-amber-200/50 text-xs">
                                <p class="text-red-600">❌ វេនបច្ចុប្បន្ន៖ <b>{{ $shift->original_shift }}</b></p>
                                <p class="text-green-600 mt-0.5">👉 ចង់ដូរយក៖ <b>{{ $shift->new_shift }}</b></p>
                            </div>
                        </div>
                        
                        <form action="{{ route('shifts.claim', $shift->id) }}" method="POST" class="mt-4 pt-3 border-t border-amber-200/60 flex gap-2">
                            @csrf
                            <input type="text" name="claimed_by" placeholder="វាយឈ្មោះអ្នកសុំយក..." class="border p-2 text-xs rounded-lg bg-white flex-1 focus:outline-amber-500" required>
                            <button type="submit" class="bg-amber-600 text-white text-xs px-3 py-2 rounded-lg font-bold hover:bg-amber-700 transition cursor-pointer">
                                សុំយក
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-8 col-span-1 md:col-span-2 lg:col-span-3">
                        <p class="text-gray-400 italic text-sm">មិនមានវេនការងារទំនេរក្នុងប្រព័ន្ធឡើយ My.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

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

            // 🚨 លោតផ្ទាំង Alert Popup ប្រាប់ភ្លាមៗចំកណ្ដាលអេក្រង់ បើមានស្ថានភាព Rejected ក្នុងប្រវត្តិ
            const rejectStatus = document.getElementById('reject-status-trigger');
            const empName = document.getElementById('employee-name-trigger');
            const rejectReason = document.getElementById('reject-reason-trigger');

            if (rejectStatus && rejectStatus.value === 'true') {
                Swal.fire({
                    icon: 'error',
                    title: 'សំណើត្រូវបានបដិសេធ!',
                    html: `<div class="text-left font-sans space-y-2">
                            <p>សួស្ដី លោក/លោកស្រី <b>${empName.value}</b>, សំណើប្ដូរវេនការងាររបស់អ្នក ឬវេនដែលអ្នកបានទៅសុំយកពីគេ ត្រូវបាន HR បដិសេធ។</p>
                            <div class="bg-red-50 p-3 rounded-lg border border-red-200 mt-2">
                                <p class="text-sm text-red-700"><b>📌 មូលហេតុពី HR៖</b> ${rejectReason.value}</p>
                            </div>
                           </div>`,
                    confirmButtonText: 'យល់ព្រម និងពិនិត្យប្រវត្តិ',
                    confirmButtonColor: '#d33',
                    background: '#fff',
                    backdrop: `rgba(211, 47, 47, 0.15)`
                });
            }
        });
    </script>
</body>
</html>