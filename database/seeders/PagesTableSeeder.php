<?php

namespace Database\Seeders;

use App\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = Page::factory()->create([
            'name' => 'Главная',
            'slug' => 'home',
            'order' => 0,
            'show_in' => 0,
        ]);

        $page = Page::factory()->create([
            'name' => 'Контакты',
            'slug' => 'contacts',
            'order' => 1000,
            'show_in' => 1,
            'description' => '',
            'body' => '',
        ]);

        $page = Page::factory()->create([
            'name' => 'О нас',
            'slug' => Str::slug('О нас'),
            'order' => 40,
            'show_in' => 1,
        ]);

        $page = Page::factory()->create([
            'name' => 'Каталог',
            'slug' => 'categories',
            'order' => 270,
            'show_in' => 0,
        ]);

        $page = Page::factory()->create([
            'name' => 'Бренды',
            'slug' => 'brands',
            'order' => 30,
            'show_in' => 1,
        ]);

        $page = Page::factory()->create([
            'name' => 'Скидки',
            'slug' => 'sale',
            'order' => 20,
            'show_in' => 1,
        ]);

        $page = Page::factory()->create([
            'name' => 'Новинки',
            'slug' => 'new-products',
            'order' => 220,
            'show_in' => 0,
        ]);

        $page = Page::factory()->create([
            'name' => 'Хиты продаж',
            'slug' => 'bestsellers',
            'order' => 230,
            'show_in' => 0,
        ]);

        $page = Page::factory()->create([
            'name' => 'Последние просмотренные товары',
            'slug' => 'latest-viewed',
            'order' => 240,
            'show_in' => 0,
        ]);

        $page = Page::factory()->create([
            'name' => 'Акции и скидки',
            'slug' => 'promotional-products',
            'order' => 300,
            'show_in' => 0,
        ]);

        $page = Page::factory()->create([
            'name' => 'Новости',
            'slug' => 'news',
            'order' => 290,
            'show_in' => 0,
        ]);

        $page = Page::factory()->create([
            'name' => 'Доставка',
            'slug' => Str::slug('Доставка'),
            'order' => 50,
            'show_in' => 2,
        ]);

        $page = Page::factory()->create([
            'name' => 'Оплата',
            'slug' => Str::slug('Оплата'),
            'order' => 60,
            'show_in' => 2,
        ]);

        $page = Page::factory()->create([
            'name' => 'Возврат товара',
            'slug' => Str::slug('Возврат товара'),
            'order' => 70,
            'show_in' => 2,
        ]);

        $page = Page::factory()->create([
            'name' => 'Для юридических лиц',
            'slug' => Str::slug('Для юридических лиц'),
            'order' => 1010,
            'show_in' => 2,
            'icon' => 'pages/verified.png',
        ]);

        $page = Page::factory()->create([
            'name' => 'Оформление заказа',
            'slug' => Str::slug('Оформление заказа'),
            'order' => 80,
            'show_in' => 0,
        ]);

        $page = Page::factory()->create([
            'name' => 'Пользовательское соглашение',
            'slug' => Str::slug('Пользовательское соглашение'),
            'order' => 90,
            'show_in' => 0,
        ]);

    }
}
