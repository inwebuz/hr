<?php

namespace Database\Seeders;

use App\Page;
use App\Review;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('reviews')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Factory::create();

        for ($i = 0; $i < 2; $i++) {
            Review::create([
                'reviewable_type' => Page::class,
                'reviewable_id' => 1,
                'name' => 'Максим',
                'position' => 'директор студии',
                'body' => 'Руководство компании INWEB выражает благодарность компании HR Baraka Group за квалифицированный подбор персонала. Мы искали системного администратора, но получилось так, что у нас некому оценить квалификацию и мы решили обратиться в агентство. Довольны всем, от согласования договора, до выхода кандидата.',
                'status' => 1,
                'rating' => 5,
            ]);
        }

    }
}
