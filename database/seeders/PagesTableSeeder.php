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
            'name' => 'Кто мы?',
            'slug' => Str::slug('Кто мы?'),
            'order' => 40,
            'show_in' => 1,
        ]);

            $subpage = Page::factory()->create([
                'name' => 'О нас',
                'slug' => Str::slug('О нас'),
                'order' => 40010,
                'show_in' => 2,
                'parent_id' => $page->id,
                'description' => '',
                'body' => '<h2 class="font-weight-bold">Информация о компании</h2>
                <p>HR Baraka Group является лидером в сфере HR услуг в Республике Узбекистан. Мы предоставляем полный спектр HR-услуг от рекрутмента и кадрового консалтинга до решения нестандартных задач и выполнения множества других функций. </p>
                <p>
                    <img src="/storage/pages/about-1.jpg" alt="">
                </p>
                <p></p>Нам заслуженно доверяют самые крупные компании и холдинги, а клиентская база состоит из лидеров рынка нефти и газа, химической промышленности, металлургии и горнодобывающей промышленности, энергетики и коммунальных услуг, инжиниринга и строительства, HoReCa и гостиничного бизнеса и пр.</p>

                <p>Компания HR Baraka Group состоит из высококвалифицированных специалистов, разбирающихся во всех тонкостях корпоративной культуры. Среди нас есть консультанты по поиску руководителей высшего звена, имеющие международный опыт общения с персоналом. </p>
                <p>Мы свободно говорим на английском, русском, узбекском, таджикском и других языках.</p>',
            ]);

            $subpage = Page::factory()->create([
                'name' => 'Консультанты',
                'slug' => 'employees',
                'order' => 40020,
                'show_in' => 2,
                'parent_id' => $page->id,
            ]);

            $subpage = Page::factory()->create([
                'name' => 'Наши партнеры',
                'slug' => 'partners',
                'order' => 40030,
                'show_in' => 2,
                'parent_id' => $page->id,
            ]);

        // $page = Page::factory()->create([
        //     'name' => 'Каталог',
        //     'slug' => 'categories',
        //     'order' => 270,
        //     'show_in' => 0,
        // ]);

        $page = Page::factory()->create([
            'name' => 'Что мы делаем?',
            'slug' => 'services',
            'order' => 50,
            'show_in' => 1,
        ]);

        $page = Page::factory()->create([
            'name' => 'Вакансии',
            'slug' => 'vacancies',
            'order' => 80,
            'show_in' => 1,
        ]);

        $page = Page::factory()->create([
            'name' => 'Медиа',
            'slug' => 'media',
            'order' => 70,
            'show_in' => 1,
        ]);

            $subpage = Page::factory()->create([
                'name' => 'Новости',
                'slug' => 'news',
                'order' => 70010,
                'show_in' => 2,
                'parent_id' => $page->id,
            ]);

            $subpage = Page::factory()->create([
                'name' => 'Галерея',
                'slug' => 'galleries',
                'order' => 70020,
                'show_in' => 2,
                'parent_id' => $page->id,
            ]);

        $page = Page::factory()->create([
            'name' => 'Карьера',
            'slug' => 'vacancies',
            'order' => 80,
            'show_in' => 1,
        ]);

            $subpage = Page::factory()->create([
                'name' => 'Подача резюме',
                'slug' => 'cv',
                'order' => 100,
                'show_in' => 2,
                'description' => '',
                'body' => '',
                'parent_id' => $page->id,
            ]);

            $subpage = Page::factory()->create([
                'name' => 'Контакты',
                'slug' => 'contacts',
                'order' => 80010,
                'show_in' => 0,
                'description' => '',
                'body' => '',
                'parent_id' => $page->id,
            ]);

        // $page = Page::factory()->create([
        //     'name' => 'Бренды',
        //     'slug' => 'brands',
        //     'order' => 30,
        //     'show_in' => 1,
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Скидки',
        //     'slug' => 'sale',
        //     'order' => 20,
        //     'show_in' => 1,
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Новинки',
        //     'slug' => 'new-products',
        //     'order' => 220,
        //     'show_in' => 0,
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Хиты продаж',
        //     'slug' => 'bestsellers',
        //     'order' => 230,
        //     'show_in' => 0,
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Последние просмотренные товары',
        //     'slug' => 'latest-viewed',
        //     'order' => 240,
        //     'show_in' => 0,
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Акции и скидки',
        //     'slug' => 'promotional-products',
        //     'order' => 300,
        //     'show_in' => 0,
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Доставка',
        //     'slug' => Str::slug('Доставка'),
        //     'order' => 50,
        //     'show_in' => 2,
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Оплата',
        //     'slug' => Str::slug('Оплата'),
        //     'order' => 60,
        //     'show_in' => 2,
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Возврат товара',
        //     'slug' => Str::slug('Возврат товара'),
        //     'order' => 70,
        //     'show_in' => 2,
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Для юридических лиц',
        //     'slug' => Str::slug('Для юридических лиц'),
        //     'order' => 1010,
        //     'show_in' => 2,
        //     'icon' => 'pages/verified.png',
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Оформление заказа',
        //     'slug' => Str::slug('Оформление заказа'),
        //     'order' => 80,
        //     'show_in' => 0,
        // ]);

        // $page = Page::factory()->create([
        //     'name' => 'Пользовательское соглашение',
        //     'slug' => Str::slug('Пользовательское соглашение'),
        //     'order' => 90,
        //     'show_in' => 0,
        // ]);

    }
}
