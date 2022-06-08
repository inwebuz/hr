<?php

namespace Database\Seeders;

use App\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GalleriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('galleries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Gallery::create([
            'name' => 'О нас',
            'slug' => Str::slug('О нас'),
        ]);

    }
}
