<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shifts = [
            [
                'id' => 1,
                'day' => 2,
                'time_start' => 1,
                'time_finish' => 3
            ],
            [
                'id' => 2,
                'day' => 2,
                'time_start' => 4,
                'time_finish' => 5
            ],
            [
                'id' => 3,
                'day' => 2,
                'time_start' => 6,
                'time_finish' => 8
            ],
            [
                'id' => 4,
                'day' => 3,
                'time_start' => 1,
                'time_finish' => 3
            ],
            [
                'id' => 5,
                'day' => 3,
                'time_start' => 4,
                'time_finish' => 5
            ],
            [
                'id' => 6,
                'day' => 3,
                'time_start' => 6,
                'time_finish' => 8
            ],
            [
                'id' => 7,
                'day' => 4,
                'time_start' => 1,
                'time_finish' => 3
            ],
        ];
        Shift::query()->insert($shifts);
    }
}
