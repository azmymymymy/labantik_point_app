<?php

namespace App\Http\Controllers;

use App\Models\RefStudent;
use App\Models\P_Violations;

use Illuminate\Http\Request;

class KesiswaanController extends Controller
{
    //
    public function index()
    {
        $students = RefStudent::all();
        $violations = P_Violations::all();
        return view('kesiswaan.dashboard.index', compact('students', 'violations'));
    }
    public function store(Request $request)
    {
        $selectedViolations = $request->violations; // Array ID violations
        $studentId = $request->student_id;

        // Process data...

        return redirect()->back()->with('success', 'Violations saved successfully');
    }
}
