<?php

namespace App\Exports;

use App\Models\TeacherCourse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeacherCoursesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
            */
    public function collection()
    {
        return TeacherCourse::with('teacher', 'course')
            ->get()
            ->map(function ($teacher_course) {
                return [
                    'ID' => $teacher_course->id,
                    'Teacher Name' => $teacher_course->teacher->name ? $teacher_course->teacher->name : 'N/A',
                    'Course' => $teacher_course->course->name ? $teacher_course->course->name : 'N/A',
                ];
            });
    }
    public function headings(): array
    {
        return ['ID', 'Teacher Name', 'Course'];
    }

    public function styles(Worksheet $sheet){
       $sheet->getStyle('1')->getFont()->setBold(true);
       $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
       $sheet->getStyle('A1:C'.$sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}

