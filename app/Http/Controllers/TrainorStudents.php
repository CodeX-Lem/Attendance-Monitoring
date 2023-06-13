<?php

namespace App\Http\Controllers;

use App\Models\StudentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TrainorStudents extends Controller
{
    public function index(Request $request)
    {
        $title = 'Delete Student!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        $search = $request->input('search', '');
        $entries = $request->input('entries', 5);

        $trainorId = Session::get('trainor_id');

        $students = StudentModel::with(['course' => function ($query) use ($trainorId) {
            $query->select('id', 'course', 'trainor_id')->where('trainor_id', '=', $trainorId);
        }])
            ->where('fullname', 'like', '%' . $search . '%')
            ->paginate($entries);

        $currentPage = $students->currentPage();
        $lastPage = $students->lastPage();

        if ($currentPage > $lastPage) {
            $redirect = redirect()->route('admin.students.index', [
                'page' => $lastPage,
                'entries' => $entries,
                'search' => $search,
            ]);


            if ($request->session()->has('type') && $request->session()->has('message')) {
                $type = $request->session()->get('type');
                $message = $request->session()->get('message');
                $redirect = $redirect->with('type', $type)->with('message', $message);
            }

            return $redirect;
        }

        return view('admin.students.index', ['students' => $students]);
    }
}
