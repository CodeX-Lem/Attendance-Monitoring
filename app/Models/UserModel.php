<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = ['username', 'password', 'trainor_id'];

    public function trainor()
    {
        return $this->belongsTo(TrainorModel::class, 'trainor_id');
    }
}
