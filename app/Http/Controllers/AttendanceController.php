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
        if ($student) {

            $timeInAm = strtotime('08:30 AM');
            $timeOutAm = strtotime('12:00 PM');
            $timeInPm = strtotime('01:30 PM');
            $timeOutPm = strtotime('05:00 PM');
            $currentTime = strtotime(now());

            if ($this->hasTakenAttendance($student->id)) {
                $today = Carbon::today()->toDateString();
                $attendance = AttendanceModel::where('student_id', $student->id)
                    ->whereDate('date', $today)
                    ->first();

                // TIME OUT THE STUDENTS IN AM IF ALREADY TIMED IN AND CURRENT TIME IS BETWEEN 12:00 PM - 01:30 PM
                if ($attendance->time_out_am === null && $currentTime >= $timeOutAm && $currentTime < $timeInPm) {
                    $attendance->time_out_am =  Carbon::now()->toTimeString();
                    $attendance->save();
                    return view('attendance.index', ['student' => $student, 'status' => 'You are now timed out']);
                }
                // DISPLAY ERROR MESSAGE IF STUDENT TRIES TO TIME OUT IN LESS THAN 12:00 PM
                if ($attendance->time_out_am === null && $currentTime < $timeOutAm) {
                    return view('attendance.index')->with('status', 'You cannot time out yet in AM');
                }

                // TIME IN THE STUDENT IN PM IF NOT YET TIMED IN AND IF CURRENT TIME IS GREATER THAN 12:00 PM
                if ($attendance->time_in_pm === null && $currentTime >= $timeOutAm) {
                    $attendance->time_in_pm =  Carbon::now()->toTimeString();
                    $attendance->status_pm = $currentTime > $timeInPm ? 'Late' : 'On-Time';
                    $attendance->save();
                    return view('attendance.index', ['student' => $student, 'status' =>  $currentTime > $timeInPm ? 'You timed in Late' : 'You timed in On-Time']);
                }

                // DISPLAY ERROR MESSAGE IF STUDENT ALREADY TIMED OUT IN PM
                if ($attendance->time_out_pm !== null) {
                    return view('attendance.index', ['student' => $student, 'status' => 'You are already timed out in PM']);
                }

                // TIME OUT THE STUDENT IN PM IF STUDENT ALREADY TIMED IN IN PM AND IF CURRENT TIME IS GREATER THAN 05:00 PM 
                if ($attendance->time_in_pm !== null && $currentTime >= $timeOutPm) {
                    $attendance->time_out_pm =  Carbon::now()->toTimeString();
                    $attendance->save();
                    return view('attendance.index', ['student' => $student, 'status' => 'You are now timed out']);
                }
                // DISPLAY ERROR MESSAGE IF STUDENT TRIES TO TIME OUT IN LESS THAN 05:00 PM
                if ($attendance->time_in_pm !== null && $currentTime < $timeOutPm) {
                    return view('attendance.index')->with('status', 'You cannot time out yet in PM');
                }
            } else {
                if ($currentTime < $timeOutAm) {
                    $data = [
                        'student_id' => $student->id,
                        'date' => Carbon::today()->toDateString(),
                        'time_in_am' => Carbon::now()->toTimeString(),
                        'status_am' => $currentTime > $timeInAm ? 'Late' : 'On-Time',
                    ];

                    AttendanceModel::create($data);
                    return view('attendance.index', ['student' => $student, 'status' =>  $currentTime > $timeInAm ? 'You timed in Late' : 'You timed in On-Time',]);
                }


                if ($currentTime >= $timeOutAm) {
                    $data = [
                        'student_id' => $student->id,
                        'date' => Carbon::today()->toDateString(),
                        'time_in_pm' => Carbon::now()->toTimeString(),
                        'status_pm' => $currentTime > $timeInAm ? 'Late' : 'On-Time',
                    ];

                    AttendanceModel::create($data);
                    return view('attendance.index', ['student' => $student, 'status' =>  $currentTime > $timeInAm ? 'You timed in Late' : 'You timed in On-Time',]);
                }
            }
        }
        return view('attendance.index')->with('message', 'Student Not Found');
    }

    private function hasTakenAttendance($id)
    {
        $today = Carbon::today()->toDateString();
        $hasTakenAttendance = AttendanceModel::where('student_id', $id)
            ->whereDate('date', $today)
            ->first();

        return $hasTakenAttendance ? true : false;
    }
}
