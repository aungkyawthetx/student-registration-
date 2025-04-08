<?php

namespace App\Imports;

use App\Models\Course;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CoursesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['name', 'duration', 'start_date', 'end_date', 'fees'];

        foreach ($headers as $header) {
            if (!array_key_exists($header, $row)) {
                throw ValidationException::withMessages([
                    'file' => "Invalid Excel format. Missing required column: $header"
                ]);
            }
        }
        return new Course([
            'name' => $row['name'],
            'duration' => $row['duration'],
            'start_date' => Date::excelToDateTimeObject($row['start_date'])->format('Y-m-d'),
            'end_date' => Date::excelToDateTimeObject($row['end_date'])->format('Y-m-d'),
            'fees' => $row['fees'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
