<?php

namespace App\Http\Controllers;

use App\Models\P_Categories;
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
        $students = RefStudent::all();

        // Ambil semua violations
        $categories = P_Categories::with('violations')->get();

        return view('kesiswaan.dashboard.index', compact('students', 'categories'));
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

    public function recaps(Request $request)
    {
        $recaps = RefStudent::whereHas('recaps')
            ->with(['recaps', 'recaps.violation.category', 'user.class'])
            ->withSum('violations', 'point')
            ->get()
            ->unique('id'); // pastikan unik berdasarkan student id tanpa groupBy yang bisa mengganggu eager loading


        return view('kesiswaan.dashboard.recaps', compact('recaps'));
    }
}
