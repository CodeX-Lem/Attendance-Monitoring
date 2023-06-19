<?php

namespace App\Http\Controllers;

use App\Http\Requests\Students\StoreStudentRequest;
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
        $students = StudentModel::with(['course' => function ($query) {
            $query->select('id', 'course');
        }])
            ->where('fullname', $this->like, "%$search%")
            ->orderBy('id')
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

    public function viewStudent($id)
    {
        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('admin.students.index') : $previous;
        $student = StudentModel::find($id);

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
                'gender' => $request->input('gender'),
                'civil_status' => $request->input('civil_status'),
                'nationality' => $request->input('nationality'),
                'street' => $request->input('street'),
                'barangay' => $request->input('barangay'),
                'city' => $request->input('city'),
                'district' => $request->input('district'),
                'province' => $request->input('province'),
                'scholarship_type' => $request->input('scholarship_type'),
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
