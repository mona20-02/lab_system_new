<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $departments = [
            'Information Technology', 'Medicine', 'Engineering', 'Law'
        ];

        foreach($departments as $department) {
            Department::create([
                'name' => $department,
            ]);
        }
    }
}
