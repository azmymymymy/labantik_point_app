<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefStudent;
use App\Models\P_Violations;
use App\Models\P_Recaps;
use Illuminate\Support\Facades\Auth;

class KesiswaanController extends Controller
{
    public function index()
{
    // Ambil semua siswa
    $students = \App\Models\RefStudent::all();

    // Ambil semua violations
    $violations = \App\Models\P_Violations::all();

    return view('kesiswaan.dashboard.index', compact('students', 'violations'));
}

    public function store(Request $request, $studentId)
    {
        // Validasi input
        $request->validate([
            'violations'   => 'required|array',
            'violations.*' => 'exists:p_violations,id',
        ]);

        // Loop setiap pelanggaran yang dipilih
        foreach ($request->violations as $violationId) {
            P_Recaps::create([
                'ref_student_id'  => $studentId,
                'p_violation_id'  => $violationId,
                'status'          => 'pending', // default status
                'created_by'      => auth()->id(),
                'updated_by'      => auth()->id(),
            ]);
        }

        return redirect()->back()->with('success', 'Pelanggaran berhasil ditambahkan.');
    }
}
