<?php

namespace Database\Seeders;

use App\Banner;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // slide
        Banner::create([
            'name' => 'HR Baraka Group',
            'description_top' => '',
            'description' => 'The Art of Achieving the Impossible',
            'description_bottom' => '',
            'button_text' => 'Подробнее',
            'type' => 'slide',
            'image' => 'banners/slide-01.jpg',
            'url' => '#',
            'status' => '1',
        ]);
        Banner::create([
            'name' => 'HR Baraka Group 2',
            'description_top' => '',
            'description' => 'The Art of Achieving the Impossible 2',
            'description_bottom' => '',
            'button_text' => 'Подробнее',
            'type' => 'slide',
            'image' => 'banners/slide-02.jpg',
            'url' => '#',
            'status' => '1',
        ]);

        // home
        // Banner::create([
        //     'name' => '01',
        //     'description' => '',
        //     'button_text' => '',
        //     'type' => 'home_1',
        //     'image' => 'banners/home_01.jpg',
        //     'url' => '#',
        //     'status' => '1',
        // ]);
        // Banner::create([
        //     'name' => '02',
        //     'description' => '',
        //     'button_text' => '',
        //     'type' => 'home_2',
        //     'image' => 'banners/home_02.jpg',
        //     'url' => '#',
        //     'status' => '1',
        // ]);

        // middle
        // Banner::create([
        //     'name' => 'middle 01',
        //     // 'text_color' => '#fff',
        //     'description_top' => '',
        //     'description' => '',
        //     'description_bottom' => '',
        //     'button_text' => '',
        //     'type' => 'middle_1',
        //     'image' => 'banners/middle-01.jpg',
        //     'url' => '#',
        //     'status' => '1',
        // ]);
        // Banner::create([
        //     'name' => 'middle 02',
        //     // 'text_color' => '#fff',
        //     'description_top' => '',
        //     'description' => '',
        //     'description_bottom' => '',
        //     'button_text' => '',
        //     'type' => 'middle_2',
        //     'image' => 'banners/middle-02.jpg',
        //     'url' => '#',
        //     'status' => '1',
        // ]);
        // Banner::create([
        //     'name' => 'middle 03',
        //     // 'text_color' => '#fff',
        //     'description_top' => '',
        //     'description' => '',
        //     'description_bottom' => '',
        //     'button_text' => '',
        //     'type' => 'middle_3',
        //     'image' => 'banners/middle-03.jpg',
        //     'url' => '#',
        //     'status' => '1',
        // ]);

        // sidebar
        // Banner::create([
        //     'name' => 'Sidebar 01',
        //     // 'text_color' => '#fff',
        //     'description_top' => '',
        //     'description' => '',
        //     'description_bottom' => '',
        //     'button_text' => '',
        //     'type' => 'sidebar_1',
        //     'image' => 'banners/sidebar-01.jpg',
        //     'url' => '#',
        //     'status' => '1',
        // ]);
        // Banner::create([
        //     'name' => 'Sidebar 02',
        //     // 'text_color' => '#fff',
        //     'description_top' => '',
        //     'description' => '',
        //     'description_bottom' => '',
        //     'button_text' => '',
        //     'type' => 'sidebar_2',
        //     'image' => 'banners/sidebar-02.jpg',
        //     'url' => '#',
        //     'status' => '1',
        // ]);

        // Banner::create([
        //     'name' => 'Middle Slide 01',
        //     // 'text_color' => '#fff',
        //     'description_top' => '',
        //     'description' => '',
        //     'description_bottom' => '',
        //     'button_text' => '',
        //     'type' => 'middle_slide',
        //     'image' => 'banners/middle-slide-01.jpg',
        //     'url' => '#',
        //     'status' => '1',
        // ]);

        // Banner::create([
        //     'name' => 'Middle Slide 02',
        //     // 'text_color' => '#fff',
        //     'description_top' => '',
        //     'description' => '',
        //     'description_bottom' => '',
        //     'button_text' => '',
        //     'type' => 'middle_slide',
        //     'image' => 'banners/middle-slide-02.jpg',
        //     'url' => '#',
        //     'status' => '1',
        // ]);
    }
}
