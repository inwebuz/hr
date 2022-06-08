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

        for ($i = 1; $i <= 12; $i++) {
            Employee::create([
                'last_name' => $i,
                'first_name' => $i,
                'patronymic' => $i,
                'image' => 'employees/' . $i . '.jpg',
            ]);
        }

    }
}
