<?php

namespace App\Imports;

use App\Models\ClassTimeTable;
use App\Models\Room;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ClassesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $headers = ['room_name', 'date', 'start_time', 'end_time', 'end_date'];

        foreach ($headers as $header) {
            if (!array_key_exists($header, $row)) {
                throw ValidationException::withMessages([
                    'file' => "Invalid Excel format. Missing required column: $header"
                ]);
            }
        }
        
        $room = Room::where('name', $row['room_name'])->first();
        if (!$room) {
            throw ValidationException::withMessages([
                'file' => "Invalid room specified: " . $row['room_name']
            ]);
        }
        return new ClassTimeTable([
            'room_id' => $room ? $room->id : null,
            'date' => Date::excelToDateTimeObject($row['date'])->format('Y-m-d'),
            'start_time' => $this->formatExcelTime($row['start_time']),
            'end_time' => $this->formatExcelTime($row['end_time']),
            'end_date' => Date::excelToDateTimeObject($row['end_date'])->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function formatExcelTime($excelTime)
    {
        if (is_numeric($excelTime)) {
            $dateTime = Date::excelToDateTimeObject($excelTime);
            return $dateTime->format('h:i A');
        }

        try {
            return \Carbon\Carbon::parse($excelTime)->format('h:i A');
        } catch (\Exception $e) {
            return null;
        }
    }
}
