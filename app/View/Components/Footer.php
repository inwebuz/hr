<?php

namespace App\View\Components;

use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Page;
use App\Region;
use App\StaticText;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\Component;
use TCG\Voyager\Facades\Voyager;

class Footer extends Component
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

        $pages = Page::active()->inFooterMenu()->withTranslation($locale)->get()->keyBy('id');

        $footerMenuItems = Helper::menuItems('footer');

        $siteLogo = setting('site.logo');
        $siteLightLogo = setting('site.logo_light');
        $logo = $siteLogo ? Voyager::image($siteLogo) : '/img/logo.png';
        $logoLight = $siteLightLogo ? Voyager::image($siteLightLogo) : '/img/logo.png';

        $address = Helper::staticText('contact_address', 300)->getTranslatedAttribute('description');
        $workHours = Helper::staticText('work_hours', 300)->getTranslatedAttribute('description');
        $footerText = Helper::staticText('footer_text', 300)->getTranslatedAttribute('description');

        // $categories = Helper::categories();

        // $currentRegionID = Helper::getCurrentRegionID();
        // $regions = Cache::remember('regions', 86400, function () use ($locale) {
        //     $regions = Region::orderBy('short_name')->withTranslation($locale)->get();
        //     return $regions;
        // });

        $cartQuantity = app('cart')->getTotalQuantity();
        $wishlistQuantity = app('wishlist')->getTotalQuantity();
        $compareQuantity = app('compare')->getTotalQuantity();

        return view('components.footer', compact('footerMenuItems', 'pages', 'logo', 'logoLight', 'address', 'workHours', 'footerText', 'cartQuantity', 'wishlistQuantity', 'compareQuantity'));
    }
}
