<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceModel extends Model
{
    use HasFactory;

    protected $table = 'attendance';
    protected $fillable = [
        'student_id',
        'date',
        'time_in_am',
        'time_out_am',
        'time_in_pm',
        'time_out_pm',
        'status_am',
        'status_pm',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id');
    }
}
