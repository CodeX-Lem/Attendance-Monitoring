<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainorAttendance extends Controller
{
    public function index()
    {
        return view('trainor.reports.index');
    }
}
