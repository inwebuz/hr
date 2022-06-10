<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Helpers\Helper;
use App\Page;
use App\Partner;
use App\Product;
use App\Publication;
use App\Region;
use App\Review;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $locale = app()->getLocale();

        $page = Page::where('id', 1)->withTranslation($locale)->firstOrFail();
        $pageAbout = Page::where('id', 3)->withTranslation($locale)->firstOrFail();

        // $currentRegionID = Helper::getCurrentRegionID();
        // $currentRegion = Helper::getCurrentRegion();
        // $warehouseIDs = $currentRegion->warehouses->pluck('id')->toArray();

        // slides
        $slides = Helper::banners('slide');

        $founder = Helper::staticText('founder', 300);
        $homeSeo = Helper::staticText('home_seo', 300);
        $writeUs = Helper::staticText('write_us', 300);
        $newsText = Helper::staticText('news', 300);
        $reviewsText = Helper::staticText('reviews', 300);

        $services = Service::active()->featured()->orderBy('order')->withTranslation($locale)->take(3)->get();
        $servicesPage = Page::active()->where('slug', 'services')->withTranslation($locale)->firstOrFail();

        $news = Publication::active()->news()->latest()->withTranslation($locale)->take(3)->get();
        $reviews = Review::active()->main()->latest()->take(6)->get();

        $partners = Partner::active()->featured()->orderBy('order')->withTranslation($locale)->take(10)->get();

        // $homeCategoriesProducts = [];
        // foreach ($homeCategories as $homeCategory) {
        //     $homeCategoriesProducts[$homeCategory->id] = [
        //         'category' => $homeCategory,
        //         'products' => $homeCategory->products()->active()->latest()->take(6)->withTranslation($locale)->with('categories')->with('installmentPlans')->get(),
        //     ];
        // }

        // $promotionProducts = Product::active()
        //     ->promotion()
        //     ->with(['categories' => function($query) use ($locale) {
        //         $query->withTranslation($locale);
        //     }])
        //     ->with('installmentPlans')
        //     ->withTranslation($locale)
        //     ->latest()
        //     ->take(3)
        //     ->get();

        // $latestViewedProducts = collect();
        // $latestViewedProductIDs = Cache::get('latest_viewed_products_ids');
        // $latestViewedProductIDs = explode(',', $latestViewedProductIDs);
        // if (count($latestViewedProductIDs)) {
        //     $latestViewedProductIDs = array_slice($latestViewedProductIDs, 0, 6);
        //     $latestViewedProducts = Product::active()
        //         ->with(['categories' => function($query) use ($locale) {
        //             $query->withTranslation($locale);
        //         }])
        //         ->with('installmentPlans')
        //         ->withTranslation($locale)
        //         ->whereIn('id', $latestViewedProductIDs)
        //         ->get();
        // }

        // product blocks
        // $productsBlocksCategories = Category::active()->whereIn('id', [1, 11, 23])->withTranslation($locale)->get();
        // $productsBlocks = [];
        // foreach ($productsBlocksCategories as $productsBlocksCategory) {
        //     $productsBlock = [
        //         'category' => $productsBlocksCategory,
        //         'products' => collect(),
        //     ];
        //     $query = $productsBlocksCategory->products()
        //         ->active()
        //         ->with(['categories' => function($query) use ($locale) {
        //             $query->withTranslation($locale);
        //         }])
        //         ->withTranslation($locale)
        //         ->latest();
        //     $productsBlockProducts = $query->take(12)->get();
        //     $productsBlock['products'] = $productsBlockProducts;
        //     $productsBlocks[] = $productsBlock;
        // }

        // articles
        $articles = Publication::articles()->active()->withTranslation($locale)->latest()->take(4)->get();

        return view('home', compact('page', 'pageAbout', 'slides', 'articles', 'founder', 'homeSeo', 'services', 'servicesPage', 'writeUs', 'newsText', 'news', 'reviewsText', 'reviews', 'partners'));
    }

    public function latestProducts(Category $category)
    {
        $locale = app()->getLocale();
        $products = $category->allProducts()->active()->latest()->withTranslation($locale)->take(10)->get();
        $category->load('translations');
        return view('partials.latest_products_slider', compact('category', 'products'));
    }
}
