<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        Menu::firstOrCreate([
            'name' => 'admin',
        ]);

        Menu::create([
            'name' => 'Категории',
        ]);

        Menu::create([
            'name' => 'Покупателям',
        ]);

        Menu::create([
            'name' => 'Полезное',
        ]);

        Menu::create([
            'name' => 'Популярные товары',
        ]);

        Menu::create([
            'name' => 'Акции и скидки',
        ]);

        Menu::create([
            'name' => 'Новинки на сайте',
        ]);
    }
}
