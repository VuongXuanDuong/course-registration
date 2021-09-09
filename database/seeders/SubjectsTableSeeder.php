<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
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
                'name' => 'Toán Cao Cấp 1'
            ],
            [
                'id' => 2,
                'name' => 'Cơ Sở Dữ Liệu'
            ],
            [
                'id' => 3,
                'name' => 'Lập Trình Nâng Cao'
            ],
            [
                'id' => 4,
                'name' => 'Lập Trình Hướng Đối Tượng'
            ]
        ];
        Subject::query()->insert($subs);
    }
}
