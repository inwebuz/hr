<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products fields';

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
        $dateTime = now()->subHour();
        $products = Product::where('updated_at', '>', $dateTime)->with('installmentPlans')->get();
        foreach($products as $product) {

            $maxInstallmentPlanMonths = $product->max_months;
            if ($maxInstallmentPlanMonths < 0) {
                $maxInstallmentPlanMonths = 0;
            }																	 

            // set min price per month
            $product->min_price_per_month = $maxInstallmentPlanMonths > 0 ? $product->installment_price / $maxInstallmentPlanMonths : $product->current_price;
            Product::withoutEvents(function () use ($product) {
                $product->save();
            });
        }
        return 0;
    }
}
