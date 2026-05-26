<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-900 p-6 text-white font-sans">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-800 p-6 rounded-xl border border-slate-700 gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-100 uppercase tracking-wider">🛡️ ផ្ទាំងគ្រប់គ្រងសម្រាប់ HR (HR Dashboard)</h1>
                <p class="text-sm text-slate-400">ពិនិត្យ អនុម័ត ឬ បដិសេធ សំណើប្ដូរវេនការងាររបស់បុគ្គលិកទាំងអស់</p>
            </div>
            <a href="{{ route('shifts.employee') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition cursor-pointer">
                ទៅផ្ទាំងបុគ្គលិក 🧑‍💻
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-300 px-4 py-3 rounded-lg text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-amber-500/20 border border-amber-500 text-amber-300 px-4 py-3 rounded-lg text-sm">
                ℹ️ {{ session('info') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="bg-slate-800 p-5 rounded-xl border border-slate-700">
                <h3 class="text-md font-bold text-yellow-400 mb-4 flex items-center gap-2 border-b border-slate-700 pb-3">
                    <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                    សំណើកំពុងរង់ចាំការអនុម័ត (Pending HR Approval)
                </h3>
                
                <div class="space-y-4">
                    @forelse($reviewingShifts as $shift)
                        <div class="p-4 rounded-lg bg-slate-700/40 border border-slate-600 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition hover:border-slate-500">
                            <div class="space-y-1">
                                <p class="text-xs text-slate-400">📅 ថ្ងៃទី៖ <span class="text-white font-semibold font-mono">{{ $shift->shift_date }}</span> <span class="ml-2 bg-blue-500/20 text-blue-300 text-[10px] px-1.5 py-0.5 rounded font-mono border border-blue-500/30">ID: {{ $shift->employee_id }}</span></p>
                                <p class="text-sm text-slate-300">
                                    វេនដើម៖ <span class="text-red-400 line-through font-medium">{{ $shift->original_shift }}</span> ➔ 
                                    ចង់បាន៖ <span class="text-emerald-400 font-bold">{{ $shift->new_shift }}</span>
                                </p>
                                <div class="pt-2 flex items-center gap-2 text-xs">
                                    <span class="bg-slate-600 px-2.5 py-1 rounded-md text-slate-200 font-medium">អ្នកបង្ហោះ៖ {{ $shift->posted_by }}</span>
                                    <span class="text-yellow-400 font-bold">➔ សុំជំនួសដោយ ➔</span>
                                    <span class="bg-yellow-500/20 px-2.5 py-1 rounded-md text-yellow-300 font-bold border border-yellow-500/30">{{ $shift->claimed_by }}</span>
                                </div>
                            </div>
                            
                            <div class="flex gap-2 w-full sm:w-auto">
                                <form action="{{ route('hr.approve', $shift->id) }}" method="POST" class="flex-1 sm:flex-none">
                                    @csrf
                                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-xs text-white px-4 py-2 rounded-lg font-bold transition cursor-pointer">
                                        យល់ព្រម
                                    </button>
                                </form>
                                <form action="{{ route('hr.reject', $shift->id) }}" method="POST" class="flex-1 sm:flex-none">
                                    @csrf
                                    <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-xs text-white px-4 py-2 rounded-lg font-bold transition cursor-pointer">
                                        បដិសេធ
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-500 italic text-sm">
                            💤 គ្មានសំណើថ្មីដែលត្រូវពិនិត្យឡើយ។
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-slate-800 p-5 rounded-xl border border-slate-700">
                <h3 class="text-md font-bold text-emerald-400 mb-4 flex items-center gap-2 border-b border-slate-700 pb-3">
                    <span>✅</span> ប្រវត្តិប្ដូរវេនរួចរាល់ (Approved Logs)
                </h3>
                
                <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2">
                    @forelse($approvedShifts as $shift)
                        <div class="p-4 rounded-lg bg-emerald-950/20 border border-emerald-900/50 flex justify-between items-center transition hover:bg-emerald-950/30">
                            <div>
                                <p class="text-xs text-slate-400">📅 ថ្ងៃទី៖ <span class="text-slate-200 font-mono">{{ $shift->shift_date }}</span></p>
                                <p class="text-xs text-slate-400 mt-0.5">វេនការងារ៖ <span class="text-red-400 line-through">{{ $shift->original_shift }}</span> ➔ <span class="text-emerald-400 font-bold">{{ $shift->new_shift }}</span></p>
                                <p class="text-sm mt-2 text-slate-300">
                                    <strong class="text-slate-100 font-medium">{{ $shift->posted_by }}</strong> 
                                    <span class="text-xs text-slate-500 mx-1">បានប្ដូរទៅឱ្យ</span> 
                                    <strong class="text-emerald-400 font-bold">{{ $shift->claimed_by }}</strong>
                                </p>
                            </div>
                            <span class="text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-1 rounded-md font-bold uppercase tracking-wider">
                                រួចរាល់
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-500 italic text-sm">
                            📂 មិនទាន់មានប្រវត្តិប្ដូរវេនការងារនៅឡើយទេ។
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="bg-slate-800 p-5 rounded-xl border border-slate-700">
            <h3 class="text-md font-bold text-rose-400 mb-4 flex items-center gap-2 border-b border-slate-700 pb-3">
                <span>❌</span> ប្រវត្តិបដិសេធសំណើ (Rejected Logs)
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($rejectedShifts as $shift)
                    <div class="p-4 rounded-lg bg-rose-950/10 border border-rose-900/40 flex flex-col justify-between gap-3">
                        <div>
                            <div class="flex justify-between items-start">
                                <p class="text-xs text-slate-400 font-medium">📅 ថ្ងៃទី៖ <span class="text-slate-200 font-mono">{{ $shift->shift_date }}</span></p>
                                <span class="text-[9px] bg-rose-500/10 text-rose-400 border border-rose-500/20 px-2 py-0.5 rounded font-bold uppercase tracking-wider">
                                    បដិសេធ
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">វេនការងារ៖ <span class="text-slate-300">{{ $shift->original_shift }}</span> ➔ <span class="text-slate-300 font-semibold">{{ $shift->new_shift }}</span></p>
                            
                            <div class="mt-3 text-xs space-y-1 bg-slate-900/40 p-2 rounded border border-slate-700">
                                <p class="text-slate-400">ម្ចាស់វេនដើម៖ <span class="text-slate-200 font-medium">{{ $shift->posted_by }}</span></p>
                                <p class="text-rose-300">អ្នកដែលត្រូវបដិសេធ៖ <span class="font-bold">{{ $shift->claimed_by }}</span></p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-8 text-slate-500 italic text-sm">
                        🛡️ គ្មានប្រវត្តិនៃការបដិសេធសំណើឡើយ។
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</body>
</html>