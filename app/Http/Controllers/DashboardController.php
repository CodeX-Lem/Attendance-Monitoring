<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\TrainorModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $totalStudents = StudentModel::count();
        $totalTrainors = TrainorModel::count();
        $totalCourses = CourseModel::count();
        $totalAttendanceToday = AttendanceModel::where('date', '=', $today)->count();

        $lateCountAM = AttendanceModel::whereDate('date', $today)
            ->where('status_am', '=', 'Late')
            ->count();

        $lateCountPM = AttendanceModel::whereDate('date', $today)
            ->where('status_pm', '=', 'Late')
            ->count();


        $onTimeCountAM = AttendanceModel::whereDate('date', $today)
            ->where('status_am', '=', 'On-Time')
            ->count();

        $onTimeCountPM = AttendanceModel::whereDate('date', $today)
            ->where('status_pm', '=', 'On-Time')
            ->count();

        $absentCountAM = AttendanceModel::whereDate('date', $today)
            ->where('status_am', '=', 'Absent')
            ->count();

        $absentCountPM = AttendanceModel::whereDate('date', $today)
            ->where('status_Pm', '=', 'Absent')
            ->count();

        $data = ['totalStudents' => $totalStudents, 'totalTrainors' => $totalTrainors, 'totalCourses' => $totalCourses, 'totalAttendanceToday' => $totalAttendanceToday, 'lateCountAM' => $lateCountAM, 'lateCountPM' => $lateCountPM, 'onTimeCountAM' => $onTimeCountAM, 'onTimeCountPM' => $onTimeCountPM, 'absentCountAM' => $absentCountAM, 'absentCountPM' => $absentCountPM];

        return view('admin.dashboard.index', $data);
    }
}