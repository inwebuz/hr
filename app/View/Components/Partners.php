<?php

namespace App\View\Components;

use App\Page;
use App\Partner;
use Illuminate\View\Component;

class Partners extends Component
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
        $page = Page::where('slug', 'partners')->withTranslation($locale)->firstOrFail();
        $partners = Partner::active()->featured()->orderBy('order')->withTranslation($locale)->take(30)->get();
        return view('components.partners', compact('page', 'partners'));
    }
}
