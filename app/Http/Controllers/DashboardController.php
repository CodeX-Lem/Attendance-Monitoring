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

        $lateCount = AttendanceModel::whereDate('date', $today)
            ->where(function ($query) {
                $query->where('status_am', 'Late')
                    ->orWhere('status_pm', 'Late');
            })
            ->count();

        $onTimeCount = AttendanceModel::whereDate('date', $today)
            ->where(function ($query) {
                $query->where('status_am', 'On-Time')
                    ->orWhere('status_pm', 'On-Time');
            })
            ->count();

        $data = ['totalStudents' => $totalStudents, 'totalTrainors' => $totalTrainors, 'totalCourses' => $totalCourses, 'totalAttendanceToday' => $totalAttendanceToday, 'lateCount' => $lateCount, 'onTimeCount' => $onTimeCount];

        return view('admin.dashboard.index', $data);
    }
}
