<?php

namespace App\Exports;

use App\Models\ClassTimeTable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClassesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
            */
    public function collection()
    {
        return ClassTimeTable::with('course','room')
            ->get()
            ->map(function ($class) {
                return [
                    'ID' => $class->id,
                    'Course Name' => $class->course->name ? $class->course->name : 'N/A',
                    'Room Name' => $class->room->name ? $class->room->name : 'N/A',
                    'Start Date' => $class->start_date ? $class->start_date : 'N/A',
                    'End Date' => $class->end_date ? $class->end_date : 'N/A',
                    'Time' => $class->time ? $class->time : 'N/A',
                ];
            });
    }
    public function headings(): array
    {
        return ['ID', 'Course Name', 'Room Name', 'Start Date', 'End Date', 'Time'];
    }

    public function styles(Worksheet $sheet){
       $sheet->getStyle('1')->getFont()->setBold(true);
       $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
       $sheet->getStyle('A1:F'.$sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}
