<?php

namespace Database\Seeders;

use App\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('services')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 1; $i <= 3; $i++) {
            Service::create([
                'name' => $i,
                'slug' => Str::slug($i),
                'image' => 'services/' . $i . '.jpg',
            ]);
        }

    }
}
