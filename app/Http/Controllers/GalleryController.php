<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Helpers\Breadcrumbs;
use App\Helpers\LinkItem;
use App\Page;

class GalleryController extends Controller
{
    public function show()
    {
        $locale = app()->getLocale();
        $page = Page::where('slug', 'gallery')->withTranslation($locale)->firstOrFail();
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $gallery = Gallery::active()->withTranslation($locale)->latest()->firstOrFail();
        return view('galleries.index', compact('breadcrumbs', 'page', 'gallery'));
    }
}
