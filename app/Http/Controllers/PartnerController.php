<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Page;
use App\Partner;
use App\Product;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('slug', 'partners')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $partners = Partner::active()->orderBy('order')->withTranslation($locale)->get();
        return view('partners.index', compact('page', 'breadcrumbs', 'partners'));
    }

    public function show(Request $request, Partner $partner, $slug)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $partner->load('translations');

        // check slug
        if ($partner->getTranslatedAttribute('slug') != $slug) {
            abort(404);
        }

        $page = Page::where('slug', 'partners')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // $breadcrumbs->addItem(new LinkItem($partner->getTranslatedAttribute('name'), $partner->url, LinkItem::STATUS_INACTIVE));

        return view('partners.show', compact('page', 'breadcrumbs', 'partner'));
    }

}
