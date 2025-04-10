<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendancesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
            */
    public function collection()
    {
        return Attendance::with('student', 'class')
            ->get()
            ->map(function ($attendance) {
                return [
                    'ID' => $attendance->id,
                    'Class Name' => $attendance->class->name ? $attendance->class->name : 'N/A',
                    'Student Name' => $attendance->student->name ? $attendance->student->name : 'N/A',
                    'Date' => $attendance->attendance_date,
                    'Status' => $attendance->attendance_status,
                ];
            });
    }
    public function headings(): array
    {
        return ['ID', 'Class Name', 'Student Name', 'Date', 'Status'];
    }

    public function styles(Worksheet $sheet){
       $sheet->getStyle('1')->getFont()->setBold(true);
       $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
       $sheet->getStyle('A1:E'.$sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}
