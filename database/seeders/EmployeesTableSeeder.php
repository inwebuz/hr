<?php

namespace Database\Seeders;

use App\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('employees')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $firstname = ['Ульмас', 'Анастасия', 'Насиба', 'Эльвина', 'Виталий', 'Людмила', 'Дмитрий', 'Умида', 'Елена', ];
        $lastname = ['Абдусаттаров', 'Абдуллаева', 'Бахтиярова', 'Бикиняева', 'Богатов', 'Гердман', 'Горбунов', 'Дашкинова', 'Латыпова', ];
        // $positions = ['Глава отдела обучения', 'Абдуллаева', 'Бахтиярова', 'Бикиняева', 'Богатов', 'Гердман', 'Горбунов', 'Дашкинова', 'Латыпова', ];

        for ($i = 0; $i < 9; $i++) {
            Employee::create([
                'last_name' => $lastname[$i],
                'first_name' => $firstname[$i],
                'patronymic' => '',
                'position' => 'Глава отдела обучения',
                'image' => 'employees/0' . ($i + 1) . '.jpg',
                'status' => 1,
                'order' => $i * 10,
                'description' => 'Мы с радостью беремся за проект любой сложности. Ведь наш девиз – искусство достигать невозможное!',
                'body' => '<h4>Опыт работы</h4><p>Мы предоставляем полный спектр HR-услуг от рекрутмента и кадрового консалтинга до решения нестандартных задач и выполнения множества других функций.</p><p>Нам заслуженно доверяют самые крупные компании!</p>',
            ]);
        }

    }
}
