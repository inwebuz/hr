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
                // 'icon' => 'services/icon-0' . ($key % 3 + 1) . '.png',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.836,8.794a3.179,3.179,0,0,0-3.067-2.226H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832L4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6A3.177,3.177,0,0,0,23.836,8.794Zm-2.343,1.991-4.144,3.029a1,1,0,0,0-.362,1.116L18.562,19.8a1.227,1.227,0,0,1-1.895,1.365l-4.075-3a1,1,0,0,0-1.184,0l-4.075,3a1.227,1.227,0,0,1-1.9-1.365L7.013,14.93a1,1,0,0,0-.362-1.116L2.507,10.785a1.227,1.227,0,0,1,.724-2.217h5.1a1,1,0,0,0,.952-.694l1.55-4.831a1.227,1.227,0,0,1,2.336,0l1.55,4.831a1,1,0,0,0,.952.694h5.1a1.227,1.227,0,0,1,.724,2.217Z"/></svg>',
                'order' => $key * 10,
                'is_featured' => $key < 3 ? 1 : 0,
                'status' => 1,
                'body' => 'Описание страницы ...',
            ]);
        }

    }
}
