<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\TeacherCoursesController;
use App\Http\Controllers\admin\AdminDashboardController;



Route::get('/', function () {
    return view('admin.dashboard');
});

Route::group(['prefix' => 'admin'], function(){
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('classes', ClassController::class);
    Route::resource('teachercourses', TeacherCoursesController::class);
    Route::resource('enrollments', EnrollmentController::class);
});