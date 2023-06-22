<?php

namespace App\Http\Controllers;

use App\Http\Requests\Students\StoreStudentRequest;
use App\Http\Requests\Students\UpdateStudentRequest;
use App\Models\StudentModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Delete Student!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        $search = $request->input('search', '');
        $entries = $request->input('entries', 5);
        $training_completed = $request->input('training_completed', 0);
        $course_id = $request->input('course_id', '');
        $students = StudentModel::whereHas('course', function ($query) use ($course_id) {
            if ($course_id == '') {
                $query->select('id', 'course');
            } else {
                $query->select('id', 'course')->where('id', '=', $course_id);
            }
        })
            ->where('fullname', $this->like, "%$search%")
            ->where('training_completed', '=', $training_completed)
            ->orderBy('id')
            ->paginate($entries);

        $currentPage = $students->currentPage();
        $lastPage = $students->lastPage();

        if ($currentPage > $lastPage) {
            $redirect = redirect()->route('admin.students.index', [
                'page' => $lastPage,
                'entries' => $entries,
                'search' => $search,
                'training_completed' => $training_completed,
                'selectedCourse' => $course_id,
            ]);


            if ($request->session()->has('type') && $request->session()->has('message')) {
                $type = $request->session()->get('type');
                $message = $request->session()->get('message');
                $redirect = $redirect->with('type', $type)->with('message', $message);
            }

            return $redirect;
        }

        return view('admin.students.index', ['students' => $students, 'training_completed' => $training_completed, 'selectedCourse' => $course_id]);
    }

    public function viewStudent($id)
    {
        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('admin.students.index') : $previous;
        $student = StudentModel::find($id);

        $title = 'Reject Student?';
        $text = "Student's data will be deleted after confirming";
        confirmDelete($title, $text);

        return view('admin.students.view-student', ['previousUrl' => $previousUrl, 'student' => $student]);
    }

    public function create()
    {
        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('admin.students.index') : $previous;
        return view('admin.students.create', ['previousUrl' => $previousUrl]);
    }

    public function store(StoreStudentRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $qr_code = $this->generateQrCode();
            $imageName = null;
            if ($request->hasFile('image')) {
                $fileName = $request->file('image')->getClientOriginalName();
                $imageName = time() . '-' . $fileName;
                $request->file('image')->move(public_path('storage/images'), $imageName);
            }


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
                'image' => $imageName,
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

    public function reject($id)
    {
        try {
            $student = StudentModel::findorfail($id);
            $student->delete();

            if (Storage::disk('public')->exists('images/' .  $student->image)) {
                Storage::disk('public')->delete('images/' . $student->image);
            }

            Alert::success('Success', 'Student Has Been Removed');
            return redirect()->route('admin.students.index');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while removing the student');
            return redirect()->route('admin.students.index');
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
        $previousUrl = $previous == $current ? route('admin.students.index') : $previous;
        $student = StudentModel::find($id);

        return view('admin.students.edit', ['student' => $student, 'previousUrl' => $previousUrl]);
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
}
