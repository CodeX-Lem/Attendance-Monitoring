<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use App\Models\StudentModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('attendance.index');
    }

    public function scan(Request $request)
    {
        $qrCode = $request->input('qr_code');

        $student = StudentModel::where('qr_code', $qrCode)->first();

        if (!$student) return view('attendance.index')->with('status', 'Student Not Found');

        if ($this->hasTakenAttendance($student->course_id)) {
            return $this->updateAttendance($student);
        } else {
            $this->createAttendanceSheet($student->course_id);
            return $this->updateAttendance($student);
        }
    }

    private function updateAttendance($student)
    {
        $today = Carbon::today()->toDateString();
        $timeInAm = strtotime('08:30 AM');
        $timeOutAm = strtotime('12:00 PM');
        $timeInPm = strtotime('01:30 PM');
        $timeOutPm = strtotime('05:00 PM');
        $currentTime = strtotime(now());

        $attendance = AttendanceModel::where('student_id', $student->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            $this->insertStudentAttendance($student->id);
            $attendance = AttendanceModel::where('student_id', $student->id)
                ->whereDate('date', $today)
                ->first();
        }

        // TIME IN THE STUDENT IN AM IF NOT TIMED IN AND CURRENT TIME IS LESS THAN 12:00 PM
        if ($attendance->time_in_am == null && $currentTime < $timeOutAm) {
            $status = '';
            $timeInAmAbsent = strtotime(Carbon::createFromTimestamp($timeOutAm)->subHour()->format('h:i:s A'));
            if ($currentTime < $timeInAm) {
                $status = 'On-Time';
            } elseif ($currentTime >= $timeInAmAbsent) {
                $status = 'Absent';
            } else {
                $status = 'Late';
            }
            $data = [
                'time_in_am' => Carbon::now()->toTimeString(),
                'status_am' => $status
            ];
            $attendance->update($data);
            return view('attendance.index', ['student' => $student, 'status' => 'You are now timed in ' . $status, 'timeInStatus' => $status]);
        }

        // DISPLAY ERROR MESSAGE IF STUDENT TRIES TO TIME OUT IN AM IN LESS THAN 12:00 PM
        if ($attendance->time_in_am != null & $attendance->time_out_am == null & $currentTime < $timeOutAm) {
            return view('attendance.index')->with('status', 'You cannot time out yet in AM');
        }

        // TIME OUT THE STUDENT IN AM IF ALREADY TIMED IN AND CURRENT TIME IS BETWEEN 12:00 PM AND 01:30 PM
        if ($attendance->time_in_am != null && $attendance->time_out_am == null && $currentTime >= $timeOutAm && $currentTime < $timeInPm) {
            $data = [
                'time_out_am' => Carbon::now()->toTimeString(),
            ];
            $attendance->update($data);
            return view('attendance.index', ['student' => $student, 'status' => 'You are now timed out']);
        }


        // DISPLAY ERROR MESSAGE IF STUDENT HAS ALREADY TIMED OUT IN PM
        if ($attendance->time_in_pm != null && $attendance->time_out_pm != null) {
            return view('attendance.index', ['student' => $student, 'status' => 'You already timed out in PM']);
        }

        // TIME IN THE STUDENT IN PM IF NOT TIMED IN AND CURRENT TIME IS GREATER THAN 12:00 PM
        if ($attendance->time_in_pm == null && $currentTime >= $timeOutAm) {
            $status = '';
            $timeInPmAbsent = strtotime(Carbon::createFromTimestamp($timeOutPm)->subHour()->format('h:i:s A'));
            if ($currentTime < $timeInPm) {
                $status = 'On-Time';
            } elseif ($currentTime >= $timeInPmAbsent) {
                $status = 'Absent';
            } else {
                $status = 'Late';
            }
            $data = [
                'time_in_pm' => Carbon::now()->toTimeString(),
                'status_pm' => $status
            ];
            $attendance->update($data);
            return view('attendance.index', ['student' => $student, 'status' => 'You are now timed in ' . $status, 'timeInStatus' => $status]);
        }

        // DISPLAY ERROR MESSAGE IF STUDENT TRIES TO TIME OUT IN LESS THAN 05:00 PM
        if ($attendance->time_in_pm != null && $attendance->time_out_pm == null && $currentTime < $timeOutPm) {
            return view('attendance.index')->with('status', 'You cannot time out yet in PM');
        }

        if ($attendance->time_in_pm != null && $attendance->time_out_pm == null && $currentTime >= $timeOutPm) {
            $data = [
                'time_out_pm' => Carbon::now()->toTimeString(),
            ];
            $attendance->update($data);
            return view('attendance.index', ['student' => $student, 'status' => 'You are now timed out']);
        }
    }

    private function createAttendanceSheet($courseId)
    {
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now();
        $data = [];
        $students = StudentModel::where('course_id', '=', $courseId)->get();

        foreach ($students as $student) {
            $data[] = [
                'student_id' => $student->id,
                'date' => $today,
                'status_am' => 'Absent',
                'status_pm' => 'Absent',
                'created_at' => $currentTime,
                'updated_at' => $currentTime
            ];
        }

        AttendanceModel::insert($data);
    }

    private function insertStudentAttendance($studentId)
    {
        $today = Carbon::today()->toDateString();
        $data = [
            'student_id' => $studentId,
            'date' => $today,
            'status_am' => 'Absent',
            'status_pm' => 'Absent',
        ];

        AttendanceModel::create($data);
    }

    private function hasTakenAttendance($courseId)
    {
        $today = Carbon::today()->toDateString();
        $record = AttendanceModel::whereHas('student', function ($query) use ($courseId) {
            $query->where('course_id', '=', $courseId);
        })
            ->whereDate('date', $today)
            ->count();

        return $record > 0 ? true : false;
    }
}
