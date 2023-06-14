<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use App\Models\StudentModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TrainorDashboard extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        $trainorId = Session::get('trainor_id');
        $totalStudents = StudentModel::whereHas('course', function ($query) use ($trainorId) {
            $query->select('id', 'course', 'trainor_id')->where('trainor_id', '=', $trainorId);
        })->count();

        $totalAttendanceToday = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })->count();

        $lateCount = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })
            ->whereDate('date', $today)
            ->where(function ($query) {
                $query->where('status_am', 'Late')
                    ->orWhere('status_pm', 'Late');
            })
            ->count();

        $onTimeCount = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })
            ->whereDate('date', $today)
            ->where(function ($query) {
                $query->where('status_am', 'On-Time')
                    ->orWhere('status_pm', 'On-Time');
            })
            ->count();

        $attendance = AttendanceModel::with('student')
            ->whereHas('student.course', function ($query) use ($trainorId) {
                $query->where('trainor_id', '=', $trainorId);
            })
            ->whereDate('date', $today)->get();

        $data = ['totalStudents' => $totalStudents, 'totalAttendanceToday' => $totalAttendanceToday, 'lateCount' => $lateCount, 'onTimeCount' => $onTimeCount, 'attendance' => $attendance];

        return view('trainor.dashboard.index', $data);
    }
}
