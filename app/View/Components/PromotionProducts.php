<?php

namespace App\View\Components;

use App\Helpers\Helper;
use App\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class PromotionProducts extends Component
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
        $promotionProducts = Product::active()
            ->promotion()
            ->with(['categories' => function($query) use ($locale) {
                $query->withTranslation($locale);
            }])
            ->with('installmentPlans')
            ->withTranslation($locale)
            ->latest()
            ->take(6)
            ->get();

        // slides
        $slides = Helper::banners('middle_slide');

        $menu = menu('Акции и скидки', '_json');
        if (!$menu->isEmpty()) {
            $menu->load('translations');
        }

        return view('components.promotion_products', compact('promotionProducts', 'slides', 'menu'));
    }
}
