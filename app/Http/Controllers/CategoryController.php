<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Brand;
use App\BrandCategoryText;
use App\Category;
use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Page;
use App\Product;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\SchemaOrg\AggregateRating;
use Spatie\SchemaOrg\Schema;

class CategoryController extends Controller
{
    /**
     * show products per page values
     */
    public $quantityPerPage = [32, 64, 128];
    // public $sorts = ['views-desc', 'created_at-desc', 'price-asc', 'price-desc', 'rating-desc'];
    public $sorts = ['views-desc', 'rating-desc', 'price-desc', 'price-asc'];

    /**
     * show products per page values
     */
    public $filters = ['special', 'popular', 'new'];

    public function index()
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();
        $page = Page::where('slug', 'categories')->firstOrFail();
        $page->load('translations');
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url, LinkItem::STATUS_INACTIVE));
        $categories = Category::active()->whereNull('parent_id')->withTranslation($locale)->get();
        return view('categories.index', compact('page', 'breadcrumbs', 'categories'));
    }

    // public function show(Request $request, Category $category)
    public function show(Request $request, $slug)
    {
        $locale = app()->getLocale();
        $exchangeRate = Helper::exchangeRate();
        $defaultLocale = config('voyager.multilingual.default');
        if ($locale == $defaultLocale) {
            $category = Category::where('slug', $slug)->firstOrFail();
        } else {
            $category = Category::whereTranslation('slug', '=', $slug, [$locale], false)->withTranslation($locale)->firstOrFail();
        }

        if ($category->parent_id == null) {
            return $this->showParent($request, $category);
        }

        $breadcrumbs = new Breadcrumbs();

        // $page = Page::findOrFail(5);
        // $page->load('translations');

        // $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // quantity per page
        $quantityPerPage = $this->quantityPerPage;
        $quantity = request('quantity', $this->quantityPerPage[0]);
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

        // product view
        $productView = $request->input('product_view', 'grid');
        if (empty($productView) || !in_array($productView, ['grid', 'list'])) {
            $productView = 'grid';
        }

        // min and max price (per month)
        $prices = [];
        $categoryPrices = [];
        $requestPrices = $request->input('price', []);
        $prices['from'] = $categoryPrices['from'] = isset($requestPrices['from']) ? $requestPrices['from'] : null;
        $prices['to'] = $categoryPrices['to'] = isset($requestPrices['to']) ? $requestPrices['to'] : null;

        // filters
        $filter = $request->input('filter', '');
        if (!empty($filter) && !in_array($filter, $this->filters)) {
            $filter = '';
        }

        // brands
        $brands = $request->input('brand', []);
        if (!empty($brands) && !is_array($brands)) {
            $brands = [];
        }

        // attributes
        $attributes = $request->input('attribute', []);
        if (!empty($attributes) && !is_array($attributes)) {
            $attributes = [];
        }

        $query = $category->products()->active();


        // apply filters
        if ($filter) {
            $query->where('is_' . $filter, constant('\App\Product::' . mb_strtoupper($filter) . '_ACTIVE'));
        }

        // category brands, attributes and attribute values (before attribute and brand filter applied)
        $queryClone = clone $query;
        $categoryBrands = $category->allBrands($queryClone);
        $queryClone = clone $query;
        $categoryAttributes = $category->allAttributes($queryClone);

        // get min max prices
        $queryClone = clone $query;
        $categoryPrices['min'] = $queryClone->select('price')->min('price') * $exchangeRate;
        $categoryPrices['max'] = $queryClone->select('price')->max('price') * $exchangeRate;

        // apply brands
        if ($brands) {
            $query->whereIn('products.brand_id', $brands);
        }

        // apply attributes
        if ($attributes) {
            foreach($attributes as $key => $values) {
                $attributeValueIds = [];
                $values = array_map('intval', $values);
                $attributeValueIds = array_merge($attributeValueIds, $values);
                if ($attributeValueIds) {
                    $query->whereIn('products.id', function($q1) use ($attributeValueIds) {
                        $q1->select('products.id')->from('products')->whereIn('products.id', function($q2) use ($attributeValueIds) {
                            $q2->select('product_id')->from('attribute_value_product')->whereIn('attribute_value_id', $attributeValueIds);
                        });
                    });
                }
            }
        }

        // apply prices
        if (isset($prices['from']) && isset($prices['to'])) {
            if ($prices['from'] > $prices['to']) {
                $tmp = $prices['from'];
                $prices['from'] = $prices['to'];
                $prices['to'] = $tmp;
            }
            $query->where('products.price', '>=', $prices['from'] / $exchangeRate)
                  ->where('products.price', '<=', $prices['to'] / $exchangeRate);
        }

        // sorting
        $query
            ->orderBy('products.' . $sort, $order)
            ->orderBy('products.created_at', 'desc');

        $productAllQuantity = $query->count();

        $query
            ->with('categories')
            ->withTranslation($locale)
            ->with('activeReviews');

        // microdata
        $queryClone = clone $query;
        $itemIds = $queryClone->get()->pluck('id');
        if ($itemIds) {
            $reviewsInfo = DB::table('reviews')->selectRaw('count(*) count, avg(rating) avg, sum(rating) sum')->where('status', 1)->where('reviewable_type', Product::class)->whereIn('reviewable_id', $itemIds)->first();
            $reviewsCount = $reviewsInfo->count;
            $reviewsAvg = round($reviewsInfo->avg, 1);

            // product
            $appName = config('app.name');
            $microdata = Schema::product();
            $microdata->name($category->getTranslatedAttribute('name'));
            $microdata->brand($appName);
            $microdata->description($category->getTranslatedAttribute('description') ?: $category->getTranslatedAttribute('name'));
            $microdata->image($category->img);
            $microdata->sku($appName . ' Category ' . $category->id);
            $microdata->mpn($appName . ' Category ' . $category->id);

            // offers
            $lowPriceProduct = Product::active()->whereIn('id', $itemIds)->select('price')->orderBy('price')->first();
            $highPriceProduct = Product::active()->whereIn('id', $itemIds)->select('price')->orderBy('price', 'desc')->first();
            if ($lowPriceProduct && $highPriceProduct) {
                $microdataOffer = Schema::aggregateOffer();
                $microdataOffer->lowPrice(round($lowPriceProduct->current_price));
                $microdataOffer->highPrice(round($highPriceProduct->current_price));
                $microdataOffer->priceCurrency('UZS');
                $microdataOffer->offerCount(count($itemIds));
                $microdata->offers($microdataOffer);
            }

            // rating
            $aggregateRating = new AggregateRating();
            if ($reviewsCount > 0) {
                $aggregateRating->worstRating(1)->bestRating(5)->ratingCount($reviewsCount)->ratingValue($reviewsAvg);
            } else {
                $aggregateRating->worstRating(1)->bestRating(5)->ratingCount(1)->ratingValue(5);
            }
            $microdata->aggregateRating($aggregateRating);

            // reviews
            $categoryReviews = Review::where('status', 1)->where('reviewable_type', Product::class)->whereIn('reviewable_id', $itemIds)->get();
            $microdataReviews = [];
            foreach($categoryReviews as $review) {
                $microdataReview = Schema::review();
                $microdataReview->name($category->getTranslatedAttribute('name'));
                $microdataReview->reviewBody($review->body);
                $microdataReview->author($review->name);
                $microdataReview->datePublished($review->created_at->format('Y-m-d'));
                $microdataReview->reviewRating(Schema::rating()->bestRating(5)->worstRating(1)->ratingValue($review->rating));
                $microdataReviews[] = $microdataReview;
            }
            if (count($microdataReviews)) {
                $microdata->review($microdataReviews);
            }

            // get script
            $microdata = $microdata->toScript();
        } else {
            $microdata = '';
        }

        // get query products paginate
        $products = $query->paginate($quantity);
        $showingResults = __('main.showing_results', ['all' => $products->total(), 'first' => $products->firstItem(), 'last' => $products->lastItem(), ]);

        $appends = ['quantity' => $quantity, 'sort' => $sortCurrent, 'attribute' => $attributes, 'brand' => $brands, 'product_view' => $productView];
        if (isset($prices['from']) && isset($prices['to'])) {
            $appends['price'] = $prices;
        }
        $links = $products->appends($appends)->links('partials.pagination');
        $total = $products->total();

        if($category->parent) {
            $parent = $category->parent;
            $parent->load('translations');
            $breadcrumbs->addItem(new LinkItem($parent->getTranslatedAttribute('name'), $parent->url));
        }

        // categories
        // $categories = Category::active()->parents()->with('children.children.children')->get();
        // $siblingCategories = Category::active()->where('parent_id', $category->parent_id)->get();
        $subcategories = Category::active()->where('parent_id', $category->id)
            ->withTranslation($locale)
            ->orderBy('order')
            ->get();

        // current and its parent category ids
        $activeCategoryIds = Helper::activeCategories($category);

        $new_products = Product::active()->withTranslation($locale)->latest()->take(4)->get();

        $breadcrumbs->addItem(new LinkItem($category->getTranslatedAttribute('name'), $category->url, LinkItem::STATUS_INACTIVE));

        return view('categories.show', compact('breadcrumbs', 'products', 'showingResults', 'productAllQuantity', 'category', 'new_products', 'activeCategoryIds', 'subcategories', 'links', 'total', 'brands', 'attributes', 'quantity', 'quantityPerPage', 'sorts', 'sortCurrent', 'productView', 'categoryBrands', 'categoryAttributes', 'categoryPrices', 'prices', 'microdata'));
    }

    private function showParent(Request $request, Category $category)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $page = Page::where('slug', 'categories')->withTranslation($locale)->firstOrFail();
        $page->load('translations');
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        $category->load('translations');

        $subcategories = Category::active()->where('parent_id', $category->id)
            ->withTranslation($locale)
            ->orderBy('order')
            ->get();

        $query = $category->products()->active();
        $categoryBrands = $category->allBrands($query);

        $breadcrumbs->addItem(new LinkItem($category->getTranslatedAttribute('name'), $category->url, LinkItem::STATUS_INACTIVE));

        return view('categories.show_parent', compact('breadcrumbs', 'category', 'subcategories', 'categoryBrands'));
    }

    public function showBrand(Request $request, $brandSlug, $categorySlug)
    {
        $locale = app()->getLocale();
        $exchangeRate = Helper::exchangeRate();
        $defaultLocale = config('voyager.multilingual.default');

        if ($locale == $defaultLocale) {
            $brand = Brand::where('slug', $brandSlug)->firstOrFail();
            $category = Category::where('slug', $categorySlug)->firstOrFail();
        } else {
            $brand = Brand::whereTranslation('slug', '=', $brandSlug, [$locale], false)->withTranslation($locale)->firstOrFail();
            $category = Category::whereTranslation('slug', '=', $categorySlug, [$locale], false)->withTranslation($locale)->firstOrFail();
        }

        $breadcrumbs = new Breadcrumbs();

        $brandCategoryText = BrandCategoryText::where([['category_id', $category->id], ['brand_id', $brand->id]])->withTranslation($locale)->first();

        $breadcrumbs->addItem(new LinkItem($brand->getTranslatedAttribute('name'), $brand->url));

        // $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // quantity per page
        $quantityPerPage = $this->quantityPerPage;
        $quantity = request('quantity', $this->quantityPerPage[0]);
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

        // product view
        $productView = $request->input('product_view', 'grid');
        if (empty($productView) || !in_array($productView, ['grid', 'list'])) {
            $productView = 'grid';
        }

        // min and max price (per month)
        $prices = [];
        $categoryPrices = [];
        $requestPrices = $request->input('price', []);
        $prices['from'] = $categoryPrices['from'] = isset($requestPrices['from']) ? $requestPrices['from'] : null;
        $prices['to'] = $categoryPrices['to'] = isset($requestPrices['to']) ? $requestPrices['to'] : null;

        // filters
        $filter = $request->input('filter', '');
        if (!empty($filter) && !in_array($filter, $this->filters)) {
            $filter = '';
        }

        // attributes
        $attributes = $request->input('attribute', []);
        if (!empty($attributes) && !is_array($attributes)) {
            $attributes = [];
        }

        $query = $category->products()->active();
        $query->where('products.brand_id', $brand->id);

        // apply filters
        if ($filter) {
            $query->where('is_' . $filter, constant('\App\Product::' . mb_strtoupper($filter) . '_ACTIVE'));
        }

        // category brands, attributes and attribute values (before attribute and brand filter applied)
        $queryClone = clone $query;
        $categoryAttributes = $category->allAttributes($queryClone);

        // get min max prices
        $queryClone = clone $query;
        $categoryPrices['min'] = $queryClone->select('price')->min('price') * $exchangeRate;
        $categoryPrices['max'] = $queryClone->select('price')->max('price') * $exchangeRate;

        // apply attributes
        if ($attributes) {
            foreach($attributes as $key => $values) {
                $attributeValueIds = [];
                $values = array_map('intval', $values);
                $attributeValueIds = array_merge($attributeValueIds, $values);
                if ($attributeValueIds) {
                    $query->whereIn('products.id', function($q1) use ($attributeValueIds) {
                        $q1->select('products.id')->from('products')->whereIn('products.id', function($q2) use ($attributeValueIds) {
                            $q2->select('product_id')->from('attribute_value_product')->whereIn('attribute_value_id', $attributeValueIds);
                        });
                    });
                }
            }
        }

        // apply prices
        if (isset($prices['from']) && isset($prices['to'])) {
            if ($prices['from'] > $prices['to']) {
                $tmp = $prices['from'];
                $prices['from'] = $prices['to'];
                $prices['to'] = $tmp;
            }
            $query->where('products.price', '>=', $prices['from'] / $exchangeRate)
                  ->where('products.price', '<=', $prices['to'] / $exchangeRate);
        }

        // sorting
        $query
            ->orderBy('products.' . $sort, $order)
            ->orderBy('products.created_at', 'desc');

        $productAllQuantity = $query->count();

        $query
            ->with('categories')
            ->withTranslation($locale)
            ->with('activeReviews');

        // microdata
        $queryClone = clone $query;
        $itemIds = $queryClone->get()->pluck('id');
        if ($itemIds) {
            $reviewsInfo = DB::table('reviews')->selectRaw('count(*) count, avg(rating) avg, sum(rating) sum')->where('status', 1)->where('reviewable_type', Product::class)->whereIn('reviewable_id', $itemIds)->first();
            $reviewsCount = $reviewsInfo->count;
            $reviewsAvg = round($reviewsInfo->avg, 1);

            // product
            $appName = config('app.name');
            $microdata = Schema::product();
            $microdata->name($category->getTranslatedAttribute('name'));
            $microdata->brand($appName);
            $microdata->description($category->getTranslatedAttribute('description') ?: $category->getTranslatedAttribute('name'));
            $microdata->image($category->img);
            $microdata->sku($appName . ' Category ' . $category->id);
            $microdata->mpn($appName . ' Category ' . $category->id);

            // offers
            $lowPriceProduct = Product::active()->whereIn('id', $itemIds)->select('price')->orderBy('price')->first();
            $highPriceProduct = Product::active()->whereIn('id', $itemIds)->select('price')->orderBy('price', 'desc')->first();
            if ($lowPriceProduct && $highPriceProduct) {
                $microdataOffer = Schema::aggregateOffer();
                $microdataOffer->lowPrice(round($lowPriceProduct->current_price));
                $microdataOffer->highPrice(round($highPriceProduct->current_price));
                $microdataOffer->priceCurrency('UZS');
                $microdataOffer->offerCount(count($itemIds));
                $microdata->offers($microdataOffer);
            }

            // rating
            $aggregateRating = new AggregateRating();
            if ($reviewsCount > 0) {
                $aggregateRating->worstRating(1)->bestRating(5)->ratingCount($reviewsCount)->ratingValue($reviewsAvg);
            } else {
                $aggregateRating->worstRating(1)->bestRating(5)->ratingCount(1)->ratingValue(5);
            }
            $microdata->aggregateRating($aggregateRating);

            // reviews
            $categoryReviews = Review::where('status', 1)->where('reviewable_type', Product::class)->whereIn('reviewable_id', $itemIds)->get();
            $microdataReviews = [];
            foreach($categoryReviews as $review) {
                $microdataReview = Schema::review();
                $microdataReview->name($category->getTranslatedAttribute('name'));
                $microdataReview->reviewBody($review->body);
                $microdataReview->author($review->name);
                $microdataReview->datePublished($review->created_at->format('Y-m-d'));
                $microdataReview->reviewRating(Schema::rating()->bestRating(5)->worstRating(1)->ratingValue($review->rating));
                $microdataReviews[] = $microdataReview;
            }
            if (count($microdataReviews)) {
                $microdata->review($microdataReviews);
            }

            // get script
            $microdata = $microdata->toScript();
        } else {
            $microdata = '';
        }

        // get query products paginate
        $products = $query->paginate($quantity);
        $showingResults = __('main.showing_results', ['all' => $products->total(), 'first' => $products->firstItem(), 'last' => $products->lastItem(), ]);

        $appends = ['quantity' => $quantity, 'sort' => $sortCurrent, 'attribute' => $attributes, 'product_view' => $productView];
        if (isset($prices['from']) && isset($prices['to'])) {
            $appends['price'] = $prices;
        }
        $links = $products->appends($appends)->links('partials.pagination');
        $total = $products->total();

        if($category->parent) {
            $parent = $category->parent;
            $parent->load('translations');
            // $breadcrumbs->addItem(new LinkItem($parent->getTranslatedAttribute('name'), $parent->url));
            $breadcrumbs->addItem(new LinkItem($parent->getTranslatedAttribute('name') . ' ' . $brand->getTranslatedAttribute('name'), route('brand.category', [$brand->getTranslatedAttribute('slug') ?? $brand->slug, $parent->getTranslatedAttribute('slug') ?? $parent->slug])));
        }

        // categories
        // $categories = Category::active()->parents()->with('children.children.children')->get();
        // $siblingCategories = Category::active()->where('parent_id', $category->parent_id)->get();
        $subcategories = Category::active()->where('parent_id', $category->id)
            ->withTranslation($locale)
            ->orderBy('order')
            ->get();

        // current and its parent category ids
        $activeCategoryIds = Helper::activeCategories($category);

        $breadcrumbs->addItem(new LinkItem($category->getTranslatedAttribute('name') . ' ' . $brand->getTranslatedAttribute('name'), route('brand.category', [$brand->getTranslatedAttribute('slug') ?? $brand->slug, $category->getTranslatedAttribute('slug') ?? $category->slug]), LinkItem::STATUS_INACTIVE));

        return view('categories.show_brand', compact('breadcrumbs', 'products', 'showingResults', 'productAllQuantity', 'category', 'brand', 'brandCategoryText', 'activeCategoryIds', 'subcategories', 'links', 'total', 'attributes', 'quantity', 'quantityPerPage', 'sorts', 'sortCurrent', 'productView', 'categoryAttributes', 'categoryPrices', 'prices', 'microdata'));
    }

}
