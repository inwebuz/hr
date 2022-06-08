<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProductsRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products rating field';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::select(['id'])->with('reviews')->get();
        foreach($products as $product) {
            $product->rating =  $product->reviews()->active()->avg('rating');
            Product::withoutEvents(function () use ($product) {
                $product->save();
            });
        }
        return 0;
    }
}
