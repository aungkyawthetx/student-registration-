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
        $headers = ['name', 'duration', 'start_date', 'end_date', 'fees'];

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


        $startDate = Date::excelToDateTimeObject($row['start_date']);
        $endDate = Date::excelToDateTimeObject($row['end_date']);

        if ($startDate && $endDate) {
            $startDateFormatted = $startDate->format('Y-m-d');
            $endDateFormatted = $endDate->format('Y-m-d');
        } else {
            throw ValidationException::withMessages([
                'file' => 'Invalid date format for start_date or end_date in row: ' . json_encode($row)
            ]);
        }

        $fees = isset($row['fees']) && is_numeric($row['fees']) ? $row['fees'] : 0;

        return new Course([
            'name' => $row['name'],
            'duration' => $row['duration'],
            'start_date' => is_numeric($row['start_date'])
                ? Date::excelToDateTimeObject($row['start_date'])->format('Y-m-d')
                : Carbon::parse($row['start_date'])->format('Y-m-d'),
            'end_date' => is_numeric($row['end_date'])
                ? Date::excelToDateTimeObject($row['end_date'])->format('Y-m-d')
                : Carbon::parse($row['end_date'])->format('Y-m-d'),
            'fees' => $row['fees'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}