<?php

namespace App\View\Components;

use App\Helpers\Helper;
use App\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class BestsellerProducts extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $locale = app()->getLocale();
        $bestsellerProducts = Product::active()
            ->bestsellers()
            ->with(['categories' => function($query) use ($locale) {
                $query->withTranslation($locale);
            }])
            ->with('installmentPlans')
            ->withTranslation($locale)
            ->inRandomOrder()
            // ->latest()
            ->take(6)
            ->get();

        $menu = menu('Популярные товары', '_json');
        if (!$menu->isEmpty()) {
            $menu->load('translations');
        }

        return view('components.bestseller_products', compact('bestsellerProducts', 'menu'));
    }
}
