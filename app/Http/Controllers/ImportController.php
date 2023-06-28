<?php

namespace App\Http\Controllers;

use App\Imports\ImportStudents;
use App\Models\StudentModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        try {
            $import = new ImportStudents();
            Excel::import($import, $request->file('student_file'));
            $importedData = $import->getImportedData()->toArray();
            $latestQrCode = $this->generateQrCode();
            $validatedData = [];
            foreach ($importedData as $row) {
                $rules = [
                    '0' => 'nullable',
                    '1' => 'required',
                    '2' => 'required',
                    '3' => 'required',
                    '4' => 'nullable',
                    '5' => 'required',
                    '6' => 'required',
                    '7' => 'required',
                    '8' => 'required',
                    '9' => 'required',
                    '10' => ['required', 'date'],
                    '11' => 'nullable',
                    '12' => 'required',
                    '13' => 'nullable',
                    '14' => 'required',
                    '15' => 'nullable',
                    '16' => 'nullable',
                    '17' => 'required',
                    '18' => 'nullable',
                    '19' => 'nullable',
                    '20' => 'nullable',
                    '21' => 'nullable',
                    '22' => 'nullable',
                    '23' => 'nullable',
                    '24' => 'nullable',
                    '25' => 'nullable',
                ];

                // Validate the imported data using the defined rules
                $validator = Validator::make($row, $rules);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }
                $validatedData[] = [
                    'course_id' => Session::get('courseId'),
                    'qr_code' => $latestQrCode++,
                    'first_name' => $row[2],
                    'middle_name' => $row[3],
                    'last_name' => $row[1],
                    'fullname' => $row[2] . ' ' . $row[3] . ' ' . $row[1],
                    'gender' => $row[9],
                    'dob' => Carbon::createFromFormat('m/d/Y', $row[10])->toDateString(),
                    'civil_status' => $row[12],
                    'nationality' => $row[14],
                    'street' => $row[4],
                    'barangay' => $row[5],
                    'city' => $row[6],
                    'district' => $row[7],
                    'province' => $row[8],
                    'highest_grade_completed' => $row[13],
                    'classification' => 'Unemployed',
                    'training_status' => 'Scholar',
                    'scholarship_type' => $row[17],
                    'training_completed' => false,
                    'accepted' => false,
                    'created_at' => Carbon::today()->toDateString(),
                    'updated_at' => Carbon::today()->toDateString()
                ];
            }

            if (!empty($validatedData)) {
                StudentModel::insert($validatedData);
                Alert::success('success', 'Your excel file has been imported');
            }
        } catch (ValidationException $e) {
            Alert::error('error', 'You have incorrect data format in your excel file');
        } catch (Exception $e) {
            Alert::error('error', $e->getMessage());
        } finally {
            return redirect()->back();
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
}