<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    // ១. ផ្ទាំង Employee Dashboard
    public function employeeDashboard(Request $request)
    {
        // ចាប់យកឈ្មោះ និងកាត់ឃ្លាទំនេរឆ្វេងស្តាំ (បើមាន)
        $searchName = trim($request->query('my_name', ''));

        $availableShifts = Shift::where('status', 'pending')->get();
        $myPostedShifts = [];
        $myClaimedShifts = [];

        // បើមានការវាយឈ្មោះពិតប្រាកដ (មិនមែនជាតម្លៃទទេ "")
        if ($searchName !== '') {
            $myPostedShifts = Shift::where('posted_by', $searchName)->get();
            $myClaimedShifts = Shift::where('claimed_by', $searchName)->get();
        } else {
            // បើលុបឈ្មោះចេញអស់ ត្រូវកំណត់ឱ្យទៅជា null វិញដើម្បីលាក់ផ្ទាំងលទ្ធផល
            $searchName = null;
        }

        return view('shifts.employee', compact('availableShifts', 'myPostedShifts', 'myClaimedShifts', 'searchName'));
    }

    // ២. ផ្ទាំង HR Dashboard
    public function hrDashboard()
{
    $reviewingShifts = Shift::where('status', 'reviewing')->get();
    $approvedShifts = Shift::where('status', 'approved')->get();
    $rejectedShifts = Shift::where('status', 'rejected')->get(); // <--- ទាញយកទិន្នន័យ Reject

    return view('shifts.hr', compact('reviewingShifts', 'approvedShifts', 'rejectedShifts'));
}

    // មុខងារ បង្ហោះ (Store) សំណើប្ដូរវេន
    public function store(Request $request)
    {
        // កូដលក្ខខណ្ឌឆែក ID និងរក្សាទុកទិន្នន័យរបស់អ្នក...
        $request->validate([
            'employee_id'    => 'required|string',
            'posted_by'      => 'required|string',
            'shift_date'     => 'required|date',
            'original_shift' => 'required|string',
            'new_shift'      => 'required|string',
        ]);

        // 💡 កែប្រែត្រង់នេះ៖ ប្រើប្រាស់ \Illuminate\Support\Carbon ដើម្បីបង្ខំឱ្យស្គាល់ Global Class ផ្ទាល់តែម្ដង
        $hasPostedToday = Shift::where('employee_id', $request->employee_id)
            ->whereDate('created_at', \Illuminate\Support\Carbon::today()) 
            ->exists();

        if ($hasPostedToday) {
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ លោកអ្នកបានបង្ហោះសំណើរួចរាល់ហើយសម្រាប់ថ្ងៃនេះ! សូមរង់ចាំដល់ថ្ងៃស្អែក ទើបអាចបង្ហោះសំណើថ្មីបានទៀត។');
        }

        Shift::create([
            'employee_id'    => $request->employee_id,
            'posted_by'      => $request->posted_by,
            'shift_date'     => $request->shift_date,
            'original_shift' => $request->original_shift,
            'new_shift'      => $request->new_shift,
            'status'         => 'pending'
        ]);

        return redirect()->back()->with('success', '✨ បង្ហោះសំណើប្ដូរវេនបានជោគជ័យ!');
    }

  public function claim(Request $request, $id) 
{
    // 1. ផ្ទៀងផ្ទាត់ទិន្នន័យឈ្មោះអ្នកមកសុំយក
    $request->validate([
        'claimed_by' => 'required|string'
    ]);

    $claimedBy = trim($request->claimed_by);

    // 2. ស្វែងរកទិន្នន័យវេនការងារដែលគាត់កំពុងតែចុចសុំយក
    $currentShift = Shift::findOrFail($id);

    // 3. ឆែកមើលក្នុង Database ថា តើបុគ្គលិកឈ្មោះនេះ ធ្លាប់បានសុំយកវេនណាខុសទៀតទេ ក្នុងថ្ងៃខែដដែលនេះ?
    $hasClaimedOnSameDay = Shift::where('claimed_by', $claimedBy)
        ->where('shift_date', $currentShift->shift_date) // ឆែកមើលថ្ងៃខែដូចគ្នា
        ->where('status', '!=', 'pending') // មិនរាប់បញ្ចូលវេនដែលត្រូវបាន HR Reject ឡើយ
        ->exists();

    // 4. បើរកឃើញថាគាត់បានសុំវេនផ្សេងមួយទៀតរួចហើយក្នុងថ្ងៃហ្នឹង គឺបដិសេធមិនឱ្យយកទ្វេដងឡើយ
    if ($hasClaimedOnSameDay) {
        return redirect()->back()->with('error', '❌ មិនអាចស្នើសុំបានទេ! អ្នកបានសុំយកវេនការងារមួយផ្សេងទៀតរួចរាល់ហើយក្នុងថ្ងៃទី ' . $currentShift->shift_date . ' នេះ។ សូមជ្រើសរើសថ្ងៃផ្សេងជំនួសវិញ។');
    }

    // 5. បើមិនជាន់ថ្ងៃគ្នាទេ អនុញ្ញាតឱ្យសុំយកធម្មតា និងប្ដូរស្ថានភាពទៅជារង់ចាំ HR ពិនិត្យ
    $currentShift->update([
        'claimed_by' => $claimedBy, 
        'status'     => 'reviewing'
    ]);

    return redirect()->back()->with('success', '✨ ស្នើសុំប្ដូរវេនបានជោគជ័យ! រង់ចាំ HR ពិនិត្យ និងអនុម័ត។');
}

    public function approve($id) {
        Shift::findOrFail($id)->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'បានអនុម័តការប្ដូរវេន!');
    }

   public function reject($id) {
    // ប្ដូរ status ទៅជា 'rejected' ដោយរក្សាទុកឈ្មោះអ្នកដែលបានមកសុំ (claimed_by) ដដែល
    Shift::findOrFail($id)->update([
        'status' => 'rejected'
    ]);
    
    return redirect()->back()->with('info', 'បានបដិសេធសំណើប្ដូរវេននេះរួចរាល់!');
}
}