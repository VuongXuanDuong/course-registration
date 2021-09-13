<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subs = [
            [
                'id' => 1,
                'name' => 'Room 1'
            ],
            [
                'id' => 2,
                'name' => 'Room 2'
            ],
            [
                'id' => 3,
                'name' => 'Room 3'
            ],
            [
                'id' => 4,
                'name' => 'Room 4'
            ]
        ];
        Room::query()->insert($subs);
    }
}
