<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeValue;
use App\Helpers\Breadcrumbs;
use App\Helpers\Helper;
use App\Helpers\LinkItem;
use App\Page;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Helpers\Rating;
use App\Shop;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\AggregateRating;
use Spatie\SchemaOrg\Schema;

class ProductController extends Controller
{

    /**
     * show products per page values
     */
    public $quantityPerPage = [30, 60, 120];
    public $sorts = ['created_at-desc', 'price-asc', 'views-desc'];

    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index()
    {
        //
    }

    public function view(Request $request, Product $product, $slug)
    {
        Helper::checkModelActive($product);

        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $product->load('translations');

        // check slug
        if ($product->getTranslatedAttribute('slug') != $slug) {
            abort(404);
        }

        // $currentRegionID = Helper::getCurrentRegionID();
        $currentRegion = Helper::getCurrentRegion();
        $warehouseIDs = $currentRegion->warehouses->pluck('id')->toArray();

        $product->increment('views');

        $latestViewedProductIDs = Cache::get('latest_viewed_products_ids');
        if ($latestViewedProductIDs) {
            $latestViewedProductIDs = explode(',', $latestViewedProductIDs);
            array_unshift($latestViewedProductIDs, $product->id);
            if (count($latestViewedProductIDs) >= 100) {
                $latestViewedProductIDs = array_slice($latestViewedProductIDs, 0, 100);
            }
            $latestViewedProductIDs = implode(',', $latestViewedProductIDs);
        } else {
            $latestViewedProductIDs = $product->id;
        }
        Cache::put('latest_viewed_products_ids', $latestViewedProductIDs);

        $productGroup = $product->productGroup;
        if ($productGroup) {
            $productGroup->load(['products' => function($q){
                $q->with(['attributes', 'attributeValues.attribute']);
            }]);
        }

        $brand = $product->brand;
        if ($brand) {
            $brand->load('translations');
        }

        // $shop = $product->shop;
        // $shop->load('translations');

        // category
        $category = $product->categories->first();
        if (!empty($category)) {
            if (!empty($category->parent)) {
                $parent = $category->parent;
                $parent->load('translations');
                $breadcrumbs->addItem(new LinkItem($parent->getTranslatedAttribute('name'), $parent->url));
            }
            $category->load('translations');
            $breadcrumbs->addItem(new LinkItem($category->getTranslatedAttribute('name'), $category->url));
        }

        $prev = $product->similar()->active()->where('products.id', '<', $product->id)->withTranslation($locale)->orderBy('products.id', 'desc')->first();
        $next = $product->similar()->active()->where('products.id', '>', $product->id)->withTranslation($locale)->orderBy('products.id', 'asc')->first();

        // reviews
        $reviewsQuery = $product->reviews()->active();
        $reviewsQuantity = $reviewsQuery->count();
        $reviews = $reviewsQuery->latest()->take(20)->get();

        // attributes
        $attributeValueIds = $product->attributeValuesIds();
        $attributes = $product->attributesOrdered()->withTranslation($locale)->with(['attributeValues' => function($q1) use ($attributeValueIds, $locale) {
            $q1->whereIn('id', $attributeValueIds)->withTranslation($locale);
        }])->get();
        // $breadcrumbs->addItem(new LinkItem($product->name, $product->url, LinkItem::STATUS_INACTIVE));

        // SEO templates
        // $product = Helper::seoTemplate($product, 'product', ['name' => $product->name]);

        $microdata = Schema::product();
        $microdata->name($product->getTranslatedAttribute('name'));
        $microdata->sku($product->sku);
        if (!empty($brand)) {
            $microdata->brand($brand->getTranslatedAttribute('name'));
        }
        $microdata->image($product->img);
        $productBody = (string)$product->getTranslatedAttribute('body');
        $microdata->description(Str::limit(strip_tags($productBody), 200, '...'));
        if ($product->rating_count > 0) {
            $aggregateRating = new AggregateRating();
            $aggregateRating->worstRating(1)->bestRating(5)->ratingCount($product->rating_count)->ratingValue($product->rating_avg);
            $microdata->aggregateRating($aggregateRating);
        }
        $offer = Schema::offer();
        $offer->url($product->url);
        $offer->price($product->current_price);
        $offer->priceCurrency('UZS');
        $offer->priceValidUntil(now()->addMonths(3)->format('Y-m-d'));
        if ($product->getStock() > 0) {
            $offer->availability('https://schema.org/InStock');
        } else {
            $offer->availability('https://schema.org/OutOfStock');
        }
        $microdata->offers($offer);
        $microdata = $microdata->toScript();

        $deliveryText = Helper::staticText('work_hours', 300)->getTranslatedAttribute('description');
        $freeDeliveryText = Helper::staticText('work_hours', 300)->getTranslatedAttribute('description');
        $receiveMethodsText = Helper::staticText('work_hours', 300)->getTranslatedAttribute('description');
        $guaranteeText = Helper::staticText('work_hours', 300)->getTranslatedAttribute('description');
        $paymentText = Helper::staticText('work_hours', 300)->getTranslatedAttribute('description');

        // $faqPages = Page::active()->withTranslation($locale)->whereIn('id', [8, 9, 10, 11])->get();
        $paymentStaticPage = Page::active()->withTranslation($locale)->where('id', 8)->first();

        $isAvailable = $product->isAvailable();
        $isDiscounted = $product->isDiscounted();

        $seoReplacements = [
            'name' => $product->name,
            'price' => Helper::formatPrice($product->current_price),
            'brand_name' => $product->brand->name ?? '',
            'year' => date('Y'),
        ];

        $seoTitle = $product->seo_title ?: Helper::seo('product', 'seo_title', $seoReplacements);
        $metaDescription = $product->meta_description ?: Helper::seo('product', 'meta_description', $seoReplacements);
        $metaKeywords = $product->meta_keywords ?: Helper::seo('product', 'meta_keywords', $seoReplacements);

        $data = compact('breadcrumbs', 'product', 'productGroup', 'brand', 'category', 'attributes', 'reviewsQuantity', 'reviews', 'microdata', 'prev', 'next', 'deliveryText', 'freeDeliveryText', 'receiveMethodsText', 'guaranteeText', 'paymentText', 'paymentStaticPage', 'isAvailable', 'isDiscounted', 'seoReplacements', 'seoTitle', 'metaDescription', 'metaKeywords');

        if ($request->input('json', '')) {
            return response()->json([
                'product_id' => $product->id,
                'product_url' => $product->url,
                'main' => view('product.partials.product_page_content', $data)->render(),
                'seo_itle' => $seoTitle,
                'meta_description' => $metaDescription,
                'meta_keywords' => $metaKeywords,
            ]);
        }

        return view('product.view', $data);
    }

    /* resources */
    public function show(Product $product)
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show')));
        $breadcrumbs->addItem(new LinkItem(__('main.products'), route('profile.products')));
        $breadcrumbs->addItem(new LinkItem(__('main.product'), route('products.show', $product->id), LinkItem::STATUS_INACTIVE));
        return view('product.show', compact('breadcrumbs', 'product'));
    }

    public function create()
    {
        $product = new Product();
        $categories = Category::active()->orderBy('name')->get();
        $category_id = request()->input('category_id', '');
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show')));
        $breadcrumbs->addItem(new LinkItem(__('main.products'), route('profile.products')));
        $breadcrumbs->addItem(new LinkItem(__('main.add'), route('products.create'), LinkItem::STATUS_INACTIVE));
        return view('product.create', compact('breadcrumbs', 'product', 'categories', 'category_id'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $user = auth()->user();
        $shop = $user->shops()->first();
        if (!$shop) {
            $shop = Shop::craete([
                'user_id' => $user->id,
                'name' => 'Shop',
            ]);
        }

        // set additional data
        $data['in_stock'] = $request->has('in_stock') ? 1 : 0;
        $data['slug'] = Str::slug($data['name']);
        $data['status'] = Product::STATUS_PENDING;
        $data['unique_code'] = uniqid();
        $data['user_id'] = $user->id;
        $data['shop_id'] = $shop->id;

        $product = Product::create($data);

        Helper::storeImage($product, 'image', 'products', Product::$imgSizes);

        Session::flash('message', __('main.data_saved') . '. ' . __('main.pending_moderator_review'));
        return redirect()->route('profile.products');
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->orderBy('name')->get();
        $category_id = request()->input('category_id', '');
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show')));
        $breadcrumbs->addItem(new LinkItem(__('main.products'), route('profile.products')));
        $breadcrumbs->addItem(new LinkItem(__('main.edit'), route('products.edit', $product->id), LinkItem::STATUS_INACTIVE));
        return view('product.edit', compact('breadcrumbs', 'product', 'categories', 'category_id'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validatedData($request);

        // set additional data
        $data['in_stock'] = $request->has('in_stock') ? 1 : 0;
        $data['status'] = Product::STATUS_PENDING;

        $product->update($data);

        Helper::storeImage($product, 'image', 'products', Product::$imgSizes);

        Session::flash('message', __('main.data_saved') . '. ' . __('main.pending_moderator_review'));
        return redirect()->route('profile.products');
    }

    public function destroy(Request $request, Product $product)
    {
        // TODO: delete image
        // Helper::deleteImage($product, 'image', Product::$imgSizes);

        $product->delete();


        Session::flash('message', __('main.data_deleted'));
        return redirect()->route('profile.products');
    }

    protected function validatedData(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:190',
            'price' => 'required|numeric|max:1000000000',
            'sale_price' => '',
            'description' => 'max:1000',
            'image' => 'sometimes|image|max:1000',
            'body' => '',
        ]);
        $data['sale_price'] = (float)$data['sale_price'];

        return $data;
    }


    public function attributesEdit(Product $product)
    {
        $this->authorize('update', $product);

        $attributes = Attribute::all();
        $attributeValueIds = $product->attributeValues()->pluck('attribute_value_id')->toArray();

        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addItem(new LinkItem(__('main.profile'), route('profile.show')));
        $breadcrumbs->addItem(new LinkItem(__('main.products'), route('profile.products')));
        $breadcrumbs->addItem(new LinkItem(__('main.edit'), route('products.edit', $product->id)));
        $breadcrumbs->addItem(new LinkItem(__('main.attributes'), route('products.attributes.edit', $product->id), LinkItem::STATUS_INACTIVE));

        return view('product.edit-attributes', compact('breadcrumbs', 'product', 'attributes', 'attributeValueIds'));
    }

    public function attributesUpdate(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $attributes = $request->input('attributes', []);

        // product attributes
        $productAttributes = [];
        foreach($attributes as $key => $attribute) {
            $productAttributes[$key] = [
                'used_for_variations' => (isset($attribute['used_for_variations']) && $attribute['used_for_variations']) ? 1 : 0,
            ];
        }
        $product->attributes()->sync($productAttributes);

        // product attribute values
        $productAttributeValues = [];
        foreach($attributes as $attribute) {
            $productAttributeValues = array_merge($productAttributeValues, $attribute['values']);
        }
        $product->attributeValues()->sync($productAttributeValues);

        return redirect()->back()->with([
            'message'    => __('main.attributes_saved'),
            'alert-type' => 'success',
        ]);
    }

    public function featured(Request $request)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $page = Page::active()->where('slug', 'featured')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // quantity per page
        $quantityPerPage = $this->quantityPerPage;
        $quantity = $request->input('quantity', $this->quantityPerPage[0]);
        if (!in_array($quantity, $this->quantityPerPage)) {
            $quantity = $this->quantityPerPage[0];
        }

        $query = Product::featured()->active()->latest();

        $productAllQuantity = $query->count();

        // get query products paginate
        $products = $query->withTranslation($locale)->paginate($quantity);
        $links = $products->links('partials.pagination');

        return view('featured', compact('page', 'breadcrumbs', 'products', 'productAllQuantity', 'links', 'quantity', 'quantityPerPage'));
    }

    public function sale(Request $request)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $categoryID = $request->input('category', null);
        $category = null;
        if ($categoryID) {
            $category = Category::where('id', $categoryID)->active()->withTranslation($locale)->firstOrFail();
        }

        $page = Page::active()->where('slug', 'sale')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // quantity per page
        $quantityPerPage = $this->quantityPerPage;
        $quantity = $request->input('quantity', $this->quantityPerPage[0]);
        if (!in_array($quantity, $this->quantityPerPage)) {
            $quantity = $this->quantityPerPage[0];
        }

        if ($category) {
            $query = $category->products();
        } else {
            $query = Product::query();
        }

        $query->active()->discounted()->latest();

        $productAllQuantity = $query->count();

        // get query products paginate
        $products = $query->withTranslation($locale)->paginate($quantity);
        $links = $products->links('partials.pagination');

        return view('sale', compact('page', 'breadcrumbs', 'category', 'products', 'productAllQuantity', 'links', 'quantity', 'quantityPerPage'));
    }

    public function newProducts(Request $request)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $categoryID = $request->input('category', null);
        $category = null;
        if ($categoryID) {
            $category = Category::where('id', $categoryID)->active()->withTranslation($locale)->firstOrFail();
        }

        $page = Page::active()->where('slug', 'new-products')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // quantity per page
        $quantityPerPage = $this->quantityPerPage;
        $quantity = $request->input('quantity', $this->quantityPerPage[0]);
        if (!in_array($quantity, $this->quantityPerPage)) {
            $quantity = $this->quantityPerPage[0];
        }

        if ($category) {
            $query = $category->products();
        } else {
            $query = Product::query();
        }

        $query->active()->latest();

        $productAllQuantity = $query->count();

        // get query products paginate
        $products = $query->withTranslation($locale)->paginate($quantity);
        $links = $products->links('partials.pagination');

        return view('new_products', compact('page', 'breadcrumbs', 'category', 'products', 'productAllQuantity', 'links', 'quantity', 'quantityPerPage'));
    }

    public function bestsellers(Request $request)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $categoryID = $request->input('category', null);
        $category = null;
        if ($categoryID) {
            $category = Category::where('id', $categoryID)->active()->withTranslation($locale)->firstOrFail();
        }

        $page = Page::active()->where('slug', 'bestsellers')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // quantity per page
        $quantityPerPage = $this->quantityPerPage;
        $quantity = $request->input('quantity', $this->quantityPerPage[0]);
        if (!in_array($quantity, $this->quantityPerPage)) {
            $quantity = $this->quantityPerPage[0];
        }

        if ($category) {
            $query = $category->products();
        } else {
            $query = Product::query();
        }

        $query->bestsellers()->active()->latest();

        $productAllQuantity = $query->count();

        // get query products paginate
        $products = $query->withTranslation($locale)->paginate($quantity);
        $links = $products->links('partials.pagination');

        return view('bestsellers', compact('page', 'breadcrumbs', 'category', 'products', 'productAllQuantity', 'links', 'quantity', 'quantityPerPage'));
    }

    public function latestViewed(Request $request)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $categoryID = $request->input('category', null);
        $category = null;
        if ($categoryID) {
            $category = Category::where('id', $categoryID)->active()->withTranslation($locale)->firstOrFail();
        }

        $page = Page::active()->where('slug', 'latest-viewed')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // quantity per page
        $quantityPerPage = $this->quantityPerPage;
        $quantity = $request->input('quantity', $this->quantityPerPage[0]);
        if (!in_array($quantity, $this->quantityPerPage)) {
            $quantity = $this->quantityPerPage[0];
        }

        if ($category) {
            $query = $category->products();
        } else {
            $query = Product::query();
        }

        $productAllQuantity = 0;
        $products = collect();
        $links = '';
        $latestViewedProductIDs = Cache::get('latest_viewed_products_ids');
        if ($latestViewedProductIDs) {
            $latestViewedProductIDs = explode(',', $latestViewedProductIDs);
            $query->whereIn('id', $latestViewedProductIDs);
            $query->active()->latest();

            $productAllQuantity = $query->count();

            // get query products paginate
            $products = $query->withTranslation($locale)->paginate($quantity);
            $links = $products->links('partials.pagination');
        }

        return view('latest_viewed', compact('page', 'breadcrumbs', 'category', 'products', 'productAllQuantity', 'links', 'quantity', 'quantityPerPage'));
    }

    public function promotionalProducts(Request $request)
    {
        $locale = app()->getLocale();
        $breadcrumbs = new Breadcrumbs();

        $categoryID = $request->input('category', null);
        $category = null;
        if ($categoryID) {
            $category = Category::where('id', $categoryID)->active()->withTranslation($locale)->firstOrFail();
        }

        $page = Page::active()->where('slug', 'promotional-products')->withTranslation($locale)->firstOrFail();
        $breadcrumbs->addItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));

        // quantity per page
        $quantityPerPage = $this->quantityPerPage;
        $quantity = $request->input('quantity', $this->quantityPerPage[0]);
        if (!in_array($quantity, $this->quantityPerPage)) {
            $quantity = $this->quantityPerPage[0];
        }

        if ($category) {
            $query = $category->products();
        } else {
            $query = Product::query();
        }

        $query->promotion()->active()->latest();

        $productAllQuantity = $query->count();

        // get query products paginate
        $products = $query->withTranslation($locale)->paginate($quantity);
        $links = $products->links('partials.pagination');

        return view('promotional_products', compact('page', 'breadcrumbs', 'category', 'products', 'productAllQuantity', 'links', 'quantity', 'quantityPerPage'));
    }

    public function print(Product $product)
    {
        $locale = app()->getLocale();

        $product->load('translations');

        $brand = $product->brand;
        if (!empty($brand)) {
            $brand->load('translations');
        }

        // attributes
        $attributeValueIds = $product->attributeValuesIds();
        $attributes = $product->attributesOrdered()->withTranslation($locale)->with(['attributeValues' => function($q1) use ($attributeValueIds, $locale) {
            $q1->whereIn('id', $attributeValueIds)->withTranslation($locale);
        }])->get();

        return view('product.print', compact('product', 'brand', 'attributes'));
    }
}
