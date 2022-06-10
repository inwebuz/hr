<?php

namespace Database\Seeders;

use App\Publication;
use App\Pubrubric;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PublicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('publications')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i = 0; $i < 3; $i++) {
            Publication::factory()->count(3)->create([
                'name' => 'Исследование предпочтений на рынке соискателей ',
                'slug' => Str::slug('Исследование предпочтений на рынке соискателей'),
                'description' => 'В ноябре 2019 года мы с командой рекрутеров начали проводить исследование',
                'image' => 'publications/0' . ($i + 1) . '.jpg',
                'type' => Publication::TYPE_NEWS,
            ]);
        }
        // Publication::factory()->count(50)->create();

        // Publication::factory()->count(10)->create([
        //     'type' => Publication::TYPE_PROMOTION,
        // ]);

        // Publication::factory()->count(20)->create([
        //     'type' => Publication::TYPE_ARTICLE,
        // ]);

        // $names = [
        //     'Согреваемся, пока не включили отопление',
        //     'Согреваемся, пока не включили отопление',
        //     'Согреваемся, пока не включили отопление',
        // ];
        // foreach ($names as $key => $name) {
        //     Publication::factory()->create([
        //         'name' => $name,
        //         'slug' => Str::slug($name),
        //         'type' => Publication::TYPE_NEWS,
        //         'created_at' => now()->addSeconds($key + 1),
        //     ]);
        // }
    }
}
