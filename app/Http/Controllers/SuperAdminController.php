<?php

namespace App\Http\Controllers;

use App\Models\P_Categories;
use Illuminate\Http\Request;
use App\Models\RefStudent;
use App\Models\P_Violations;
use App\Models\P_Recaps;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Ambil semua siswa
        $students = RefStudent::all();

        // Ambil semua violations
        $categories = P_Categories::with('violations')->get();
        return view('superadmin.dashboard.index', compact('students', 'categories'));
    }
    public function store(Request $request, $studentId)
    {
        $request->validate([
            'violations'   => 'required|array',
            'violations.*' => 'exists:p_violations,id',
        ]);

        foreach ($request->violations as $violationId) {
            P_Recaps::create([
                'ref_student_id'  => $studentId,
                'p_violation_id'  => $violationId,
                'status'          => 'pending',
                'created_by'      => auth()->id(),
                'updated_by'      => auth()->id(),
            ]);
        }

        return back()->with('success', 'Pelanggaran berhasil ditambahkan.');
    }



    // Controller Method - Update ini di Controller Anda
    public function confirmRecaps()
    {
        // Ambil students dengan relasi recaps yang status pending dan pRecaps untuk detail
        $students = RefStudent::with([
            'verifiedBy',
            'createdBy',
            'updatedBy',
            'user.class',
            'recaps' => function ($query) {
                $query->with([
                    'violation.category',
                    'verifiedBy',
                    'createdBy',
                    'updatedBy',
                ])
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'desc');
            },
            'pRecaps' => function ($query) {
                $query->with([
                    'violation.category',
                    'student',
                    'verifiedBy',
                    'createdBy',
                    'updatedBy'
                ])
                    ->orderBy('created_at', 'desc');
            }
        ])->get();

        return view('superadmin.confirm-recaps.index', compact('students'));
    }

    public function updateViolationStatus(Request $request, $id)
    {
        try {
            $recap = P_Recaps::findOrFail($id);

            $request->validate([
                'status' => 'required|in:verified,not_verified'
            ]);

            $recap->update([
                'status' => $request->status,
                'verified_by' => Auth::id(), // ID user yang sedang login
                'updated_by' => Auth::id()
            ]);

            return redirect()->back()->with('success', 'Status pelanggaran berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data pelanggaran tidak ditemukan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status: ' . $e->getMessage());
        }
    }
}
