<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function employeeDashboard(Request $request)
    {
        $searchName = trim($request->query('my_name', ''));

        $availableShifts = Shift::where('status', 'pending')->get();
        $myPostedShifts = [];
        $myClaimedShifts = [];

        if ($searchName !== '') {
            $myPostedShifts = Shift::where('posted_by', $searchName)->get();
            $myClaimedShifts = Shift::where('claimed_by', $searchName)->get();
        } else {
            $searchName = null;
        }

        return view('shifts.employee', compact('availableShifts', 'myPostedShifts', 'myClaimedShifts', 'searchName'));
    }

    public function hrDashboard()
    {
        $reviewingShifts = Shift::where('status', 'reviewing')->get();
        $approvedShifts = Shift::where('status', 'approved')->get();
        $rejectedShifts = Shift::where('status', 'rejected')->get();

        return view('shifts.hr', compact('reviewingShifts', 'approvedShifts', 'rejectedShifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'    => 'required|string',
            'posted_by'      => 'required|string',
            'shift_date'     => 'required|date',
            'original_shift' => 'required|string',
            'new_shift'      => 'required|string',
        ]);

        // Prevent posting multiple shift requests on the same day
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
        $request->validate([
            'claimed_by' => 'required|string'
        ]);

        $claimedBy = trim($request->claimed_by);
        $currentShift = Shift::findOrFail($id);

        // Ensure employee can only claim one shift per day
        $hasClaimedOnSameDay = Shift::where('claimed_by', $claimedBy)
            ->where('shift_date', $currentShift->shift_date)
            ->where('status', '!=', 'pending')
            ->exists();

        if ($hasClaimedOnSameDay) {
            return redirect()->back()->with('error', '❌ មិនអាចស្នើសុំបានទេ! អ្នកបានសុំយកវេនការងារមួយផ្សេងទៀតរួចរាល់ហើយក្នុងថ្ងៃទី ' . $currentShift->shift_date . ' នេះ។ សូមជ្រើសរើសថ្ងៃផ្សេងជំនួសវិញ។');
        }

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
        Shift::findOrFail($id)->update([
            'status' => 'rejected'
        ]);
    
    return redirect()->back()->with('info', 'បានបដិសេធសំណើប្ដូរវេននេះរួចរាល់!');
}
}