<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

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
            ->join('students', 'attendance.student_id', '=', 'students.id')
            ->join('courses', 'students.course_id', '=', 'courses.id')
            ->OrderBy('date')
            ->orderBy('courses.course')
            ->orderBy('students.fullname')
            ->paginate($entries);

        return view('trainor.reports.index', ['attendance' => $attendance, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }

    public function exportPdf(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $dateFrom = $request->input('date_from') ?? $today;
        $dateTo = $request->input('date_to') ?? $today;
        $search = $request->input('search', '');
        $trainorId = Session::get('trainor_id');

        $attendance = AttendanceModel::whereHas('student.course', function ($query) use ($trainorId) {
            $query->where('trainor_id', '=', $trainorId);
        })
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->whereHas('student', function ($query) use ($search) {
                $query->where('fullname', $this->like, '%' . $search . '%');
            })
            ->with(['student', 'student.course'])
            ->join('students', 'attendance.student_id', '=', 'students.id')
            ->join('courses', 'students.course_id', '=', 'courses.id')
            ->OrderBy('date')
            ->orderBy('courses.course')
            ->orderBy('students.fullname')
            ->get();

        $pdf = new Dompdf();
        $pdf->loadHtml(View::make('pdf.report', ['attendance' => $attendance, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'search' => $search])->render());
        $pdf->setPaper('Legal', 'portrait');

        $options = new Options();
        $options->set('isPhpEnabled', true);
        $pdf->setOptions($options);
        $pdf->render();

        $totalPages = $pdf->getCanvas()->get_page_count();
        $pdf->getCanvas()->page_text(550, 975, 'Page {PAGE_NUM} of {PAGE_COUNT}', null, 8, array(0, 0, 0));

        return $pdf->stream('attendance-report.pdf');

        return view('pdf.report', ['attendance' => $attendance, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'search' => $search]);
    }
}
