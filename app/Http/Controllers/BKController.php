<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefStudent;
use App\Models\P_Recaps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BKController extends Controller
{
    public function index()
    {
        $recaps = P_Recaps::with('student')->get();

        // Get students who have violations with their violation details
        $students = RefStudent::with([
            'recaps.violation', // Eager load violation details
            'currentAcademicYear.class',
            // For class information
        ])
            ->withCount([
                'recaps as recaps_count' => function ($query) {}
            ])
            ->has('recaps') // Only students with violations
            ->get();

        return view('BK.dashboard.index', compact('students', 'recaps',));
    }

    // Update violation status dengan debug yang sangat detail
    public function updateViolationStatus(Request $request, $id)
    {

        // Validasi input
        $request->validate([
            'status' => 'required|in:pending,verified,not_verified'
        ]);

        try {
            // Debug 3: Cari record dengan berbagai kemungkinan
            Log::info('Searching for P_Recaps record', ['id' => $id]);

            $recap = P_Recaps::find($id);

            if (!$recap) {
                Log::error('P_Recaps not found with ID', ['id' => $id]);

                // Coba cari dengan field lain jika ada
                $recap = P_Recaps::where('p_violation_id', $id)->first();

                if ($recap) {
                    Log::info('Found P_Recaps with p_violation_id', [
                        'p_violation_id' => $id,
                        'actual_id' => $recap->id
                    ]);
                } else {
                    Log::error('P_Recaps not found with any ID field', ['searched_id' => $id]);
                    return redirect()->back()->with('error', 'Data pelanggaran tidak ditemukan (ID: ' . $id . ')');
                }
            }

            // Debug 4: Log data sebelum update
            $originalStatus = $recap->status;
            Log::info('Found P_Recaps record', [
                'id' => $recap->id,
                'p_violation_id' => $recap->p_violation_id ?? 'not_set',
                'current_status' => $originalStatus,
                'new_status' => $request->status,
                'primary_key' => $recap->getKeyName(),
                'key_value' => $recap->getKey()
            ]);

            // Update data
            $recap->status = $request->status;

            if (Auth::check()) {
                $recap->verified_by = Auth::id();
                $recap->updated_by = Auth::id();
            }

            $recap->updated_at = now();

            // Debug 5: Log proses save
            Log::info('Attempting to save P_Recaps', [
                'changes' => $recap->getDirty()
            ]);

            $saved = $recap->save();

            // Debug 6: Verify save result
            $recap->refresh();
            Log::info('Save completed', [
                'save_result' => $saved,
                'new_status' => $recap->status,
                'status_changed' => $originalStatus !== $recap->status
            ]);

            if ($saved && $originalStatus !== $recap->status) {
                return redirect()->back()->with(
                    'success',
                    "Status berhasil diubah dari '{$originalStatus}' ke '{$recap->status}' "
                );
            } else {
                return redirect()->back()->with(
                    'warning',
                    'Data disimpan tetapi status tidak berubah. Original: ' . $originalStatus . ', Current: ' . $recap->status
                );
            }
        } catch (\Exception $e) {
            Log::error('Exception in updateViolationStatus', [
                'id' => $id,
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with(
                'error',
                'Error: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')'
            );
        }
    }

    // Method helper untuk debugging
    public function debugRecap($id)
    {
        $recap = P_Recaps::find($id);

        return response()->json([
            'found' => $recap ? true : false,
            'data' => $recap ? $recap->toArray() : null,
            'model_info' => [
                'table' => (new P_Recaps)->getTable(),
                'primary_key' => (new P_Recaps)->getKeyName(),
                'fillable' => (new P_Recaps)->getFillable(),
            ]
        ]);
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


        return view('BK.dashboard.recaps', compact('recaps'));
    }
}
