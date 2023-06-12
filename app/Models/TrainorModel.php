<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainorModel extends Model
{
    use HasFactory;

    protected $table = 'trainors';
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'fullname', 'address', 'contact_no', 'gender'];

    public function course()
    {
        return $this->hasOne(CourseModel::class, 'trainor_id');
    }

    public function user()
    {
        return $this->hasOne(UserModel::class, 'trainor_id');
    }
}
