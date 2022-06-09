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

        $services = [
            'Подбор персонала',
            'Адаптация персонала',
            'Массовый подбор',
            'Технический подбор',
            'Executive Search',
            'IT-подбор',
            'Корпоративная культура',
            'Оценка сотрудников',
            'Обучение сотрудников',
            'Карьерный коучинг',
            'HR-бренд',
        ];

        foreach ($services as $key => $name) {
            Service::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'image' => 'services/0' . ($key % 3 + 1) . '.jpg',
                'icon' => 'services/icon-0' . ($key % 3 + 1) . '.png',
                'order' => $key * 10,
                'is_featured' => $key < 3 ? 1 : 0,
                'status' => 1,
            ]);
        }

    }
}
