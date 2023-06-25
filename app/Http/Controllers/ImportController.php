<?php

namespace App\Http\Controllers;

use App\Imports\ImportStudents;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import()
    {
        $import = new ImportStudents();
        Excel::import($import, request()->file('student_file'));
        $importedData = $import->getImportedData();
        dd($importedData);
    }
}
