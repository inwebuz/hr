<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('menu_items')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // admin menu
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItems = [
            // main items
            [
                'title' => __('seeders.menu_items.dashboard'),
                'icon' => 'voyager-boat',
                'route' => 'voyager.dashboard',
            ],
            [
                'title' => __('seeders.menu_items.media'),
                'icon' => 'voyager-images',
                'route' => 'voyager.media.index',
            ],
            [
                'slug' => 'users',
                'icon' => 'voyager-person',
            ],
            [
                'slug' => 'roles',
                'icon' => 'voyager-lock',
            ],
            [
                'title' => __('seeders.menu_items.tools'),
                'icon' => 'voyager-tools',
                'route' => '',
                'submenu_items' => [
                    [
                        'title' => __('seeders.menu_items.menu_builder'),
                        'icon' => 'voyager-list',
                        'route' => 'voyager.menus.index',
                    ],
                    [
                        'title' => __('seeders.menu_items.database'),
                        'icon' => 'voyager-data',
                        'route' => 'voyager.database.index',
                    ],
                    [
                        'title' => __('seeders.menu_items.compass'),
                        'icon' => 'voyager-compass',
                        'route' => 'voyager.compass.index',
                    ],
                    [
                        'title' => __('seeders.menu_items.bread'),
                        'icon' => 'voyager-bread',
                        'route' => 'voyager.bread.index',
                    ],
                ],
            ],
            [
                'title' => __('seeders.menu_items.settings'),
                'icon' => 'voyager-settings',
                'route' => 'voyager.settings.index',
            ],
            [
                'slug' => 'pages',
                'icon' => 'voyager-file-text',
            ],

            // additional items
            [
                'slug' => 'banners',
                'icon' => 'voyager-images',
            ],
            [
                'slug' => 'promotions',
                'icon' => 'voyager-images',
            ],
            [
                'slug' => 'categories',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'brands',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'products',
                'icon' => 'voyager-basket',
            ],
            [
                'slug' => 'pricelists',
                'icon' => 'voyager-upload',
            ],
            [
                'slug' => 'attributes',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'attribute_values',
                'icon' => 'voyager-wand',
            ],
            [
                'slug' => 'rubrics',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'companies',
                'icon' => 'voyager-company',
            ],
            [
                'slug' => 'pubrubrics',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'publications',
                'icon' => 'voyager-news',
            ],
            [
                'slug' => 'articles',
                'icon' => 'voyager-documentation',
            ],
            [
                'slug' => 'news',
                'icon' => 'voyager-news',
            ],
            [
                'slug' => 'serrubrics',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'services',
                'icon' => 'voyager-receipt',
            ],
            [
                'slug' => 'specializations',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'specialists',
                'icon' => 'voyager-people',
            ],
            [
                'slug' => 'vacancies',
                'icon' => 'voyager-news',
            ],
            [
                'slug' => 'vacancy_categories',
                'icon' => 'voyager-news',
            ],
            [
                'slug' => 'c_v_s',
                'icon' => 'voyager-file-text',
            ],
            [
                'slug' => 'audios',
                'icon' => 'voyager-sound',
            ],
            [
                'slug' => 'videos',
                'icon' => 'voyager-video',
            ],
            [
                'slug' => 'galleries',
                'icon' => 'voyager-photos',
            ],
            [
                'slug' => 'reviews',
                'icon' => 'voyager-bubble',
            ],
            [
                'slug' => 'static_texts',
                'icon' => 'voyager-file-text',
            ],
            [
                'slug' => 'redirects',
                'icon' => 'voyager-forward',
            ],
            [
                'slug' => 'fixed_companies',
                'icon' => 'voyager-paperclip',
            ],
            [
                'slug' => 'orders',
                'icon' => 'voyager-shop',
            ],
            [
                'slug' => 'user_applications',
                'icon' => 'voyager-check-circle',
            ],
            [
                'slug' => 'shops',
                'icon' => 'voyager-shop',
            ],
            [
                'slug' => 'genders',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'installment_plans',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'export',
                'icon' => 'voyager-download',
            ],
            [
                'slug' => 'import',
                'icon' => 'voyager-upload',
            ],
            [
                'slug' => 'notifications',
                'icon' => 'voyager-bell',
            ],
            [
                'slug' => 'polls',
                'icon' => 'voyager-megaphone',
            ],
            // [
            //     'slug' => 'poll_answers',
            //     'icon' => 'voyager-megaphone',
            // ],
            [
                'slug' => 'subscribers',
                'icon' => 'voyager-mail',
            ],
            [
                'slug' => 'warehouses',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'brand_category_texts',
                'icon' => 'voyager-categories',
            ],
            [
                'title' => 'Настройки доставки',
                'slug' => 'delivery_settings',
                'icon' => 'voyager-truck',
            ],
            [
                'slug' => 'employees',
                'icon' => 'voyager-people',
            ],
            [
                'slug' => 'partners',
                'icon' => 'voyager-categories',
            ],
            [
                'slug' => 'partner_installments',
                'icon' => 'voyager-categories',
            ],
            [

                'slug' => 'product_groups',
                'icon' => 'voyager-basket',
            ],
        ];
        $this->seedMenuItems($menu, $menuItems);

        // site menu
        // $menus = [
        //     'Категории' => ['Электроинструменты', 'Для сада', 'Бытовая техника', 'Водяные насосы', 'Ручные инструменты', 'Электрика и свет', 'Сантехника', 'Оборудование',],
        //     'Покупателям' => ['Возврат товара', 'Доставка', 'Оплата', 'Оформление заказа', 'Пользовательское соглашение',],
        //     'Полезное' => ['О нас', 'Работа', 'Наша миссия', 'Для юридических лиц', ],
        //     'Популярные товары' => ['Болторезы', 'Гидравлические ножницы', 'Крепежи', 'Паяльное оборудования', 'Ножовки',],
        //     'Акции и скидки' => ['Аккумуляторный инструмент', 'Гайковерты', 'ДрелиФрезеры', 'Пистолеты', 'Электрорубанки',],
        //     'Новинки на сайте' => ['Болторезы', 'Гидравлические ножницы', 'Крепежи', 'Паяльное оборудования', 'Ножовки',],
        // ];

        // foreach ($menus as $key => $values) {
        //     $menu = Menu::where('name', $key)->firstOrFail();
        //     foreach ($values as $key1 => $value) {
        //         switch ($key) {
        //             case 'Категории':
        //             case 'Популярные товары':
        //             case 'Акции и скидки':
        //             case 'Новинки на сайте':
        //                 $url = '/' . Str::slug($value);
        //                 break;
        //             case 'Покупателям':
        //             case 'Полезное':
        //                 $url = '/page/-' . Str::slug($value);
        //                 break;
        //         }
        //         MenuItem::create([
        //             'title' => $value,
        //             'menu_id' => $menu->id,
        //             'url' => $url,
        //             'target' => '_self',
        //             'order' => $key1,
        //         ]);
        //     }
        // }
    }

    private function seedMenuItems(Menu $menu, array $menuItems)
    {
        $modules = config('cms.modules');

        foreach ($menuItems as $key => $item) {
            if (!empty($item['slug']) && empty($modules[$item['slug']])) {
                continue;
            }
            $order = $key + 1;
            $route = isset($item['route']) ? $item['route'] : 'voyager.' . $item['slug'] . '.index';
            $title = isset($item['title']) ? $item['title'] : __('seeders.menu_items.' . $item['slug']);
            $menuItem = MenuItem::firstOrNew([
                'menu_id' => $menu->id,
                'url' => '',
                'route' => $route,
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'title' => $title,
                    'target' => '_self',
                    'icon_class' => $item['icon'],
                    'color' => null,
                    'parent_id' => null,
                    'order' => $order,
                ])->save();
            }
            if (isset($item['submenu_items']) && is_array($item['submenu_items'])) {
                foreach ($item['submenu_items'] as $subKey => $subItem) {
                    $subRoute = isset($subItem['route']) ? $subItem['route'] : 'voyager.' . $subItem['slug'] . '.index';
                    $subTitle = isset($subItem['title']) ? $subItem['title'] : __('seeders.menu_items.' . $subItem['slug']);
                    $subMenuItem = MenuItem::firstOrNew([
                        'menu_id' => $menu->id,
                        'url' => '',
                        'route' => $subRoute,
                    ]);
                    if (!$subMenuItem->exists) {
                        $subMenuItem->fill([
                            'title' => $subTitle,
                            'target' => '_self',
                            'icon_class' => $subItem['icon'],
                            'color' => null,
                            'parent_id' => $menuItem->id,
                            'order' => $order * 100 + $subKey + 1,
                        ])->save();
                    }
                }
            }
        }
    }
}
