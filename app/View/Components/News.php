<?php

namespace App\View\Components;

use App\Brand;
use App\Helpers\Helper;
use App\Product;
use App\Publication;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class News extends Component
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
        $publications = Publication::active()->news()->withTranslation($locale)->latest()->take(3)->get();
        return view('components.news', compact('publications'));
    }
}
