<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceReportExport;
use App\Exports\EnrollmentReportExport;
use App\Models\Attendance;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function attendanceReport()
    {
        $attendanceReport = DB::table('attendances')
        ->join('students', 'attendances.student_id', '=', 'students.id')
        ->join('classes', 'attendances.class_id', '=', 'classes.id')
        ->select(
            'students.name as student_name', 
            'classes.name as class_name', 
            'classes.time as time',
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'P' THEN 1 END), 0) AS Present"),
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'A' THEN 1 END), 0) AS Absent"),
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'L' THEN 1 END), 0) AS `Leave`")
        )
        ->groupBy('student_name', 'class_name','time')
        ->orderBy('student_name','asc')
        ->paginate(5);

        $roles = Role::all();
        return view('admin.attendance.report', compact('attendanceReport','roles'));
    }

    public function exportAttendanceReport(){
        return Excel::download(new AttendanceReportExport(), 'attendance_report.xlsx');
    }

    public function searchAttendanceReport(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('attendance.report');
        } else {
            $attendanceReport = DB::table('attendances')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->join('classes', 'attendances.class_id', '=', 'classes.id')
            ->select(
                'students.name as student_name', 
                'classes.name as class_name', 
                'classes.time as time',
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'P' THEN 1 END), 0) AS Present"),
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'A' THEN 1 END), 0) AS Absent"),
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'L' THEN 1 END), 0) AS `Leave`")
            )
            ->when($searchData, function ($query, $searchData) {
                $query->where('students.name', 'LIKE', '%'.$searchData.'%');
            })
            ->when($searchData, function ($query, $searchData) {
                $query->orWhere('classes.name', 'LIKE', '%'.$searchData.'%');
            })
            ->when($searchData, function ($query, $searchData) {
                $query->orWhere('attendances.attendance_date', 'LIKE', '%'.$searchData.'%');
            })
            ->groupBy('students.name', 'classes.name','classes.time')
            ->orderBy('student_name','asc')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles = Role::all();
            return view('admin.attendance.report', compact('attendanceReport', 'roles'));
        }
    }

    public function enrollmentReport(){
        $enrollmentReport = DB::table('enrollments')
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
        ->paginate(5);

        $roles=Role::all();
        return view('admin.enrollment.report', compact('enrollmentReport','roles'));
    }

    public function exportEnrollmentReport(){
        return Excel::download(new EnrollmentReportExport(), 'enrollment_report.xlsx');
    }

    public function searchEnrollmentReport(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('enrollment.report');
        } else {
            $enrollmentReport = DB::table('enrollments')
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
            ->when($searchData, function ($query, $searchData) {
                $query->where('students.name', 'LIKE', '%'.$searchData.'%');
            })
            ->when($searchData, function ($query, $searchData) {
                $query->orWhere('classes.name', 'LIKE', '%'.$searchData.'%');
            })
            ->when($searchData, function ($query, $searchData) {
                $query->orWhere('enrollments.date', 'LIKE', '%'.$searchData.'%');
            })
            ->groupBy('student_name', 'class_name', 'enrollment_date', 'start_date', 'time', 'fees')
            ->orderBy('enrollment_date','desc')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles=Role::all();
            return view('admin.enrollment.report', compact('enrollmentReport','roles'));
        }
    }
}
