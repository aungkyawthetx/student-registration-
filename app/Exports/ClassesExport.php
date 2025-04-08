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
        return ClassTimeTable::with('room')
            ->get()
            ->map(function ($class) {
                return [
                    'ID' => $class->id,
                    'Room Name' => $class->room->name ? $class->room->name : 'N/A',
                    'Date' => $class->date,
                    'Start Time' => $class->start_time ? $class->start_time : 'N/A',
                    'End Time' => $class->end_time ? $class->end_time : 'N/A',
                    'End Date' => $class->end_date ? $class->end_date : 'N/A',
                ];
            });
    }
    public function headings(): array
    {
        return ['ID', 'Room Name', 'Date', 'Start Time', 'End Time', 'End Date'];
    }

    public function styles(Worksheet $sheet){
       $sheet->getStyle('1')->getFont()->setBold(true);
       $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
       $sheet->getStyle('A1:F'.$sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}
