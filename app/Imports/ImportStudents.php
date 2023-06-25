<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ImportStudents implements ToCollection
{
    private $importedData;

    public function collection(Collection $rows)
    {
        $this->importedData = $rows->skip(10)->map(function ($row) {
            return $row->slice(1);
        })->filter(function ($row) {
            foreach ($row as $key => $value) {
                if ($value) return $row;
            }
        });
    }

    public function getImportedData()
    {
        return $this->importedData;
    }
}
