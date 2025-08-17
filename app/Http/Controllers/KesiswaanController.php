<?php

namespace App\Http\Controllers;

use App\Models\P_Categories;
use Illuminate\Http\Request;
use App\Models\RefStudent;
use App\Models\P_Violations;
use App\Models\P_Recaps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KesiswaanController extends Controller
{

    public function index()
    {

        // Ambil semua siswa
        $students = RefStudent::with('recaps')->get();

        // Ambil semua violations
        $categories = P_Categories::with('violations')->get();

        return view('kesiswaan.dashboard.index', compact('students', 'categories'));
    }

    public function store(Request $request, $studentId)
    {
        $request->validate([
            'violations'   => 'required|array',
            'violations.*' => 'exists:p_violations,id',
        ]);

        // Hitung total poin verified saat ini
        $currentVerifiedPoints = P_Recaps::where('ref_student_id', $studentId)
            ->where('status', 'verified')
            ->join('p_violations', 'p_recaps.p_violation_id', '=', 'p_violations.id')
            ->sum('p_violations.point');

        // Hitung total poin pending saat ini
        $currentPendingPoints = P_Recaps::where('ref_student_id', $studentId)
            ->where('status', 'pending')
            ->join('p_violations', 'p_recaps.p_violation_id', '=', 'p_violations.id')
            ->sum('p_violations.point');

        // Total poin saat ini (verified + pending)
        $currentTotalPoints = $currentVerifiedPoints + $currentPendingPoints;

        // Hitung poin baru yang akan ditambah
        $newPoints = 0;
        $violationIds = $request->violations;

        if (!empty($violationIds)) {
            $newPoints = P_Violations::whereIn('id', $violationIds)->sum('point');
        }

        // Hitung total poin setelah penambahan
        $totalPointsAfterAdd = $currentTotalPoints + $newPoints;

        // VALIDASI UTAMA: Cek apakah total poin saat ini sudah mencapai atau melebihi 100
        if ($currentTotalPoints >= 100) {
            return back()->withErrors([
                'error' => 'Siswa sudah mencapai batas maksimal 100 poin. Tidak dapat menambah pelanggaran lagi.'
            ])->with([
                'current_verified_points' => $currentVerifiedPoints,
                'current_pending_points' => $currentPendingPoints,
                'current_total_points' => $currentTotalPoints,
                'new_points' => $newPoints
            ]);
        }

        // VALIDASI KEDUA: Cek apakah penambahan poin baru akan melebihi 100
        if ($totalPointsAfterAdd > 100) {
            $excessPoints = $totalPointsAfterAdd - 100;
            return back()->withErrors([
                'error' => 'Penambahan pelanggaran ini akan melebihi batas maksimal 100 poin.'
            ])->with([
                'current_verified_points' => $currentVerifiedPoints,
                'current_pending_points' => $currentPendingPoints,
                'current_total_points' => $currentTotalPoints,
                'new_points' => $newPoints,
                'total_points_after' => $totalPointsAfterAdd,
                'excess_points' => $excessPoints
            ]);
        }

        // Jika validasi lolos, simpan pelanggaran ke database
        try {
            DB::beginTransaction();

            foreach ($violationIds as $violationId) {
                P_Recaps::create([
                    'ref_student_id'  => $studentId,
                    'p_violation_id'  => $violationId,
                    'status'          => 'pending',
                    'created_by'      => Auth::id(),
                    'updated_by'      => Auth::id(),
                ]);
            }

            DB::commit();

            // Hitung ulang poin setelah penyimpanan untuk success message
            $verifiedPoints = P_Recaps::where('ref_student_id', $studentId)
                ->where('status', 'verified')
                ->join('p_violations', 'p_recaps.p_violation_id', '=', 'p_violations.id')
                ->sum('p_violations.point');

            $pendingPoints = P_Recaps::where('ref_student_id', $studentId)
                ->where('status', 'pending')
                ->join('p_violations', 'p_recaps.p_violation_id', '=', 'p_violations.id')
                ->sum('p_violations.point');

            $totalAllPoints = $verifiedPoints + $pendingPoints;

            return back()->with([
                'success' => 'Pelanggaran berhasil ditambahkan!',
                'verified_points' => $verifiedPoints,
                'pending_points' => $pendingPoints,
                'total_all_points' => $totalAllPoints,
                'added_points' => $newPoints
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    public function recaps(Request $request)
    {
        $recaps = RefStudent::whereHas('recaps')
            ->with([
                'recaps' => function ($query) {
                    $query->with([
                        'violation.category',
                        'verifiedBy',
                        'createdBy',
                        'updatedBy',
                    ]);
                },
                'user.class'
            ])
            ->withSum(['violations as violations_sum_point' => function ($query) {
                // hanya hitung poin dari violations yang recap-nya verified
                $query->whereHas('recaps', function ($q) {
                    $q->where('status', 'verified');
                });
            }], 'point')
            ->get()
            ->unique('id');


        return view('kesiswaan.dashboard.recaps', compact('recaps'));
    }
}
