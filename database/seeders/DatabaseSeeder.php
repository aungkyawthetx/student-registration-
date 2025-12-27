<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Room;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\TeacherCourse;
use App\Models\ClassTimeTable;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Role::factory(10)->create();
        // Attendance::factory(10)->create();
        // ClassTimeTable::factory(10)->create();
        // Course::factory(10)->create();
        // Enrollment::factory(10)->create();
        // Room::factory(10)->create();
        // Student::factory(10)->create();
        // Teacher::factory(10)->create();
        // TeacherCourse::factory(10)->create();
        $this->call(RoleSeeder::class);


        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
