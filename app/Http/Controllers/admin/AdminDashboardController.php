<?php

namespace App\Http\Controllers\admin;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\ClassTimeTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $studentCount = Student::count();
        $teacherCount = Teacher::count();
        $classCount = ClassTimeTable::count();
        $studentsPerCourse = Course::withCount('students')->get();
        $rawData = DB::table('enrollments')
        ->selectRaw('MONTH(date) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month');
            
        $monthlyRegistrations = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRegistrations[] = $rawData->has($i) ? $rawData[$i]->count : 0;
        }
        return view('admin.dashboard', compact(
            'studentCount',
            'teacherCount',
            'classCount',
            'studentsPerCourse',
            'monthlyRegistrations',
        ));
    }
}
