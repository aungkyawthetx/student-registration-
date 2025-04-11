<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class EnrollmentReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $courseName;
    protected $month;

    public function __construct($courseName = null, $month = null)
    {
        $this->courseName = $courseName;
        $this->month = $month;
    }

    public function collection(): Collection
    {
        $query = DB::table('enrollments')
            ->join('students', 'enrollments.student_id', '=', 'students.id')
            ->join('classes', 'enrollments.class_id', '=', 'classes.id')
            ->join('courses', 'classes.course_id', '=', 'courses.id')
            ->select(
                'students.name as student_name', 
                'courses.name as class_name',
                'enrollments.date as enrollment_date',
                'classes.start_date as start_date',
                'classes.time as time',
                'courses.fees as fees'
            );

        if ($this->courseName) {
            $query->where('courses.name', $this->courseName);
        }

        if ($this->month) {
            $query->whereMonth('enrollments.date', '=', date('m', strtotime($this->month)))
                  ->whereYear('enrollments.date', '=', date('Y', strtotime($this->month)));
        }

        return $query
            ->groupBy('student_name', 'class_name', 'enrollment_date', 'start_date', 'time', 'fees')
            ->orderBy('enrollment_date', 'desc')
            ->get();
    }
    public function headings(): array
    {
        return ['Student Name', 'Enrollment Date', 'Course Name' ,'Start Date', 'Time', 'Fees'];
    }

    public function styles(Worksheet $sheet){
       $sheet->getStyle('1')->getFont()->setBold(true);
       $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
       $sheet->getStyle('A1:F'.$sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
       $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($sheet->getCell('F' . $row)->getValue() === null || $sheet->getCell('C' . $row)->getValue() === '') {
                $sheet->setCellValue('F' . $row, 0);
            }
        }
    }
}
