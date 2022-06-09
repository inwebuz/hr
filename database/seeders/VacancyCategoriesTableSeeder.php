<?php

namespace Database\Seeders;

use App\VacancyCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VacancyCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('vacancy_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            'Менеджмент',
            'Строительство',
            'Логистика',
            'Нефтегаз',
            'Нефтехимия',
            'Энергетика',
            'Металлургия',
            'Банкинг',
            'Медицина',
            'HoReCa',
            'Туризм',
            'IT',
            'PR',
        ];

        foreach ($categories as $key => $name) {
            VacancyCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'order' => $key * 10,
                'status' => 1,
            ]);
        }

    }
}
