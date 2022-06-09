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

        for ($i = 0; $i < 9; $i++) {
            Employee::create([
                'last_name' => $lastname[$i],
                'first_name' => $firstname[$i],
                'patronymic' => '',
                'image' => 'employees/0' . ($i + 1) . '.jpg',
            ]);
        }

    }
}
