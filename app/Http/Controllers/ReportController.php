<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceReportExport;
use App\Exports\EnrollmentReportExport;
use App\Models\Attendance;
use App\Models\ClassTimeTable;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function attendanceReport(Request $request)
    {
        $query = DB::table('attendances')
        ->join('students', 'attendances.student_id', '=', 'students.id')
        ->join('classes', 'attendances.class_id', '=', 'classes.id')
        ->join('courses', 'classes.course_id', '=', 'courses.id')
        ->select(
            DB::raw("ROW_NUMBER() OVER (ORDER BY students.name ASC) AS id"),
            'attendances.student_id as student_id',
            'students.name as student_name', 
            'attendances.class_id as class_id',
            'courses.name as class_name',
            'classes.start_date as start_date',
            'classes.end_date as end_date',
            'classes.time as time',
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'P' THEN 1 END), 0) AS Present"),
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'A' THEN 1 END), 0) AS Absent"),
            DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'L' THEN 1 END), 0) AS `Leave`")
        )
        ->groupBy('student_id', 'student_name', 'class_id', 'class_name', 'start_date', 'end_date', 'time')
        ->orderBy('student_name','asc');
        
        if ($request->filled('class_id')) {
            $query->where('attendances.class_id', $request->class_id);
        }

        if ($request->filled('month')) {
            $month = $request->month;
            $query->whereMonth('attendances.attendance_date', '=', date('m', strtotime($month)))
                    ->whereYear('attendances.attendance_date', '=', date('Y', strtotime($month)));
        }

        $attendanceReport = $query->paginate(5);

        $classes = ClassTimeTable::with('course')->get();
        $roles = Role::all();
        return view('admin.attendance.report', compact('attendanceReport','roles','classes'));
    }

    public function exportAttendanceReport(Request $request)
    {
        $classId = $request->input('class_id');
        $month = $request->input('month');
        return Excel::download(
            new AttendanceReportExport($classId, $month),
            'attendance-report.xlsx'
        );
    }

    public function searchAttendanceReport(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('attendance.report');
        } else {
            $query = DB::table('attendances')
            ->join('students', 'attendances.student_id', '=', 'students.id')
            ->join('classes', 'attendances.class_id', '=', 'classes.id')
            ->join('courses', 'classes.course_id', '=', 'courses.id')
            ->select(
                DB::raw("ROW_NUMBER() OVER (ORDER BY students.name ASC) AS id"),
                'attendances.student_id as student_id',
                'students.name as student_name', 
                'attendances.class_id as class_id',
                'courses.name as class_name',
                'classes.start_date as start_date',
                'classes.end_date as end_date',
                'classes.time as time',
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'P' THEN 1 END), 0) AS Present"),
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'A' THEN 1 END), 0) AS Absent"),
                DB::raw("COALESCE(COUNT(CASE WHEN attendance_status = 'L' THEN 1 END), 0) AS `Leave`")
            )
            ->groupBy('student_id', 'student_name',  'class_name', 'start_date', 'end_date', 'time')
            ->when($searchData, function ($query, $searchData) {
                $query->where('students.name', 'LIKE', '%'.$searchData.'%');
            })
            ->orderBy('student_name','asc');
            if ($request->filled('class_id')) {
                $query->where('attendances.class_id', $request->class_id);
            }
    
            if ($request->filled('month')) {
                $month = $request->month;
                $query->whereMonth('attendances.attendance_date', '=', date('m', strtotime($month)))
                        ->whereYear('attendances.attendance_date', '=', date('Y', strtotime($month)));
            }
    
            $attendanceReport = $query->paginate(5)->appends(['search_data' => $search]);
    
            $classes = ClassTimeTable::with('course')->get();
            $roles = Role::all();
            return view('admin.attendance.report', compact('attendanceReport','roles','classes'));
        }
    }

    public function showStudentDetails($id){
        $student = Student::with('classes')->findOrFail($id);
        return response()->view('admin.details.studentdetails', compact('student'));
    }
    public function showClassDetails($id){
        $class = ClassTimeTable::with('course')->findOrFail($id);
        return view('admin.details.classdetails', compact('class'));
    }

    public function enrollmentReport(Request $request)
    {
        $query = DB::table('enrollments')
            ->join('students', 'enrollments.student_id', '=', 'students.id')
            ->join('classes', 'enrollments.class_id', '=', 'classes.id')
            ->join('courses', 'classes.course_id', '=', 'courses.id')
            ->select(
                DB::raw("ROW_NUMBER() OVER (ORDER BY students.name ASC) AS id"),
                'enrollments.student_id as student_id',
                'enrollments.class_id as class_id',
                'students.name as student_name', 
                'courses.name as class_name',
                'enrollments.date as enrollment_date',
                'classes.start_date as start_date',
                'classes.time as time',
                'courses.fees as fees'
            );

        if ($request->filled('month')) {
            $query->whereRaw("DATE_FORMAT(enrollments.date, '%Y-%m') = ?", [$request->month]);
        }

        if ($request->filled('course_name')) {
            $query->where('courses.name', $request->course_name);
        }

        $enrollmentReport = $query
            ->groupBy('student_id', 'class_id', 'student_name', 'class_name', 'enrollment_date', 'start_date', 'time', 'fees')
            ->orderBy('enrollment_date', 'desc')
            ->paginate(5);

        $roles = Role::all();
        $courses = DB::table('courses')->select('name')->get();

        return view('admin.enrollment.report', compact('enrollmentReport', 'roles', 'courses'));
    }


    public function exportEnrollmentReport(Request $request){
        $courseName = $request->input('course_name');
        $month = $request->input('month');
        return Excel::download(
            new EnrollmentReportExport($courseName, $month),
            'enrollment-report.xlsx'
        );
    }

    public function searchEnrollmentReport(Request $request)
    {
        $search = $request->input('search_data');

        if (empty($search)) {
            return redirect()->route('enrollment.report');
        }

        $enrollmentReport = DB::table('enrollments')
            ->join('students', 'enrollments.student_id', '=', 'students.id')
            ->join('classes', 'enrollments.class_id', '=', 'classes.id')
            ->join('courses', 'classes.course_id', '=', 'courses.id')
            ->select(
                DB::raw("ROW_NUMBER() OVER (ORDER BY students.name ASC) AS id"),
                'enrollments.student_id as student_id',
                'enrollments.class_id as class_id',
                'students.name as student_name',
                'courses.name as class_name',
                'enrollments.date as enrollment_date',
                'classes.start_date as start_date',
                'classes.time as time',
                'courses.fees as fees'
            )
            ->where('students.name', 'LIKE', '%' . $search . '%')
            ->groupBy('student_id', 'class_id', 'student_name', 'class_name', 'enrollment_date', 'start_date', 'time', 'fees')
            ->orderBy('enrollment_date', 'desc')
            ->paginate(5)
            ->appends(['search_data' => $search]);

        $roles = Role::all();
        $courses = DB::table('courses')->select('name')->distinct()->get(); // Ensure dropdowns still show

        return view('admin.enrollment.report', compact('enrollmentReport', 'roles', 'courses'));
    }
}
