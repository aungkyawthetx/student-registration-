<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\TeacherCoursesController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\AdminDashboardController;

Route::get('/', function () {
    return view('admin.dashboard');
});

//dashboard
Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

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
    Route::get('/rooms_search', [RoomController::class,'search'])->name('rooms.search');
    //passwords
    Route::get('/change-password/{id}',[PasswordController::class,'ChangePassword'])->name('change-password')->middleware('AdminConfirmPass');
    Route::post('/store-password/{id}',[PasswordController::class,'StorePassword'])->name('store-password');
    Route::post('/verify-password-view', [PasswordController::class, 'verifyAndRedirect'])->name('verify-password-view');
});