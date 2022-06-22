<?php

namespace App\Http\Controllers;

use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Page;
use App\Vacancy;
use App\VacancyCategory;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('slug', 'vacancies')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $vacancyCategories = VacancyCategory::active()->orderBy('order')->with(['vacancies' => function($query){
            $query->select(['id', 'vacancy_category_id'])->active();
        }])->withTranslation($locale)->get();
        $vacanciesQuantity = Vacancy::active()->count();
        return view('vacancies.index', compact('page', 'breadcrumbs', 'vacancyCategories', 'vacanciesQuantity'));
    }

    public function category(Request $request, VacancyCategory $vacancyCategory, $slug)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $vacancyCategory->load('translations', 'parent');
        $vacancyCategory->load(['children' => function($query) use ($locale){
            $query->active()->orderBy('order')->withTranslation($locale);
        }]);

        // check slug
        if ($vacancyCategory->getTranslatedAttribute('slug') != $slug) {
            abort(404);
        }

        $page = Page::where('slug', 'vacancies')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        if ($vacancyCategory->parent) {
            $vacancyCategory->parent->load('translations');
            $breadcrumbs->addItem(new LinkItem($vacancyCategory->parent->getTranslatedAttribute('name'), $vacancyCategory->parent->url));

        }

        $query = $vacancyCategory->vacancies()
            ->active()
            ->withTranslation($locale)
            ->orderBy('vacancies.created_at');

        // get query products paginate
        $vacancies = $query->paginate(50);
        $links = $vacancies->links('partials.pagination');

        return view('vacancies.category', compact('page', 'breadcrumbs', 'vacancies', 'vacancyCategory', 'links'));
    }

    public function show(Request $request, Brand $brand, $slug)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $brand->load('translations');

        // check slug
        if ($brand->getTranslatedAttribute('slug') != $slug) {
            abort(404);
        }

        $page = Page::where('slug', 'brands')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // $currentRegion = Helper::getCurrentRegion();
        // $warehouseIDs = $currentRegion->warehouses->pluck('id')->toArray();

        // quantity per page
        $quantityPerPage = $this->quantityPerPage;
        $quantity = $request->input('quantity', $this->quantityPerPage[0]);
        if (!in_array($quantity, $this->quantityPerPage)) {
            $quantity = $this->quantityPerPage[0];
        }

        // sort - order
        $sorts = $this->sorts;
        $sortCurrent = $request->input('sort', '');
        if (empty($sortCurrent) || !in_array($sortCurrent, $sorts)) {
            $sortCurrent = $sorts[0];
        }
        $sortRaw = explode('-', $sortCurrent);
        $sort = $sortRaw[0];
        $order = $sortRaw[1];

        $query = $brand->products()
            // ->orderBy('products.' . $sort, $order)
            ->active()
            ->with(['categories' => function($query) use ($locale) {
                $query->withTranslation($locale);
            }])
            ->withTranslation($locale)
            ->orderBy('products.created_at');

        $productAllQuantity = $query->count();

        // get query products paginate
        $products = $query->paginate($quantity);
        $links = $products->links('partials.pagination');

        $breadcrumbs->addItem(new LinkItem($brand->getTranslatedAttribute('name'), $brand->url, LinkItem::STATUS_INACTIVE));

        return view('brands.show', compact('page', 'breadcrumbs', 'products', 'productAllQuantity', 'brand', 'links', 'quantity', 'quantityPerPage', 'sorts', 'sortCurrent'));
    }

}
