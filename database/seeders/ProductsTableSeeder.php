<?php

namespace Database\Seeders;

use App\Attribute;
use App\AttributeValue;
use App\Category;
use App\Helpers\Helper;
use App\Product;
use App\ProductVariant;
use App\Redirect;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $attributes = Attribute::with('attributeValues')->get()->keyBy('name');
        $categories = Category::all()->keyBy('id');

        // simple products
        Product::factory()->count(100)->create()->each(function($product){

            $attributes = [2, 3, 4, 7, 8];
            shuffle($attributes);
            $selectedAttributes = array_slice($attributes, 0, 2);
            // attributes
            $product->attributes()->sync($selectedAttributes);

            // attribute values
            $attributeValueIds = AttributeValue::all()->whereIn('attribute_id', $selectedAttributes)->pluck('id')->toArray();
            shuffle($attributeValueIds);
            $product->attributeValues()->sync(array_slice($attributeValueIds, 0, 2));

            // categories
            $category = Category::inRandomOrder()->first();
            $product->categories()->sync([$category->id]);

            // installment plans
            $product->installmentPlans()->sync([1, 2]);
        });

    }
}
