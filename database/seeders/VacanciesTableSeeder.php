<?php

namespace Database\Seeders;

use App\Vacancy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VacanciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('vacancies')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 1; $i <= 5; $i++) {
            Vacancy::create([
                'name' => $i,
                'slug' => Str::slug($i),
                'image' => 'vacancies/' . $i . '.jpg',
            ]);
        }

    }
}
