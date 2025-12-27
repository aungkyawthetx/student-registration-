<?php

namespace App\Exports;

use App\Models\Enrollment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EnrollmentsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
            */
    public function collection()
    {
        return Enrollment::with('student', 'class')
            ->get()
            ->map(function ($enrollment) {
                return [
                    'ID' => $enrollment->id,
                    'Student Name' => $enrollment->student->name ? $enrollment->student->name : 'N/A',
                    'Class Name' => $enrollment->class->course->name ? $enrollment->class->course->name : 'N/A',
                    'Start Date' => $enrollment->class->start_date ? $enrollment->class->start_date :'N/A',
                    'Time' => $enrollment->class->time ? $enrollment->class->time :'N/A',
                    'Enrollment Date' => $enrollment->date,
                ];
            });
    }
    public function headings(): array
    {
        return ['ID', 'Student Name', 'Class Name', 'Start Date','Time', 'Enrollment Date'];
    }

    public function styles(Worksheet $sheet){
       $sheet->getStyle('1')->getFont()->setBold(true);
       $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
       $sheet->getStyle('A1:F'.$sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}

