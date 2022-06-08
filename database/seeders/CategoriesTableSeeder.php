<?php

namespace Database\Seeders;

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Category::factory()->count(10)->create();

        Category::factory()->count(5)->create([
            'parent_id' => Category::inRandomOrder()->first()->id,
        ]);
        Category::factory()->count(5)->create([
            'parent_id' => Category::inRandomOrder()->first()->id,
        ]);
        Category::factory()->count(5)->create([
            'parent_id' => Category::inRandomOrder()->first()->id,
        ]);
        Category::factory()->count(5)->create([
            'parent_id' => Category::inRandomOrder()->first()->id,
        ]);
        Category::factory()->count(5)->create([
            'parent_id' => Category::inRandomOrder()->first()->id,
        ]);

    }
}
