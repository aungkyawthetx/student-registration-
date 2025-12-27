<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
             ['id' => 1, 'name' => 'admin', 'description' => 'all-control'],
             ['id' => 2, 'name' => 'teacher', 'description' => 'teacher control'],
             ['id' => 3, 'name' => 'student', 'description' => 'student-control'],
        ]);
    }
}
