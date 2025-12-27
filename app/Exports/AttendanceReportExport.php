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
    protected $classId;
    protected $month;

    public function __construct($classId = null, $month = null)
    {
        $this->classId = $classId;
        $this->month = $month;
    }

    public function collection()
    {
        $query = DB::table('attendances')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->join('classes', 'attendances.class_id', '=', 'classes.id')
            ->join('courses', 'classes.course_id', '=', 'courses.id')
            ->select(
                'students.name as student_name', 
                'courses.name as class_name',
                'classes.start_date as start_date',
                'classes.end_date as end_date',
                'classes.time as time',
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'P' THEN 1 END), 0) AS Present"),
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'A' THEN 1 END), 0) AS Absent"),
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'L' THEN 1 END), 0) AS `Leave`")
            )
            ->groupBy('student_name', 'class_name', 'start_date', 'end_date', 'time')
            ->orderBy('student_name','asc');

        if ($this->classId) {
            $query->where('attendances.class_id', $this->classId);
        }

        if ($this->month) {
            $month = $this->month;
            $query->whereMonth('attendances.attendance_date', '=', date('m', strtotime($month)))
                  ->whereYear('attendances.attendance_date', '=', date('Y', strtotime($month)));
        }

        return $query->get();
    }
    public function headings(): array
    {
        return ['Student Name', 'Course Name', 'Start Date', 'End Date', 'Time', 'Present','Absent','Leave'];
    }

    public function styles(Worksheet $sheet){
       $sheet->getStyle('1')->getFont()->setBold(true);
       $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
       $sheet->getStyle('A1:H'.$sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

       $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($sheet->getCell('F' . $row)->getValue() === null || $sheet->getCell('C' . $row)->getValue() === '') {
                $sheet->setCellValue('F' . $row, 0);
            }

            if ($sheet->getCell('G' . $row)->getValue() === null || $sheet->getCell('D' . $row)->getValue() === '') {
                $sheet->setCellValue('G' . $row, 0);
            }

            if ($sheet->getCell('H' . $row)->getValue() === null || $sheet->getCell('E' . $row)->getValue() === '') {
                $sheet->setCellValue('H' . $row, 0);
            }
        }
    }
}
