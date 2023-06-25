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
        })
            ->whereDate('date', $today)
            ->count();

        $lateCountAM = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })
            ->whereDate('date', $today)
            ->where('status_am', '=', 'Late')
            ->count();

        $lateCountPM = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })
            ->whereDate('date', $today)
            ->where('status_pm', '=', 'Late')
            ->count();

        $onTimeCountAM = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })
            ->whereDate('date', $today)
            ->where('status_am', '=', 'On-Time')
            ->count();

        $onTimeCountPM = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })
            ->whereDate('date', $today)
            ->where('status_pm', '=', 'On-Time')
            ->count();

        $absentCountAM = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })
            ->whereDate('date', $today)
            ->where('status_am', '=', 'Absent')
            ->count();

        $absentCountPM = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })
            ->whereDate('date', $today)
            ->where('status_pm', '=', 'Absent')
            ->count();

        $data = ['totalStudents' => $totalStudents, 'totalAttendanceToday' => $totalAttendanceToday,  'lateCountAM' => $lateCountAM, 'lateCountPM' => $lateCountPM, 'onTimeCountAM' => $onTimeCountAM, 'onTimeCountPM' => $onTimeCountPM, 'absentCountAM' => $absentCountAM, 'absentCountPM' => $absentCountPM];

        return view('trainor.dashboard.index', $data);
    }
}