<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AvatarUserDeleteDefault extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // create image avatar default in storage
    public function run()
    {
        $url = base_path().'/database/default/remove-user.png';

        $contents = file_get_contents($url);
        Storage::put('public/images/avataruserdeletedefault.png', $contents);
    }
}
