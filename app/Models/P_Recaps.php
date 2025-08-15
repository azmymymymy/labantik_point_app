<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class P_Recaps extends Model
{
    public $incrementing = false; // Karena bukan auto increment
    protected $keyType = 'string'; // UUID adalah string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
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
