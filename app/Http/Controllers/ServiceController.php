<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Page;
use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('slug', 'services')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $services = Service::active()->orderBy('order')->withTranslation($locale)->get();
        return view('services.index', compact('page', 'breadcrumbs', 'services'));
    }

    public function show(Request $request, Service $service, $slug)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $service->load('translations');

        // check slug
        if ($service->getTranslatedAttribute('slug') != $slug) {
            abort(404);
        }

        $page = Page::where('slug', 'services')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // $breadcrumbs->addItem(new LinkItem($service->getTranslatedAttribute('name'), $service->url, LinkItem::STATUS_INACTIVE));

        return view('services.show', compact('page', 'breadcrumbs', 'service'));
    }

}
