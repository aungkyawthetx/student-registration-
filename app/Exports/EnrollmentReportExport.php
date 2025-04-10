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

class EnrollmentReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
            */
    public function collection(){
        return DB::table('enrollments')
        ->join('students', 'enrollments.student_id', '=', 'students.id')
        ->join('classes', 'enrollments.class_id', '=', 'classes.id')
        ->select(
            'students.name as student_name', 
            'classes.name as class_name',
            'enrollments.date as enrollment_date',
            'classes.start_date as start_date',
            'classes.time as time',
            'classes.fees as fees'
        )
        ->groupBy('student_name', 'class_name','enrollment_date','start_date', 'time', 'fees')
        ->orderBy('enrollment_date','desc')
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
    }
}
