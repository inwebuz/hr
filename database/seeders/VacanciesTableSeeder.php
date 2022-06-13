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

        for ($i = 1; $i <= 100; $i++) {
            Vacancy::create([
                'name' => 'Водитель',
                'slug' => Str::slug('Водитель'),
                'image' => 'vacancies/' . $i . '.jpg',
                'vacancy_category_id' => mt_rand(1, 13),
                'status' => 1,
                'description' => 'Требуется водитель на автомобиль Foton (пассажирский), проживающий в районе (40 лет победы, Кадышева, карасу 6) с далеких районов просьба не беспокоить. Водитель требуется для Развозки молочных продуктов и напитков.',
                'body' => '<h4>Требования:</h4>
                <ul>
                <li>Опыт работы водителем;</li>
                <li>Возраст от 25-35 лет не старше;</li>
                <li>Знание города Ташкента;</li>
                <li>Знание русского языка обязательно.</li>
                </ul>
                <h4>Обязанности:</h4>
                <ul>
                <li>Развоз продукции по налаженному маршруту;</li>
                <li>Соблюдение правил дорожного движения;</li>
                <li>Соблюдение правил внутреннего трудового распорядка;</li>
                <li>Пунктуальный, ответственный.</li>
                </ul>',
            ]);
        }

    }
}
