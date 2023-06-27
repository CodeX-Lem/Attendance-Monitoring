<?php

namespace App\Http\Controllers;

use App\Http\Requests\Students\ChangeProfileRequest;
use App\Http\Requests\Students\StoreStudentRequest;
use App\Http\Requests\Students\UpdateStudentRequest;
use App\Models\StudentModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
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
        $training_completed = $request->input('training_completed', 0);
        $trainorId = Session::get('trainor_id');

        $students = StudentModel::whereHas('course', function ($query) use ($trainorId) {
            $query->select('id', 'course', 'trainor_id')->where('trainor_id', '=', $trainorId);
        })
            ->select('id', 'course_id', 'qr_code', 'fullname', 'city', 'training_status', 'accepted')
            ->where('fullname', $this->like, "%$search%")
            ->where('training_completed', '=', $training_completed)
            ->orderBy('id')
            ->paginate($entries);

        $currentPage = $students->currentPage();
        $lastPage = $students->lastPage();

        if ($currentPage > $lastPage) {
            $redirect = redirect()->route('trainor.students.index', [
                'page' => $lastPage,
                'entries' => $entries,
                'search' => $search,
                'training_completed' => $training_completed,
            ]);


            if ($request->session()->has('type') && $request->session()->has('message')) {
                $type = $request->session()->get('type');
                $message = $request->session()->get('message');
                $redirect = $redirect->with('type', $type)->with('message', $message);
            }

            return $redirect;
        }

        return view('trainor.students.index', ['students' => $students, 'training_completed' => $training_completed]);
    }

    public function viewStudent($id)
    {
        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('trainor.students.index') : $previous;
        $student = StudentModel::find($id);

        $title = 'Reject Student?';
        $text = "Student's data will be deleted after confirming";
        confirmDelete($title, $text);

        return view('trainor.students.view-student', ['previousUrl' => $previousUrl, 'student' => $student]);
    }

    public function create()
    {
        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('trainor.students.index') : $previous;
        return view('trainor.students.create', ['previousUrl' => $previousUrl]);
    }

    public function store(StoreStudentRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $qr_code = $this->generateQrCode();
            $base64Image = null;
            if ($request->hasFile('image')) $base64Image = base64_encode(file_get_contents($request->file('image')->path()));


            $data = [
                'course_id' => $validatedData['course_id'],
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'fullname' => $validatedData['first_name'] . ' ' . $validatedData['middle_name'] . ' ' . $validatedData['last_name'],
                'dob' => date_create($validatedData['dob']),
                'gender' => $validatedData['gender'],
                'civil_status' => $validatedData['civil_status'],
                'nationality' => $validatedData['nationality'],
                'street' => $request->input('street'),
                'barangay' => $validatedData['barangay'],
                'city' => $validatedData['city'],
                'district' => $validatedData['district'],
                'province' => $validatedData['province'],
                'scholarship_type' => $validatedData['scholarship_type'],
                'highest_grade_completed' => $request->input('highest_grade_completed'),
                'classification' => 'Unemployed',
                'training_status' => 'Scholar',
                'scholarship_type' => $validatedData['scholarship_type'],
                'training_completed' => false,
                'accepted' => false,

                'qr_code' => $qr_code,
                'image' => $base64Image,
            ];

            StudentModel::create($data);

            Alert::success('Success', 'New Student has been added');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while adding the student');
        } finally {
            return redirect($request->input('previous_url'));
        }
    }

    public function destroy($id)
    {
        try {
            $student = StudentModel::findorfail($id);
            $student->delete();

            Alert::success('Success', 'Student Has Been Removed');
            return redirect()->back();
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while removing the student');
            return redirect()->back();
        }
    }

    public function reject($id)
    {
        try {
            $student = StudentModel::findorfail($id);
            $student->delete();

            Alert::success('Success', 'Student Has Been Removed');
            return redirect()->route('trainor.students.index');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while removing the student');
            return redirect()->route('trainor.students.index');
        }
    }

    protected function generateQrCode()
    {
        $currentYear = date('Y');
        $latestStudent = StudentModel::whereYear('created_at', $currentYear)
            ->orderByDesc('id')->first();

        if (!$latestStudent) {
            $qr_code = $currentYear  . "001";
            return $qr_code;
        } else {
            $qr_code = $latestStudent->qr_code;
            $qr_code = (int)$qr_code + 1;
            return $qr_code;
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

    public function show($id)
    {
        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('trainor.students.index') : $previous;
        $student = StudentModel::find($id);

        return view('trainor.students.edit', ['student' => $student, 'previousUrl' => $previousUrl]);
    }

    public function update(UpdateStudentRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $student = StudentModel::find($id);

            $data = [
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'fullname' => $validatedData['first_name'] . ' ' . $validatedData['middle_name'] . ' ' . $validatedData['last_name'],
                'dob' => date_create($validatedData['dob']),
                'gender' => $validatedData['gender'],
                'civil_status' => $validatedData['civil_status'],
                'nationality' => $validatedData['nationality'],
                'street' => $request->input('street'),
                'barangay' => $validatedData['barangay'],
                'city' => $validatedData['city'],
                'district' => $validatedData['district'],
                'province' => $validatedData['province'],
                'scholarship_type' => $validatedData['scholarship_type'],
                'highest_grade_completed' => $request->input('highest_grade_completed'),
                'scholarship_type' => $validatedData['scholarship_type'],
                'training_completed' => $validatedData['training_completed'],
            ];
            $student->update($data);

            Alert::success('Success', 'Student has been updated');
        } catch (Exception $e) {
            dd($e);
            Alert::error('Error', 'An error occured while updating the student');
        } finally {
            return redirect($request->input('previous_url'));
        }
    }

    public function changeProfile(ChangeProfileRequest $request, $id)
    {
        $student = StudentModel::find($id);
        $base64Image = base64_encode(file_get_contents($request->file('image')->path()));

        $data = ['image' => $base64Image];
        $student->update($data);

        return redirect()->back();
    }
}
