<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ImportStudents implements ToCollection
{
    private $importedData;

    public function collection(Collection $rows)
    {
        $data =   $this->importedData = $rows->skip(10)->map(function ($row) {
            return $row->slice(1);
        });
        // dd($data);

        // You can perform additional processing or validation on the imported data here
    }

    public function getImportedData()
    {
        return $this->importedData;
    }

    // /**
    //  * @param array $row
    //  *
    //  * @return \Illuminate\Database\Eloquent\Model|null
    //  */
    // public function model(array $row)
    // {
    //     return new StudentModel([
    //         'first_name' => $row['first_name'],
    //         'middle_name' => $row['middle_name'],
    //         'last_name' => $row['last_name'],
    //     ]);

    //     return new StudentModel([
    //         'course_id' => 1,
    //         'qr_code' => 2023100,
    //         'first_name' => $row[2],
    //         'middle_name' => $row[3],
    //         'last_name' => $row[1],
    //         'fullname' => $row[2] . ' ' . $row[3] . ' ' . $row[1],
    //         'street' => $row[4],
    //         'barangay' => $row[5],
    //         'city' => $row[6],
    //         'district' => $row[7],
    //         'province' => $row[8],
    //         'gender' => $row[9],
    //         'dob' => $row[10],
    //         'civil_status' => $row[12],
    //         'highest_grade_completed' => $row[13],
    //         'nationality' => $row[14],
    //         'classification' => 'Unemployed',
    //         'training_status' => 'Scholar',
    //         'scholarship_type' => $row[17],
    //         'training_completed' => false,
    //         'accepted' => false,
    //     ]);
    // }
}
