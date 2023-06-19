<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminReports extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $dateFrom = $request->input('date_from', $today);
        $dateTo = $request->input('date_to', $today);
        $search = $request->input('search', '');
        $entries = $request->input('entries', 5);

        $attendance = AttendanceModel::whereBetween('date', [$dateFrom, $dateTo])
            ->whereHas('student', function ($query) use ($search) {
                $query->where('fullname', $this->like, '%' . $search . '%')
                    ->orWhereHas('course', function ($query) use ($search) {
                        $query->where('course', $this->like, '%' . $search . '%');
                    });
            })
            ->with(['student', 'student.course'])
            ->OrderBy('date')
            ->paginate($entries);

        return view('admin.reports.index', ['attendance' => $attendance, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }
}
