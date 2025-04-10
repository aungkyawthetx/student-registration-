<?php

namespace App\Imports;

use App\Models\Course;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
class CoursesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['name', 'fees'];

        foreach ($headers as $header) {
            if (!array_key_exists($header, $row)) {
                throw ValidationException::withMessages([
                    'file' => "Invalid Excel format. Missing required column: $header"
                ]);
            }
        }

        if (empty($row['name'])) {
            throw ValidationException::withMessages([
                'file' => 'Name column cannot be empty for row: ' . json_encode($row)
            ]);
        }

        $fees = isset($row['fees']) && is_numeric($row['fees']) ? $row['fees'] : 0;

        return new Course([
            'name' => $row['name'],
            'fees' => $row['fees'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}