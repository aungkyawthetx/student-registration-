<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['student_name', 'gender', 'nrc', 'dob', 'email', 'phone', 'address', 'parent_info'];

        foreach ($headers as $header) {
            if (!array_key_exists($header, $row)) {
                throw ValidationException::withMessages([
                    'file' => "Invalid Excel format. Missing required column: $header"
                ]);
            }
        }
        return new Student([
            'name' => $row['student_name'],
            'gender' => $row['gender'],
            'nrc' => $row['nrc'],
            'dob' => Date::excelToDateTimeObject($row['dob'])->format('Y-m-d'),
            'email' => $row['email'],
            'phone' => $row['phone'],
            'address' => $row['address'],
            'parent_info' => $row['parent_info'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
