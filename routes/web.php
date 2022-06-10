<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\Voyager\DeliverySettingsController;
use App\Http\Controllers\Voyager\ExportController;
use App\Http\Controllers\Voyager\ImportController;
use App\Http\Controllers\Voyager\StatusController;
use App\Http\Controllers\Voyager\VoyagerOrderController;
use App\Http\Controllers\Voyager\VoyagerProductController;
use App\Http\Controllers\Voyager\VoyagerProductGroupController;
use App\Http\Controllers\Voyager\VoyagerSubscriberController;
use App\Http\Controllers\Voyager\VoyagerUserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ZoodpayController;
use App\Http\Middleware\CheckRedirects;
use App\Http\Middleware\ForceLowercaseUrls;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Voyager admin routes
Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'auth'], function(){

        // delivery settings
        Route::get('/delivery-settings', [DeliverySettingsController::class, 'index'])->name('voyager.delivery_settings.index');
        Route::post('/delivery-settings/update', [DeliverySettingsController::class, 'update'])->name('voyager.delivery_settings.update');

        // status activate/deactivate
        Route::get('/status/activate', [StatusController::class, 'activate'])->name('voyager.status.activate');
        Route::get('/status/deactivate', [StatusController::class, 'deactivate'])->name('voyager.status.deactivate');

        // product attributes
        Route::get('/products/{product}/attributes/edit', [VoyagerProductController::class, 'attributesEdit'])->name('voyager.products.attributes.edit');
        Route::post('/products/{product}/attributes', [VoyagerProductController::class, 'attributesUpdate'])->name('voyager.products.attributes.update');

        // product groups
        Route::get('/product_groups/{product_group}/settings', [VoyagerProductGroupController::class, 'settings'])->name('voyager.product_groups.settings');
        Route::put('/product_groups/{product_group}/attributes/update', [VoyagerProductGroupController::class, 'attributesUpdate'])->name('voyager.product_groups.attributes.update');
        Route::put('/product_groups/{product_group}/attribute-values/update', [VoyagerProductGroupController::class, 'attributeValuesUpdate'])->name('voyager.product_groups.attribute_values.update');
        Route::get('/product_groups/{product_group}/products/create', [VoyagerProductGroupController::class, 'productsCreate'])->name('voyager.product_groups.products.create');
        Route::get('/product_groups/{product_group}/products', [VoyagerProductGroupController::class, 'productsIndex'])->name('voyager.product_groups.products.index');
        Route::post('/product_groups/{product_group}/products', [VoyagerProductGroupController::class, 'productsStore'])->name('voyager.product_groups.products.store');
        Route::post('/product_groups/{product_group}/products/{product}/detach', [VoyagerProductGroupController::class, 'productsDetach'])->name('voyager.product_groups.products.detach');

        // orders
        Route::post('/orders/{order}/delivery/store', [VoyagerOrderController::class, 'deliveryStore'])->name('voyager.orders.delivery.store');
        Route::post('/orders/{order}/refund/store', [VoyagerOrderController::class, 'refundStore'])->name('voyager.orders.refund.store');
        Route::post('/orders/{order}/status/update', [VoyagerOrderController::class, 'statusUpdate'])->name('voyager.orders.status.update');

        // import
        Route::get('/import', [ImportController::class, 'index'])->name('voyager.import.index');
        Route::post('/import/products', [ImportController::class, 'products'])->name('voyager.import.products');
        Route::post('/import/smartup/products', [ImportController::class, 'smartupProducts'])->name('voyager.import.smartup.products');

        // export
        Route::get('/export', [ExportController::class, 'index'])->name('voyager.export.index');
        Route::get('/export/products/store', [ExportController::class, 'productsStore'])->name('voyager.export.products.store');
        Route::get('/export/products/store/full', [ExportController::class, 'productsStoreFull'])->name('voyager.export.products.store.full');
        Route::post('/export/products/download', [ExportController::class, 'productsDownload'])->name('voyager.export.products.download');

        // download subscribers
        Route::get('/subscribers/download', [VoyagerSubscriberController::class, 'download'])->name('voyager.subscribers.download');

        // user
        Route::get('/users/{user}/api_tokens', [VoyagerUserController::class, 'apiTokens'])->name('voyager.users.api_tokens');
        Route::post('/users/{user}/api_tokens', [VoyagerUserController::class, 'apiTokensStore'])->name('voyager.users.api_tokens.store');
    });

    Voyager::routes();
});

// telegram bot
Route::post('telegram-bot-nWq723bZP7x5cfF', [TelegramBotController::class, 'index'])->name('telegram-bot');
Route::get('telegram-bot/sethook-nWq723bZP7x5cfF', [TelegramBotController::class, 'sethook'])->name('telegram-bot.sethook');
Route::get('telegram-bot/deletehook-nWq723bZP7x5cfF', [TelegramBotController::class, 'deletehook'])->name('telegram-bot.deletehook');

// Payment
Route::post('paycom-xBrGbjU2RyaNwBY', [PaymentGatewayController::class, 'paycom'])->name('payment-gateway.paycom');
Route::any('click-SVNfd45qbr5dW9b/prepare', [PaymentGatewayController::class, 'click'])->name('payment-gateway.click.prepare');
Route::any('click-SVNfd45qbr5dW9b/complete', [PaymentGatewayController::class, 'click'])->name('payment-gateway.click.complete');
Route::any('zoodpay-fzYHsjSXMJ5U2G6q', [PaymentGatewayController::class, 'zoodpay'])->name('payment-gateway.zoodpay');

Route::get('testing-29szTThmfP35dFx', [TestingController::class, 'index'])->name('testing.index');

// synchronization
// Route::post('synchro/torgsoft-LYtkVn6MhH2TqdhK', [SynchroController::class, 'torgsoft'])->name('synchro.torgsoft');
// Route::get('synchro/torgsoft', [SynchroController::class, 'torgsoft'])->name('synchro.torgsoft.get');

// Localized site routes
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ /*'localeSessionRedirect', */'localizationRedirect', 'localeViewPath', 'localize', ForceLowercaseUrls::class, CheckRedirects::class  ]
    ],  function() {

    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    // Route::group(['middleware' => ['auth']], function() {

    // home page
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home/latest-products/{category}', [HomeController::class, 'latestProducts'])->name('home.latest-products');

    // zoodpay create transaction
    Route::post('zoodpay/transaction/store', [ZoodpayController::class, 'transactionStore'])->name('zoodpay.transaction.store');

    // sitemap
    Route::get('/sitemap/index', [SitemapController::class, 'index'])->name('sitemap.index');
    Route::get('/sitemap/create', [SitemapController::class, 'create'])->name('sitemap.create');

    // search
    Route::get('search', [SearchController::class, 'index'])->name('search');
    Route::get('search/ajax', [SearchController::class, 'ajax'])->name('search.ajax');

    // contacts
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts');
    Route::post('contacts/send', [ContactController::class, 'send'])->name('contacts.send');
    Route::post('contacts/send/installment-payment', [ContactController::class, 'sendInstallmentPayment'])->name('contacts.send.installment-payment');

    // subscriber
    Route::post('subscriber/subscribe', [SubscriberController::class, 'subscribe'])->name('subscriber.subscribe');
    Route::get('subscriber/unsubscribe', [SubscriberController::class, 'unsubscribe'])->name('subscriber.unsubscribe');

    // vacancies
    Route::get('vacancies', [VacancyController::class, 'index'])->name('vacancies.index');
    Route::get('vacancy-categories/{vacancyCategory}', [VacancyController::class, 'category'])->name('vacancies.category');
    Route::get('vacancies/{vacancy}-{slug}', [VacancyController::class, 'show'])->name('vacancies.show');

    // services
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('services/{vacancy}-{slug}', [ServiceController::class, 'show'])->name('services.show');

    // employees
    Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('employees/{vacancy}-{slug}', [EmployeeController::class, 'show'])->name('employees.show');

    // partners
    Route::get('partners', [PartnerController::class, 'index'])->name('partners.index');
    Route::get('partners/{vacancy}-{slug}', [PartnerController::class, 'show'])->name('partners.show');

    // brand view
    Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('brand/{brand}-{slug}', [BrandController::class, 'show'])->name('brands.show');

    // product view
    Route::get('product/{product}-{slug}', [ProductController::class, 'view'])->name('product');
    Route::get('product/{product}-{slug}/print', [ProductController::class, 'print'])->name('product.print');
    Route::get('sale', [ProductController::class, 'sale'])->name('sale');
    Route::get('promotions', [ProductController::class, 'promotions'])->name('promotions');
    Route::get('featured', [ProductController::class, 'featured'])->name('featured');
    Route::get('new-products', [ProductController::class, 'newProducts'])->name('new-products');
    Route::get('bestsellers', [ProductController::class, 'bestsellers'])->name('bestsellers');
    Route::get('latest-viewed', [ProductController::class, 'latestViewed'])->name('latest-viewed');
    Route::get('promotional-products', [ProductController::class, 'promotionalProducts'])->name('promotional-products');

    // products routes
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}/', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}/', [ProductController::class, 'destroy'])->name('products.destroy');

    // product attributes
    Route::get('products/{product}/attributes/edit', [ProductController::class, 'attributesEdit'])->name('products.attributes.edit');
    Route::post('products/{product}/attributes', [ProductController::class, 'attributesUpdate'])->name('products.attributes.update');

    // reviews
    Route::post('reviews/store', [ReviewController::class, 'store'])->name('reviews.store');

    // polls
    Route::get('polls', [PollController::class, 'index'])->name('polls');
    Route::get('polls/{poll}', [PollController::class, 'show'])->name('polls.show');
    Route::post('polls/{poll}/vote', [PollController::class, 'vote'])->name('polls.vote');

    // publications pages
    Route::get('news', [PublicationController::class, 'news'])->name('news');
    Route::get('articles', [PublicationController::class, 'articles'])->name('articles');
    // Route::get('promotions', [PublicationController::class, 'promotions'])->name('promotions');
    // Route::get('video', [PublicationController::class, 'videos'])->name('video');
    // Route::get('events', [PublicationController::class, 'events'])->name('events');
    // Route::get('faq', [PublicationController::class, 'faq'])->name('faq');
    // Route::get('competitions', [PublicationController::class, 'competitions'])->name('competitions');
    // Route::get('projects', [PublicationController::class, 'projects'])->name('projects');
    // Route::get('ads', [PublicationController::class, 'ads'])->name('ads');
    // Route::get('mass-media', [PublicationController::class, 'massMedia'])->name('mass-media');
    // Route::get('useful-links', [PublicationController::class, 'usefulLinks'])->name('useful-links');
    Route::get('publications/{publication}-{slug}', [PublicationController::class, 'show'])->name('publications.show');
    Route::get('publications/{publication}/increment/views', [PublicationController::class, 'incrementViews'])->name('publications.increment.views');
    Route::get('publications/{publication}-{slug}/print', [PublicationController::class, 'print'])->name('publications.print');

    // banner statistics routes
    Route::get('banner/{banner}/increment/clicks', [BannerController::class, 'incrementClicks'])->name('banner.increment.clicks');
    Route::get('banner/{banner}/increment/views', [BannerController::class, 'incrementViews'])->name('banner.increment.views');
    // });

    // cart routes
    Route::get('cart', [CartControllerr::class, 'index'])->name('cart.index');
    Route::get('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart', [CartController::class, 'add'])->name('cart.add');
    Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('cart/conditions', [CartController::class, 'addCondition'])->name('cart.addCondition');
    Route::delete('cart/conditions', [CartController::class, 'clearCartConditions'])->name('cart.clearCartConditions');
    Route::get('cart/debug', [CartController::class, 'debug'])->name('cart.debug');

    // wishlist routes
    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('wishlist', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('wishlist/{id}', [WishlistController::class, 'delete'])->name('wishlist.delete');

    // compare routes
    Route::get('compare', [CompareController::class, 'index'])->name('compare.index');
    Route::post('compare', [CompareController::class, 'add'])->name('compare.add');
    Route::delete('compare/{id}', [CompareController::class, 'delete'])->name('compare.delete');

    // order routes
    Route::get('order/{order}-{check}', [OrderController::class, 'show'])->name('order.show');
    Route::get('order/{order}-{check}/print', [OrderController::class, 'print'])->name('order.print');
    Route::post('order', [OrderController::class, 'add'])->name('order.add');

    // profile routes
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::get('profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('profile/products', [ProfileController::class, 'products'])->name('profile.products');
    Route::get('profile/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications.index');
    Route::get('profile/notifications/{notification}', [ProfileController::class, 'notificationsShow'])->name('profile.notifications.show');
    Route::get('profile/shop/edit', [ProfileController::class, 'shopEdit'])->name('profile.shop.edit');
    Route::put('profile/shop', [ProfileController::class, 'shopUpdate'])->name('profile.shop.update');
    Route::get('profile/request-seller-status', [ProfileController::class, 'requestSellerStatus'])->name('profile.request-seller-status');

    Route::group(['middleware' => ['auth']], function() {
        Route::get('addresses/{address}/status/{status}', [AddressController::class, 'statusUpdate'])->name('addresses.status.update');
        Route::resource('addresses', 'AddressController');
    });

    // shop routes
    Route::get('shops', [ShopController::class, 'index'])->name('shop.index');
    Route::get('shop/{shop}', [ShopController::class, 'show'])->name('shop.show');

    // auth routes
    Auth::routes(['verify' => true]);
    // Auth::routes(['verify' => false]);

    // custom auth routes (phone registration)
    Route::get('register/verify', [RegisterController::class, 'showRegistrationVerifyForm'])->name('register.verify');
    Route::post('register/verify', [RegisterController::class, 'registerVerify'])->middleware('throttle:10,60');

    Route::get('password/phone', [ForgotPasswordController::class, 'showLinkRequestPhoneForm'])->name('password.phone');
    Route::post('password/phone', [ForgotPasswordController::class, 'passwordPhone']);
    Route::get('password/phone/verify', [ForgotPasswordController::class, 'showPasswordPhoneVerifyForm'])->name('password.phone.verify');
    Route::post('password/phone/verify', [ForgotPasswordController::class, 'passwordPhoneVerify'])->middleware('throttle:10,60');

    // regular pages
    Route::get('pages/{page}-{slug}', [PageController::class, 'show'])->name('pages.show');
    Route::get('guestbook', [PageController::class, 'guestbook'])->name('guestbook');
    // Route::get('{slug}', [PageController::class, 'index'])->name('page');
    Route::get('pages/{page}-{slug}/print', [PageController::class, 'print'])->name('page.print');

    // category view
    Route::get('categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('{slug}', [CategoryController::class, 'show'])->name('category');
    // Route::get('category/{category}-{slug}', [CategoryController::class, 'show'])->name('category');
    Route::get('{brand_slug}/{category_slug}', [CategoryController::class, 'showBrand'])->name('brand.category');
});

// non localized routes

// captcha
Route::get('/refereshcaptcha', [HelperController::class, 'refereshCaptcha']);

// cache clear and optimize
Route::get('/cache/optimize/{check}', [CacheController::class, 'optimize'])->name('cache.optimize');
Route::get('/cache/view/clear/{check}', [CacheController::class, 'viewClear'])->name('cache.view.clear');

// region
Route::post('/region/set', [RegionController::class, 'set'])->name('region.set');
