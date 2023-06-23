<?php

namespace App\Http\Controllers;

use App\Imports\ImportStudents;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import()
    {
        Excel::import(new ImportStudents, request()->file('student_file'));
        return redirect()->back();
    }
}
