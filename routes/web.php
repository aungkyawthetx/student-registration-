<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\TeacherCoursesController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin.dashboard');
});

//auth
Route::get('/register', [RegisterController::class,'register'])->name('register');
Route::post('/register', [RegisterController::class,'store'])->name('register.store');
Route::get('/login', [LoginController::class,'login'])->name('login');
Route::post('/login', [LoginController::class,'store'])->name('login.store');
Route::post('/logout', [LoginController::class,'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    //dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    //users
    Route::resource('users', AdminUserController::class);
    Route::get('/users_search', [AdminUserController::class,'search'])->name('users.search');
    //roles
    Route::resource('roles', RoleController::class);
    Route::get('/roles_search', [RoleController::class,'search'])->name('roles.search');    
    //students
    Route::resource('students', StudentController::class);
    Route::get('/students_search', [StudentController::class, 'search'])->name('students.search');
    //teachers
    Route::resource('teachers', TeacherController::class);
    Route::get('/teachers_search', [TeacherController::class,'search'])->name('teachers.search');
    //courses
    Route::resource('courses', CourseController::class);
    Route::get('/courses_search', [CourseController::class,'search'])->name('courses.search');
    //rooms
    Route::resource('rooms', RoomController::class);
});