<?php

namespace App\Http\Controllers;

use App\Http\Requests\Trainors\StoreTrainorRequest;
use App\Http\Requests\Trainors\UpdateTrainorRequest;
use App\Models\TrainorModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;

class TrainorController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Delete Trainor!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        $search = $request->input('search', '');
        $entries = $request->input('entries', 5);
        $trainors = TrainorModel::where('fullname', 'like', '%' . $search . '%')->paginate($entries);

        $currentPage = $trainors->currentPage();
        $lastPage = $trainors->lastPage();
        if ($currentPage > $lastPage) {
            $redirect = redirect()->route('admin.trainors.index', [
                'page' => $lastPage,
                'search' => $search,
                'entries' => $entries
            ]);

            if (session()->has('type') && session()->has('message')) {
                $type = session()->get('type');
                $message = session()->get('message');
                $redirect = $redirect->with('type', $type)->with('message', $message);
            }

            return $redirect;
        }
        return view('admin.trainors.index', ['trainors' => $trainors]);
    }

    public function create()
    {
        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('admin.trainors.index') : $previous;
        return view('admin.trainors.create', ['previousUrl' => $previousUrl]);
    }

    public function store(StoreTrainorRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $data = [
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'fullname' => $validatedData['first_name'] . ' ' . $validatedData['middle_name'] . ' ' . $validatedData['last_name'],
                'gender' => $validatedData['gender'],
                'contact_no' => $request->input('contact_no'),
                'address' => $request->input('address'),
            ];

            TrainorModel::create($data);

            Alert::success('Success', 'New trainor has been added');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while removing the trainor');
        } finally {
            return redirect($request->input('previous_url'));
        }
    }

    public function show($id)
    {
        $trainor = TrainorModel::findorfail($id);

        $previous = URL::previous();
        $current = URL::current();
        $previousUrl = $previous == $current ? route('admin.trainors.index') : $previous;

        return view('admin.trainors.edit', ['trainor' => $trainor, 'previousUrl' => $previousUrl]);
    }

    public function update(UpdateTrainorRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $trainor = TrainorModel::findorfail($id);

            $data = [
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'fullname' => $validatedData['first_name'] . ' ' . $validatedData['middle_name'] . ' ' . $validatedData['last_name'],
                'gender' => $validatedData['gender'],
                'contact_no' => $request->input('contact_no'),
                'address' => $request->input('address'),
            ];

            $trainor->update($data);
            Alert::success('Success', 'Trainor has been updated');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while updating the trainor');
        } finally {
            return redirect($request->input('previous_url'));
        }
    }

    public function destroy($id)
    {
        try {
            $trainor = TrainorModel::findorfail($id);
            $trainor->delete();

            Alert::success('Success', 'Trainor has been removed');
        } catch (Exception $e) {
            Alert::error('Error', 'An error occured while removing the trainor');
        } finally {
            return redirect()->back();
        }
    }
}
