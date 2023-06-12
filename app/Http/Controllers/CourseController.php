<?php

namespace App\Http\Controllers;

use App\Http\Requests\Courses\StoreCourseRequest;
use App\Http\Requests\Courses\UpdateCourseRequest;
use Illuminate\Http\Request;
use App\Models\CourseModel;
use Exception;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;

class CourseController extends Controller
{
  public function index(Request $request)
  {
    $search = $request->input('search', '');
    $entries = $request->input('entries', 5);

    $courses = CourseModel::with(['trainor' => function ($query) {
      $query->select('id', 'fullname');
    }])
      ->where(function ($query) use ($search) {
        $query->where('course', 'like', '%' . $search . '%')
          ->orWhereHas('trainor', function ($query) use ($search) {
            $query->where('fullname', 'like', '%' . $search . '%');
          });
      })
      ->paginate($entries);
    $currentPage = $courses->currentPage();
    $lastPage = $courses->lastPage();

    if ($currentPage > $lastPage) {
      $redirect = redirect()->route('admin.courses.index', [
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

    $title = 'Delete Course!';
    $text = "Are you sure you want to delete?";
    confirmDelete($title, $text);
    return view('admin.courses.index', ['courses' => $courses]);
  }

  public function create()
  {
    $previous = URL::previous();
    $current = URL::current();
    $previousUrl = $previous == $current ? route('admin.courses.index') : $previous;
    return view('admin.courses.create', ['previousUrl' => $previousUrl]);
  }

  public function store(StoreCourseRequest $request)
  {
    try {
      $validatedData = $request->validated();
      $data = [
        'course' => $validatedData['course'],
        'trainor_id' => $validatedData['trainor_id']
      ];
      CourseModel::create($data);

      Alert::success('Success', 'New Course has been added');
    } catch (Exception $e) {
      Alert::error('Error', 'An error occured while adding the course');
    } finally {
      return redirect($request->input('previous_url'));
    }
  }

  public function show($id)
  {
    $course = CourseModel::findorfail($id);

    $previous = URL::previous();
    $current = URL::current();
    $previousUrl = $previous == $current ? route('admin.courses.index') : $previous;

    return view('admin.courses.edit', ['course' => $course, 'previousUrl' => $previousUrl]);
  }

  public function update(UpdateCourseRequest $request, $id)
  {
    try {
      $validatedData = $request->validated();

      $course = CourseModel::findorfail($id);
      $data = [
        'course' => $validatedData['course'],
        'trainor_id' => $validatedData['trainor_id']
      ];
      $course->update($data);

      Alert::success('Success', 'Course has been updated');
    } catch (Exception $e) {
      Alert::error('Error', 'An error occured while updating the course');
    } finally {
      return redirect($request->input('previous_url'));
    }
  }

  public function destroy($id)
  {
    try {
      $course = CourseModel::findorfail($id);
      $course->delete();

      Alert::success('Success', 'Course has been removed');
    } catch (Exception $e) {
      Alert::error('Error', 'An error occured while removing the course');
    } finally {
      return redirect()->back();
    }
  }
}
