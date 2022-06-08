<?php

namespace Database\Seeders;

use App\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('partners')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 1; $i <= 12; $i++) {
            Partner::create([
                'name' => $i,
                'slug' => Str::slug($i),
                'image' => 'partners/' . $i . '.jpg',
            ]);
        }

    }
}
