<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TrainorAttendance extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $dateFrom = $request->input('date_from', $today);
        $dateTo = $request->input('date_to', $today);
        $search = $request->input('search', '');
        $entries = $request->input('entries', 5);
        $trainorId = Session::get('trainor_id');

        $attendance = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->whereHas('student', function ($query) use ($search) {
                $query->where('fullname', $this->like, '%' . $search . '%');
            })
            ->with('student:id,fullname')
            ->paginate($entries);

        return view('trainor.reports.index', ['attendance' => $attendance, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }
}
