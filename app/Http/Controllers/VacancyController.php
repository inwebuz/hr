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
        $vacancyCategories = VacancyCategory::active()->orderBy('order')->whereNull('parent_id')->with(['vacancies' => function($query){
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

    public function show(Request $request, Vacancy $vacancy, $slug)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $vacancy->load('translations');

        // check slug
        if ($vacancy->getTranslatedAttribute('slug') != $slug) {
            abort(404);
        }

        $page = Page::where('slug', 'vacancies')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        $breadcrumbs->addItem(new LinkItem($vacancy->getTranslatedAttribute('name'), $vacancy->url, LinkItem::STATUS_INACTIVE));

        return view('vacancies.show', compact('page', 'breadcrumbs', 'vacancy'));
    }

}
