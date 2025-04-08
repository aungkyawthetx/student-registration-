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
        return Enrollment::with('student', 'course')
            ->get()
            ->map(function ($enrollment) {
                return [
                    'ID' => $enrollment->id,
                    'Student Name' => $enrollment->student->name ? $enrollment->student->name : 'N/A',
                    'Course Name' => $enrollment->course->name ? $enrollment->course->name : 'N/A',
                    'Enrollment Date' => $enrollment->date,
                ];
            });
    }
    public function headings(): array
    {
        return ['ID', 'Student Name', 'Course Name', 'Enrollment Date'];
    }

    public function styles(Worksheet $sheet){
       $sheet->getStyle('1')->getFont()->setBold(true);
       $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
       $sheet->getStyle('A1:D'.$sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}

