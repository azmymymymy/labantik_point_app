<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P_Recaps extends Model
{
    protected $table = 'p_recaps';

    protected $fillable = [
        'ref_student_id',
        'p_violation_id',
        'status',
        'created_at',
        'updated_at',
        'verified_by',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan RefStudent
    public function student()
    {
        return $this->belongsTo(RefStudent::class, 'ref_student_id');
    }

    // Relationship dengan P_Violations
    public function violation()
    {
        return $this->belongsTo(P_Violations::class, 'p_violation_id');
    }
}
