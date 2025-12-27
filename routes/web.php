<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ReportController;
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

//dashboard
Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth');
Route::get('/get-students/{classId}', [AttendanceController::class, 'getStudentByClass']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::get('/classes/{id}', [ClassController::class, 'show']);
Route::get('/teachers/{id}', [TeacherController::class, 'show']);

//auth
Route::get('/register', [RegisterController::class,'register'])->name('register');
Route::post('/register', [RegisterController::class,'store'])->name('register.store');
Route::get('/login', [LoginController::class,'login'])->name('login');
Route::post('/login', [LoginController::class,'store'])->name('login.store');
Route::post('/logout', [LoginController::class,'logout'])->name('logout');

//password reset from mail
Route::get('/forgot-pass',[PasswordController::class,'forgotPass'])->name('forgot-pass');
Route::post('/reset-pass',[PasswordController::class,'resetPass'])->name('reset-pass');
Route::get('/change-pass/{token}',[PasswordController::class,'changePass'])->name('change-pass');
Route::post('/store-pass',[PasswordController::class,'storePass'])->name('store-pass');


Route::prefix('admin')->middleware(['auth'])->group(function () {
    //dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    //users
    Route::delete('/users/{id}/destroy_all',[AdminUserController::class,'destroyall'])->name('users.destroy-all');
    Route::resource('users', AdminUserController::class);
    Route::get('/users_search', [AdminUserController::class,'search'])->name('users.search');
    Route::get('/users_export',[AdminUserController::class,'export'])->name('users.export');
    Route::post('/users_import',[AdminUserController::class,'import'])->name('users.import');
    //roles
    Route::delete('/roles/destroy_all',[RoleController::class,'destroyall'])->name('roles.destroy-all');
    Route::resource('roles', RoleController::class);
    Route::get('/roles_search', [RoleController::class,'search'])->name('roles.search');    
    Route::get('/roles_export',[RoleController::class,'export'])->name('roles.export');
    Route::post('/roles_import',[RoleController::class,'import'])->name('roles.import');
    //students
    Route::delete('/students/destroy_all',[StudentController::class,'destroyall'])->name('students.destroy-all');
    Route::resource('students', StudentController::class);
    Route::get('/students_search', [StudentController::class, 'search'])->name('students.search');
    Route::get('/students_export',[StudentController::class,'export'])->name('students.export');
    Route::post('/students_import',[StudentController::class,'import'])->name('students.import');
    //teachers
    Route::delete('/teachers/destroy_all',[TeacherController::class,'destroyall'])->name('teachers.destroy-all');
    Route::resource('teachers', TeacherController::class);
    Route::get('/teachers_search', [TeacherController::class,'search'])->name('teachers.search');
    Route::get('/teachers_export',[TeacherController::class,'export'])->name('teachers.export');
    Route::post('/teachers_import',[TeacherController::class,'import'])->name('teachers.import');
    //courses
    Route::delete('/courses/destroy_all',[CourseController::class,'destroyall'])->name('courses.destroy-all');
    Route::resource('courses', CourseController::class);
    Route::get('/courses_search', [CourseController::class,'search'])->name('courses.search');
    Route::get('/courses_export',[CourseController::class,'export'])->name('courses.export');
    Route::post('/courses_import',[CourseController::class,'import'])->name('courses.import');
    //rooms
    Route::delete('/rooms/destroy_all',[RoomController::class,'destroyall'])->name('rooms.destroy-all');
    Route::resource('rooms', RoomController::class);
    Route::get('/rooms_search', [RoomController::class,'search'])->name('rooms.search');
    Route::get('/rooms_export',[RoomController::class,'export'])->name('rooms.export');
    Route::post('/rooms_import',[RoomController::class,'import'])->name('rooms.import');
    //enrollment
    Route::delete('/enrollments/destroy_all',[EnrollmentController::class,'destroyall'])->name('enrollments.destroy-all');
    Route::resource('enrollments', EnrollmentController::class);
    Route::get('/enrollments_search', [EnrollmentController::class,'search'])->name('enrollments.search');
    Route::get('/enrollments_export',[EnrollmentController::class,'export'])->name('enrollments.export');
    Route::post('/enrollments_import',[EnrollmentController::class,'import'])->name('enrollments.import');
    //attendance
    Route::delete('/attendances/destroy_all',[AttendanceController::class,'destroyall'])->name('attendances.destroy-all');
    Route::resource('attendances', AttendanceController::class);
    Route::get('/attendances_search', [AttendanceController::class,'search'])->name('attendances.search');
    Route::get('/attendances_export',[AttendanceController::class,'export'])->name('attendances.export');
    Route::post('/attendances_import',[AttendanceController::class,'import'])->name('attendances.import');
    //teachercourses
    Route::delete('/teachercourses/destroy_all',[TeacherCoursesController::class,'destroyall'])->name('teachercourses.destroy-all');
    Route::resource('teachercourses', TeacherCoursesController::class);
    Route::get('/teachercourses_search', [TeacherCoursesController::class,'search'])->name('teachercourses.search');
    Route::get('/teachercourses_export',[TeacherCoursesController::class,'export'])->name('teachercourses.export');
    Route::post('/teachercourses_import',[TeacherCoursesController::class,'import'])->name('teachercourses.import');
    //classes
    Route::delete('/classes/destroy_all',[ClassController::class,'destroyall'])->name('classes.destroy-all');
    Route::resource('classes', ClassController::class);
    Route::get('/classes_search', [ClassController::class,'search'])->name('classes.search');
    Route::get('/classes_export',[ClassController::class,'export'])->name('classes.export');
    Route::post('/classes_import',[ClassController::class,'import'])->name('classes.import');
    //passwords
    Route::get('/change-password/{id}',[PasswordController::class,'ChangePassword'])->name('change-password')->middleware('AdminConfirmPass');
    Route::post('/store-password/{id}',[PasswordController::class,'StorePassword'])->name('store-password');
    Route::post('/verify-password-view', [PasswordController::class, 'verifyAndRedirect'])->name('verify-password-view');

    //reports
    Route::get('/enrollment-report', [ReportController::class, 'enrollmentReport'])->name('enrollment.report');
    Route::get('/attendance-report', [ReportController::class, 'attendanceReport'])->name('attendance.report');
    Route::get('/enrollment-report/export',[ReportController::class,'exportEnrollmentReport'])->name('enrollment-report.export');
    Route::get('/attendance-report/export',[ReportController::class,'exportAttendanceReport'])->name('attendance-report.export');
    Route::get('/enrollment-report_search', [ReportController::class,'searchEnrollmentReport'])->name('enrollment-report.search');
    Route::get('/attendance-report_search', [ReportController::class,'searchAttendanceReport'])->name('attendance-report.search');
    Route::get('/enrollment-report/student/{id}', [ReportController::class, 'showStudentDetails']);
    Route::get('/enrollment-report/class/{id}', [ReportController::class, 'showClassDetails']);
    Route::get('/attendance-report/student/{id}', [ReportController::class, 'showStudentDetails']);
    Route::get('/attendance-report/class/{id}', [ReportController::class, 'showClassDetails']);
});