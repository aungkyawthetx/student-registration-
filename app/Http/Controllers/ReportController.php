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
        ->join('courses', 'attendances.course_id', '=', 'courses.id')
        ->select(
            'students.name as student_name', 
            'courses.name as course_name', 
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'P' THEN 1 END), 0) AS Present"),
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'A' THEN 1 END), 0) AS Absent"),
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'L' THEN 1 END), 0) AS `Leave`")
        )
        ->groupBy('student_name', 'course_name')
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
            ->join('courses', 'attendances.course_id', '=', 'courses.id')
            ->select(
                'students.name as student_name', 
                'courses.name as course_name', 
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'P' THEN 1 END), 0) AS Present"),
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'A' THEN 1 END), 0) AS Absent"),
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'L' THEN 1 END), 0) AS `Leave`")
            )
            ->when($searchData, function ($query, $searchData) {
                $query->where('students.name', 'LIKE', '%'.$searchData.'%');
            })
            ->when($searchData, function ($query, $searchData) {
                $query->orWhere('courses.name', 'LIKE', '%'.$searchData.'%');
            })
            ->when($searchData, function ($query, $searchData) {
                $query->orWhere('attendances.attendance_date', 'LIKE', '%'.$searchData.'%');
            })
            ->groupBy('students.name', 'courses.name')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles = Role::all();
            return view('admin.attendance.report', compact('attendanceReport', 'roles'));
        }
    }

    public function enrollmentReport(){
        $enrollmentReport = DB::table('enrollments')
        ->join('students', 'enrollments.student_id', '=', 'students.id')
        ->join('courses', 'enrollments.course_id', '=', 'courses.id')
        ->select(
            'students.name as student_name', 
            'courses.name as course_name',
            'enrollments.date as enrollment_date',
            'courses.duration as duration',
            'courses.start_date as start_date',
            'courses.fees as fees'
        )
        ->groupBy('student_name', 'course_name','enrollment_date','duration','start_date','fees')
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
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->select(
                'students.name as student_name', 
                'courses.name as course_name',
                'enrollments.date as enrollment_date',
                'courses.duration as duration',
                'courses.start_date as start_date',
                'courses.fees as fees'
            )
            ->when($searchData, function ($query, $searchData) {
                $query->where('students.name', 'LIKE', '%'.$searchData.'%');
            })
            ->when($searchData, function ($query, $searchData) {
                $query->orWhere('courses.name', 'LIKE', '%'.$searchData.'%');
            })
            ->when($searchData, function ($query, $searchData) {
                $query->orWhere('enrollments.date', 'LIKE', '%'.$searchData.'%');
            })
            ->when($searchData, function ($query, $searchData) {
                $query->orWhere('courses.duration', 'LIKE', '%'.$searchData.'%');
            })
            ->groupBy('student_name', 'course_name', 'enrollment_date', 'duration', 'start_date', 'fees')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles=Role::all();
            return view('admin.enrollment.report', compact('enrollmentReport','roles'));
        }
    }
}
