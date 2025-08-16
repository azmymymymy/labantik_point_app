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
        $categoryFilter = $request->input('category_filter');
        $statusFilter = $request->input('status_filter');

        $query = RefStudent::whereHas('recaps')
            ->with([
                'recaps' => function ($query) use ($categoryFilter, $statusFilter) {
                    if ($categoryFilter) {
                        $query->whereHas('violation.category', function ($q) use ($categoryFilter) {
                            $q->where('name', $categoryFilter);
                        });
                    }

                    if ($statusFilter) {
                        $query->where('status', $statusFilter);
                    }

                    $query->with('violation.category');
                },
                'user.class'
            ])
            ->withSum(['violations' => function ($query) use ($categoryFilter, $statusFilter) {
                if ($categoryFilter) {
                    $query->whereHas('violation.category', function ($q) use ($categoryFilter) {
                        $q->where('name', $categoryFilter);
                    });
                }

                if ($statusFilter) {
                    $query->where('status', $statusFilter);
                }
            }], 'point');

        // Filter students yang memiliki violations sesuai kriteria
        if ($categoryFilter || $statusFilter) {
            $query->whereHas('recaps', function ($query) use ($categoryFilter, $statusFilter) {
                if ($categoryFilter) {
                    $query->whereHas('violation.category', function ($q) use ($categoryFilter) {
                        $q->where('name', $categoryFilter);
                    });
                }

                if ($statusFilter) {
                    $query->where('status', $statusFilter);
                }
            });
        }

        $recaps = $query->get()->unique('id');

        // Ambil data untuk dropdown filter
        $categories = ['Ringan', 'Sedang', 'Berat'];
        $statuses = [
            'verified' => 'Terverifikasi',
            'pending' => 'Pending',
            'not-verified' => 'Tidak Terverifikasi'
        ];

        return view('kesiswaan.dashboard.recaps', compact('recaps', 'categories', 'statuses', 'categoryFilter', 'statusFilter'));
    }
}
