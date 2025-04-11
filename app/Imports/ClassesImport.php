<?php

namespace App\Imports;

use App\Models\ClassTimeTable;
use App\Models\Course;
use App\Models\Room;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ClassesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['course_name', 'room_name', 'start_date', 'end_date', 'time'];

        foreach ($headers as $header) {
            if (!array_key_exists($header, $row)) {
                throw ValidationException::withMessages([
                    'file' => "Invalid Excel format. Missing required column: $header"
                ]);
            }
        }
        $course = Course::where('name', $row['course_name'])->first();
        if (!$course) {
            throw ValidationException::withMessages([
                'file' => "Invalid course specified: " . $row['course_name']
            ]);
        }
        $room = Room::where('name', $row['room_name'])->first();
        if (!$room) {
            throw ValidationException::withMessages([
                'file' => "Invalid room specified: " . $row['room_name']
            ]);
        }
        // $startDate = Date::excelToDateTimeObject($row['start_date']);
        // $endDate = Date::excelToDateTimeObject($row['end_date']);

        // if ($startDate && $endDate) {
        //     $startDateFormatted = $startDate->format('Y-m-d');
        //     $endDateFormatted = $endDate->format('Y-m-d');
        // } else {
        //     throw ValidationException::withMessages([
        //         'file' => 'Invalid date format for start_date or end_date in row: ' . json_encode($row)
        //     ]);
        // }
        return new ClassTimeTable([
            'course_id' => $course ? $course->id : null,
            'room_id' => $room ? $room->id : null,
            'start_date' => is_numeric($row['start_date'])
                ? Date::excelToDateTimeObject($row['start_date'])->format('Y-m-d')
                : Carbon::parse($row['start_date'])->format('Y-m-d'),
            'end_date' => is_numeric($row['end_date'])
            ? Date::excelToDateTimeObject($row['end_date'])->format('Y-m-d')
            : Carbon::parse($row['end_date'])->format('Y-m-d'),
            'time' => $row['time'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // private function formatExcelTime($excelTime)
    // {
    //     if (is_numeric($excelTime)) {
    //         $dateTime = Date::excelToDateTimeObject($excelTime);
    //         return $dateTime->format('h:i A');
    //     }

    //     try {
    //         return Carbon::parse($excelTime)->format('h:i A');
    //     } catch (\Exception $e) {
    //         return null;
    //     }
    // }
}
