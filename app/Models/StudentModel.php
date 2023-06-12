<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'course_id',
        'qr_code',
        'first_name',
        'middle_name',
        'last_name',
        'fullname',
        'gender',
        'dob',
        'civil_status',
        'nationality',
        'street',
        'barangay',
        'city',
        'district',
        'province',
        'highest_grade_completed',
        'classification',
        'training_status',
        'scholarship_type',
        'training_completed',
        'image',
        'accepted'
    ];

    public function course()
    {
        return $this->belongsTo(CourseModel::class, 'course_id');
    }

    public function attendance()
    {
        return $this->hasMany(AttendanceModel::class, 'student_id');
    }
}
