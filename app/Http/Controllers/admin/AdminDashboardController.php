<?php

namespace App\Http\Controllers\admin;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\ClassTimeTable;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $studentCount = Student::count();
        $teacherCount = Teacher::count();
        $classCount = ClassTimeTable::count();

        $studentsPerCourse = Course::withCount('students')->get();
        $monthlyRegistrations = Student::selectRaw('COUNT(*) as count, MONTH(created_at) as month')->groupBy('month')->get();
            
        return view('admin.dashboard', compact(
            'studentCount',
            'teacherCount',
            'classCount',
            'studentsPerCourse',
            'monthlyRegistrations',
        ));
    }
}
