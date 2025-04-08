<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
            */
    public function collection()
    {
        return Student::get()
            ->map(function ($student) {
                return [
                    'ID' => $student->id,
                    'Name' => $student->name,
                    'Gender' => $student->gender,
                    'NRC' => $student->nrc,
                    'DOB' => $student->dob,
                    'Email' => $student->email,
                    'Phone' => $student->phone,
                    'Address' => $student->address,
                    'Parent Info' => $student->parent_info,
                ];
            });
    }
    public function headings(): array
    {
        return ['ID', 'Student Name', 'Gender', 'NRC', 'DOB', 'Email', 'Phone', 'Address', 'Parent Info'];
    }

    public function styles(Worksheet $sheet){
       $sheet->getStyle('1')->getFont()->setBold(true);
       $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
       $sheet->getStyle('A1:G'.$sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}

