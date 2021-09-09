<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Shift;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            [
                'id' => 1,
                'subject_id' => 1,
                'shift_id' => 1,
                'code' => 'MAT01',
                'total' => 30
            ],
            [
                'id' => 2,
                'subject_id' => 1,
                'shift_id' => 2,
                'code' => 'MAT02',
                'total' => 33
            ],
            [
                'id' => 3,
                'subject_id' => 1,
                'shift_id' => 3,
                'code' => 'MAT03',
                'total' => 35
            ],
            [
                'id' => 4,
                'subject_id' => 2,
                'shift_id' => 4,
                'code' => 'DB01',
                'total' => 35
            ],
            [
                'id' => 5,
                'subject_id' => 2,
                'shift_id' => 5,
                'code' => 'DB02',
                'total' => 36
            ],
            [
                'id' => 6,
                'subject_id' => 3,
                'shift_id' => 6,
                'code' => 'DEV01',
                'total' => 36
            ],
            [
                'id' => 7,
                'subject_id' => 4,
                'shift_id' => 7,
                'code' => 'OOP01',
                'total' => 36
            ],
        ];
        Course::query()->insert($courses);
    }
}
