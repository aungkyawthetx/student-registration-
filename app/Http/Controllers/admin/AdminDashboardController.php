<?php

namespace App\Http\Controllers\admin;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\ClassTimeTable;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $studentCount = Student::count();
        $teacherCount = Teacher::count();
        $classCount = ClassTimeTable::count();
        $studentsPerClass = ClassTimeTable::withCount('students')->with('course')->get();
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
            'studentsPerClass',
            'monthlyRegistrations',
        ));
    }
}
