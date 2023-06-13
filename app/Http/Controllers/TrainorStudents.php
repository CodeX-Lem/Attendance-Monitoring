<?php

namespace App\Http\Controllers;

use App\Models\StudentModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

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

        $students = StudentModel::whereHas('course', function ($query) use ($trainorId) {
            $query->select('id', 'course', 'trainor_id')->where('trainor_id', '=', $trainorId);
        })
            ->where('fullname', 'like', '%' . $search . '%')
            ->paginate($entries);

        $currentPage = $students->currentPage();
        $lastPage = $students->lastPage();

        if ($currentPage > $lastPage) {
            $redirect = redirect()->route('trainor.students.index', [
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

        return view('trainor.students.index', ['students' => $students]);
    }

    public function destroy($id)
    {
        try {
            $student = StudentModel::findorfail($id);
            $student->delete();

            if (Storage::disk('public')->exists('images/' .  $student->image)) {
                Storage::disk('public')->delete('images/' . $student->image);
            }

            Alert::success('Success', 'Student Has Been Removed');
            return redirect()->back();
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while removing the student');
            return redirect()->back();
        }
    }

    protected function generateQrCode()
    {
        $currentYear = date('Y');
        $latestStudent = StudentModel::whereYear('created_at', $currentYear)
            ->orderByDesc('created_at')->first();

        if (!$latestStudent) {
            $qr_code = $currentYear  . "001";
            return $qr_code;
        } else {
            $qr_code = $latestStudent->qr_code;
            $qr_code = (int)$qr_code + 1;
            return $qr_code;
        }
    }

    public function markAsCompleted($id)
    {
        try {
            $student = StudentModel::findorfail($id);
            $data = ['training_completed' => true];
            $student->update($data);
            Alert::success('Success', "Student's training has been marked as completed");
        } catch (Exception $e) {
            Alert::error('Error', "An error occured while marking the student's training as completed");
        } finally {
            return redirect()->back();
        }
    }

    public function markAsOnGoing($id)
    {
        try {
            $student = StudentModel::findorfail($id);
            $data = ['training_completed' => false];
            $student->update($data);
            Alert::success('Success', "Student's training has been marked as not yet completed");
        } catch (Exception $e) {
            Alert::error('Error', "An error occured while marking the student's training as not yet completed");
        } finally {
            return redirect()->back();
        }
    }


    public function markAsAccepted($id)
    {
        try {
            $student = StudentModel::findorfail($id);
            $accepted = $student->accepted;
            $data = ['accepted' => $accepted ? false : true];
            $student->update($data);

            if (!$accepted) {
                Alert::success('Success', "Student has been accepted");
            }
        } catch (Exception $e) {
            Alert::error('Error', "An error occured");
        } finally {
            return redirect()->back();
        }
    }
}