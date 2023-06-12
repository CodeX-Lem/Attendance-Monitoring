<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModel extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = ['course', 'trainor_id'];

    public function trainor()
    {
        return $this->belongsTo(TrainorModel::class, 'trainor_id');
    }

    public function students()
    {
        return $this->hasMany(StudentModel::class, 'course_id');
    }
}
