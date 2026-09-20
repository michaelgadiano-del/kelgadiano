<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            ['name' => 'Computer Studies', 'code' => 'CCS'],
            ['name' => 'Business Administration', 'code' => 'CBA'],
            ['name' => 'Education', 'code' => 'COED'],
            ['name' => 'Engineering', 'code' => 'COE'],
        ] as $department) {
            Department::create($department);
        }
    }
}
