<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
            */
    public function collection(){
        return DB::table('attendances')
        ->join('students', 'attendances.student_id', '=', 'students.id')
        ->join('courses', 'attendances.course_id', '=', 'courses.id')
        ->select(
            'students.name as student_name', 
            'courses.name as course_name', 
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'P' THEN 1 END), 0) AS Present"),
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'A' THEN 1 END), 0) AS Absent"),
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'L' THEN 1 END), 0) AS `Leave`")
        )
        ->groupBy('student_name', 'course_name')
        ->get();
    }
    public function headings(): array
    {
        return ['Student Name', 'Course Name', 'Present','Absent','Leave'];
    }

    public function styles(Worksheet $sheet){
       $sheet->getStyle('1')->getFont()->setBold(true);
       $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
       $sheet->getStyle('A1:E'.$sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

       $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($sheet->getCell('C' . $row)->getValue() === null || $sheet->getCell('C' . $row)->getValue() === '') {
                $sheet->setCellValue('C' . $row, 0);
            }

            if ($sheet->getCell('D' . $row)->getValue() === null || $sheet->getCell('D' . $row)->getValue() === '') {
                $sheet->setCellValue('D' . $row, 0);
            }

            if ($sheet->getCell('E' . $row)->getValue() === null || $sheet->getCell('E' . $row)->getValue() === '') {
                $sheet->setCellValue('E' . $row, 0);
            }
        }
    }
}
