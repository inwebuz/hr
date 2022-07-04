<?php

namespace App\Helpers;

use App\Banner;
use App\BannerStats;
use App\Category;
use App\Page;
use App\Region;
use App\Review;
use App\Service;
use App\Setting;
use App\StaticText;
use App\Vacancy;
use App\VacancyCategory;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Parsedown;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\Setting as ModelsSetting;
use Throwable;

class Helper
{

    public static function formatNumber($number)
    {
        return number_format($number, 0, '.', ' ');
    }

    public static function formatPrice($number)
    {
        return self::formatNumber($number) . ' ' . __('main.currency');
    }

    public static function formatDate(Carbon $date, $year = false)
    {
        $yearFormat = ($year) ? ', Y' : '';
        return __($date->format('F')) . ' ' . $date->format('d' . $yearFormat);
    }

    public static function formatDateSecond(Carbon $date)
    {
        return '<div>' . $date->format('d') . '</div><div>' . __($date->format('F')) . '</div>';
    }

    public static function formatViews($views = 0)
    {
        $text = $views . ' <span class="d-none d-lg-inline">';
        if (Str::endsWith($views, [11, 12, 13, 14])) {
            $text .= 'просмотров';
        } elseif (Str::endsWith($views, [2, 3, 4])) {
            $text .= 'просмотра';
        } elseif (Str::endsWith($views, 1)) {
            $text .= 'просмотр';
        } else {
            $text .= 'просмотров';
        }
        return $text . '</span>';
    }

    public static function formatOffers($offers = 0)
    {
        $text = $offers . ' ';
        if (Str::endsWith($offers, [11, 12, 13, 14])) {
            $text .= 'предложений';
        } elseif (Str::endsWith($offers, [2, 3, 4])) {
            $text .= 'предложения';
        } elseif (Str::endsWith($offers, 1)) {
            $text .= 'предложение';
        } else {
            $text .= 'предложений';
        }
        return $text;
    }

    public static function menuItems($type = '')
    {
        $locale = app()->getLocale();
        $menu = [];
        $query = Page::active();
        if ($type == 'header') {
            $query->inHeaderMenu();
        } elseif ($type == 'footer') {
            $query->inFooterMenu();
        }
        $pages = $query->whereNull('parent_id')
            ->orderBy('order')
            ->with(['pages' => function ($q) use ($locale) {
                $q->active()->with(['pages' => function ($q1) use ($locale) {
                    $q1->active()->withTranslation($locale);
                }])
                ->withTranslation($locale);
            }])
            ->withTranslation($locale)
            ->get();
        if (!$pages->isEmpty()) {
            foreach ($pages as $page) {
                $item = new MenuItem(new LinkItem($page->getTranslatedAttribute('name'), $page->url));
                $subPages = $page->pages;
                if ($page->slug == 'services') {
                    $services = Service::active()->orderBy('order')->withTranslation($locale)->get();
                    foreach ($services as $service) {
                        $item->addItem(new MenuItem(new LinkItem($service->getTranslatedAttribute('name'), $service->url)));
                    }
                } elseif ($page->slug == 'vacancies') {
                    $vacancyCategories = VacancyCategory::active()
                        ->whereNull('parent_id')
                        ->orderBy('order')
                        ->withTranslation($locale)
                        // ->with(['children' => function($query) use ($locale) {
                        //     $query->active()->orderBy('order')->withTranslation($locale);
                        // }])
                        ->get();
                    foreach ($vacancyCategories as $vacancyCategory) {
                        $menuItem = new MenuItem(new LinkItem($vacancyCategory->getTranslatedAttribute('name'), $vacancyCategory->url));
                        // if (!$vacancyCategory->children->isEmpty()) {
                        //     foreach ($vacancyCategory->children as $child) {
                        //         $menuItem->addItem(new LinkItem($child->getTranslatedAttribute('name'), $child->url));
                        //     }
                        // }
                        $item->addItem($menuItem);

                    }
                }
                if (!$subPages->isEmpty()) {
                    foreach ($subPages as $subPage) {
                        $subPageItem = new MenuItem(new LinkItem($subPage->getTranslatedAttribute('name'), $subPage->url));
                        $subPagePages = $subPage->pages;
                        if (!$subPagePages->isEmpty()) {
                            foreach ($subPagePages as $subPagePage) {
                                $subPagePageItem = new MenuItem(new LinkItem($subPagePage->getTranslatedAttribute('name'), $subPagePage->url));
                                $subPageItem->addItem($subPagePageItem);
                            }
                        }
                        $item->addItem($subPageItem);
                    }
                }
                $menu[] = $item;
            }
        }
        return $menu;
    }

    public static function categories($type = 'parents', $limit = 0, $parentIDs = [], $allIDs = [])
    {
        $showIn = false;
        if ($type == 'menu') {
            $showIn = [Category::SHOW_IN_MENU, Category::SHOW_IN_EVERYWHERE];
        }
        if ($type == 'home') {
            $showIn = [Category::SHOW_IN_HOME, Category::SHOW_IN_EVERYWHERE];
        }
        $locale = app()->getLocale();
        $query = Category::active()
            ->withTranslation($locale)
            ->where('order', '>', 0)
            ->orderBy('order');
        if ($parentIDs) {
            $query->whereIn('id', $parentIDs);
        }
        if ($allIDs) {
            $query->whereIn('id', $allIDs);
        }
        if ($showIn) {
            $query->whereIn('show_in', $showIn);
        }
        if ($type == 'menu') {
            $query
                ->whereNull('parent_id')
                ->with(['children' => function ($q1) use ($locale, $showIn, $allIDs) {
                    $q1
                        ->active()
                        ->withTranslation($locale)
                        ->whereIn('show_in', $showIn)
                        ->orderBy('order')
                        ->with(['children' => function ($q2) use ($locale, $showIn, $allIDs) {
                            $q2
                                ->active()
                                ->withTranslation($locale)
                                ->orderBy('order')
                                ->whereIn('show_in', $showIn);
                            if ($allIDs) {
                                $q2->whereIn('id', $allIDs);
                            }
                        }]);
                    if ($allIDs) {
                        $q1->whereIn('id', $allIDs);
                    }
                }]);
        }
        if ($type == 'parents') {
            $query
                ->whereNull('parent_id')
                ->with(['children' => function ($q1) use ($locale) {
                    $q1
                        ->active()
                        ->withTranslation($locale)
                        ->orderBy('order')
                        ->with(['children' => function ($q2) use ($locale) {
                            $q2
                                ->active()
                                ->withTranslation($locale)
                                ->orderBy('order');
                        }]);
                }]);
        }
        if ($limit > 0) {
            $query->take($limit);
        }
        $query->with(['banners' => function($q1) use ($locale) {
            $q1->withTranslation($locale);
        }]);
        $categories = $query->get();
        return $categories;
    }

    public static function banner($type)
    {
        $locale = app()->getLocale();
        // $banner = Banner::where('type', $type)->active()->nowActive()->latest()->first();
        $banner = Banner::where('type', $type)->whereNull('category_id')->active()->nowActive()->withTranslation($locale)->latest()->first();
        if (!$banner) {
            $banner = Banner::where([['type', $type], ['shop_id', null], ['category_id', null]])->withTranslation($locale)->active()->latest()->first();
        }
        if (!$banner) {
            $banner = new Banner(['id' => 0, 'name' => '1', 'url' => '', 'image' => 'no-image.jpg']);
        }
        return $banner;
    }

    public static function banners($type)
    {
        $locale = app()->getLocale();
        // $banners = Banner::where('type', $type)->active()->nowActive()->latest()->get();
        $banners = Banner::where('type', $type)->whereNull('category_id')->active()->withTranslation($locale)->latest()->get();
        if (!$banners) {
            $banners = Banner::where([['type', $type], ['shop_id', null], ['category_id', null]])->active()->withTranslation($locale)->latest()->get();
        }
        return $banners;
    }

    public static function markdownToHtml($string)
    {
        $parsedown = new Parsedown();
        return $parsedown->text($string);
    }
    /**
     * Update currencies
     *
     * @return void
     */
    public static function updateCurrencies()
    {
        $currencies = ModelsSetting::whereIn('key', ['currency.usd', 'currency.eur'])->get();
        foreach ($currencies as $currency) {
            $currencyShortCode = mb_strtoupper(str_replace('currency.', '', $currency->key));
            try {
                $client = new Client([
                    'base_uri' => 'http://cbu.uz/uzc/arkhiv-kursov-valyut/',
                    'timeout' => 2.0,
                ]);
                $response = $client->get('xml/' . $currencyShortCode . '/');
                $xml = new \SimpleXMLElement($response->getBody()->getContents());
                $currency->value = $xml->CcyNtry->Rate;
                $currency->save();
            } catch (\Exception $e) {
            }
        }
    }

    public static function phone($phone)
    {
        $phone = preg_replace('#[^\d]#', '', $phone);
        if (Str::startsWith($phone, '998')) {
            $phone = '+' . $phone;
        }
        return $phone;
    }

    public static function reformatPhone($phone)
    {
        $phone = preg_replace('#[^\d]#', '', $phone);
        if (mb_strlen($phone) == 9) {
            $phone = '998' . $phone;
        }
        return $phone;
    }

    public static function parsePhones($phones)
    {
        $parsed = [];
        $phones = str_replace([';'], ',', $phones);
        $phones = explode(',', $phones);
        foreach ($phones as $phone) {
            $parsed[] = [
                'original' => $phone,
                'clean' => self::phone($phone),
            ];
        }
        return $parsed;
    }

    public static function reformatText($text)
    {
        return preg_replace(['#\*(.*?)\*#', '#\#(.*?)\##', '#\|\|#'], ['<strong>$1</strong>', '<span class="text-primary">$1</span>', '<br>'], $text);
    }

    public static function formatWorkDays($days)
    {
        $days = explode(',', preg_replace('#[^0-9,]#', '', $days));
        $days = array_map('intval', $days);
        $daysStatus = [];
        for ($i = 1; $i <= 7; $i++) {
            $daysStatus[$i] = in_array($i, $days) ? true : false;
        }
        return $daysStatus;
    }

    /**
     *
     * @return array
     */
    public static function languageSwitcher()
    {
        $route = Route::current();
        $routeName = Route::currentRouteName();
        $switcher = new LanguageSwitcher();
        $currentLocale = app()->getLocale();
        $defaultLocale = config('voyager.multilingual.default');

        $model = null;
        $foundModel = false;
        $hasSlugRoutes = ['page', 'category', 'publications.show', 'product'];
        foreach ($hasSlugRoutes as $hasSlugRoute) {
            if ($routeName == $hasSlugRoute) {
                $routeParams = array_values($route->parameters);
                $model = array_shift($routeParams);
                if (!is_object($model)) {
                    continue;
                }
                $foundModel = true;
                break;
            }
        }

        $onlySlugRoutes = ['category' => Category::class];
        foreach ($onlySlugRoutes as $key => $modelClass) {
            if ($routeName == $key) {
                $routeParams = array_values($route->parameters);
                $slug = array_shift($routeParams);
                if ($currentLocale == $defaultLocale) {
                    $model = $modelClass::where('slug', $slug)->first();
                } else {
                    $model = $modelClass::whereTranslation('slug', '=', $slug, [$currentLocale], false)->withTranslation($currentLocale)->first();
                }
                if (!is_object($model)) {
                    continue;
                }
                $foundModel = true;
                break;
            }
        }

        if ($foundModel && $model) {
            foreach (config('laravellocalization.supportedLocales') as $key => $value) {
                $value['url'] = $model->getURL($key);
                $linkItem = new LinkItem($value['native'], $value['url']);
                $linkItem->key = $key;
                if ($key == $currentLocale) {
                    $switcher->setActive($linkItem);
                }
                $switcher->addValue($linkItem);
            }
        } else {
            $url = url()->current();
            foreach (config('laravellocalization.supportedLocales') as $key => $value) {
                $value['url'] = LaravelLocalization::localizeURL($url, $key);
                $linkItem = new LinkItem($value['native'], $value['url']);
                $linkItem->key = $key;
                if ($key == $currentLocale) {
                    $switcher->setActive($linkItem);
                }
                $switcher->addValue($linkItem);
            }
        }

        return $switcher;
    }

    public static function getActiveLanguageRegional()
    {
        $currentLocale = app()->getLocale();
        $locales = config('laravellocalization.supportedLocales');
        return $locales[$currentLocale]['regional'];
    }

    public static function translation($model)
    {
        if (!$model) {
            return false;
        }
        if (app()->getLocale() != config('voyager.multilingual.default')) {
            return $model->translate();
        }
        return $model;
    }

    /**
     * Send message via telegram bot to group
     */
    public static function toTelegram($text, $parse_mode = 'HTML', $chat_id = '')
    {
        $token = config('services.telegram.bot_token');

        if (!$chat_id) {
            $chat_id = config('services.telegram.chat_id');
        }

        $formData = [];
        $formData['chat_id'] = $chat_id;
        $formData['text'] = $text;
        if (in_array($parse_mode, ['HTML', 'Markdown'])) {
            $formData['parse_mode'] = $parse_mode;
        }

        try {
            $client = new Client([
                'base_uri' => 'https://api.telegram.org',
                'timeout' => 2.0,
            ]);

            $client->post('/bot' . $token . '/sendMessage', [
                'form_params' => $formData,
            ]);
        } catch (Exception $e) {
        }
    }

    /**
     * Send message via telegram bot to group
     */
    public static function documentToTelegram($filePath, $fileName, $caption, $parse_mode = 'HTML', $chat_id = '')
    {
        $token = config('services.telegram.bot_token');

        if (!$chat_id) {
            $chat_id = config('services.telegram.chat_id');
        }
        if (!in_array($parse_mode, ['HTML', 'Markdown'])) {
            $parse_mode = 'HTML';
        }

        $multiparData = [
            [
                'name'     => 'chat_id',
                'contents' => $chat_id,
            ],
            [
                'name'     => 'caption',
                'contents' => $caption,
            ],
            [
                'name'     => 'document',
                'contents' => fopen($filePath, 'r'),
                'filename' => $fileName,
            ],
            [
                'name'     => 'parse_mode',
                'contents' => $parse_mode,
            ],
        ];

        try {
            $client = new Client([
                'base_uri' => 'https://api.telegram.org',
                'timeout'  => 2.0,
            ]);

            $result = $client->post('/bot' . $token . '/sendDocument', [
                'multipart' => $multiparData,
            ]);
            // Log::info($result);
        } catch (Exception $e) {
            Log::info(print_r($e, true));
        }
    }

    public static function storeFile($model, $field, $dir, $isImage = false)
    {
        if (request()->has($field)) {
            $url = request()->$field->store($dir . '/' . date('FY'), 'public');
            if (!$isImage) {
                $url = json_encode([
                    [
                        'download_link' => $url,
                        'original_name' => request()->$field->getClientOriginalName(),
                    ]
                ]);
            }
            $model->$field = $url;
            $model->save();
        }
        return $model;
    }

    public static function storeImage($model, $field, $dir, $thumbs = [])
    {
        $model = self::storeFile($model, $field, $dir, true);
        if ($thumbs && $model->$field) {
            $image = Image::make(storage_path('app/public/' . $model->$field));
            $image->backup();
            if ($image) {
                $ext = mb_strrchr($model->$field, '.');
                $pos = mb_strrpos($model->$field, '.');
                $fileName = mb_substr($model->$field, 0, $pos);
                foreach ($thumbs as $key => $value) {
                    $image->fit($value[0], $value[1])->save(storage_path('app/public/' . $fileName . '-' . $key . $ext));
                    $image->reset();
                }
            }
        }
        return $model;
    }

    public static function storeImageFromUrl($url, $model, $field, $dir, $thumbs = [], $multipleField = false)
    {
        // check name
        $name = substr($url, strrpos($url, '/') + 1);
        // no extension
        if (strpos($name, '.') === false) {
            return $model;
        }

        // get contents
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        try {
            $contents = file_get_contents($url, false, stream_context_create($arrContextOptions));
        } catch (Throwable $e) {
            return $model;
        }

        // save file
        $fieldValue = $dir . '/' . date('FY') . '/' . $model->id . '/' . $name;
        Storage::disk('public')->put($fieldValue, $contents);

        // check mime type
        $mime = mime_content_type(Storage::disk('public')->path($fieldValue));
        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            Storage::disk('public')->delete($fieldValue);
            return $model;
        }

        // save model
        if (!$multipleField) {
            $model->$field = $fieldValue;
        } else {
            $multipleFieldValue = json_decode($model->$field);
            if (!is_array($multipleFieldValue)) {
                $multipleFieldValue = [];
            }
            $multipleFieldValue[] = $fieldValue;
            $model->$field = json_encode($multipleFieldValue);
        }
        // User::withoutEvents(function () use () {
        //     User::findOrFail(1)->delete();

        //     return User::find(2);
        // });
        get_class($model)::withoutEvents(function () use ($model) {
            $model->save();
        });

        // create thumbs
        if ($thumbs) {
            $image = Image::make(storage_path('app/public/' . $fieldValue));
            $image->backup();
            if ($image) {
                $ext = mb_strrchr($fieldValue, '.');
                $pos = mb_strrpos($fieldValue, '.');
                $fileName = mb_substr($fieldValue, 0, $pos);
                foreach ($thumbs as $key => $value) {
                    $image->fit($value[0], $value[1])->save(storage_path('app/public/' . $fileName . '-' . $key . $ext));
                    $image->reset();
                }
            }
        }
        return $model;
    }

    public static function storeImagesFromUrl($urls, $model, $field, $dir, $thumbs = [])
    {
        $fieldValues = [];
        foreach ($urls as $url) {
            $contents = file_get_contents($url);
            $name = substr($url, strrpos($url, '/') + 1);
            // no extension
            if (strpos($name, '.') === false) {
                continue;
            }
            // save file
            $fieldValue = $dir . '/' . date('FY') . '/' . $model->id . '/' . $name;
            Storage::disk('public')->put($fieldValue, $contents);

            $mime = mime_content_type(Storage::disk('public')->path($fieldValue));
            if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
                Storage::disk('public')->delete($fieldValue);
                continue;
            }
            $fieldValues[] = $fieldValue;
        }

        $model->$field = json_encode($fieldValues);
        $model->save();

        if ($thumbs && !empty($model->$field) && $model->$field != '[]') {
            $modelImages = json_decode($model->$field);
            foreach ($modelImages as $modelImage) {
                $image = Image::make(storage_path('app/public/' . $modelImage));
                $image->backup();
                if ($image) {
                    $ext = mb_strrchr($modelImage, '.');
                    $pos = mb_strrpos($modelImage, '.');
                    $fileName = mb_substr($modelImage, 0, $pos);
                    foreach ($thumbs as $key => $value) {
                        $image->fit($value[0], $value[1])->save(storage_path('app/public/' . $fileName . '-' . $key . $ext));
                        $image->reset();
                    }
                }
            }
        }
        return $model;
    }

    public static function createModelImage($imagePath, $model, $dir, $thumbs = [])
    {
        $newImageDir = storage_path('app/public/') . $dir . '/' . date('FY') . '/';
        if (!is_dir($newImageDir)) {
            mkdir($newImageDir, 0755, true);
        }
        $fileBaseName = basename($imagePath);
        $newImagePath = $newImageDir . $fileBaseName;
        $result = File::move($imagePath, $newImagePath);
        if ($result) {
            $modelImage = $dir . '/' . date('FY') . '/' . $fileBaseName;
            $model->image = $modelImage;
            $model->save();
            if ($thumbs) {
                $image = Image::make($newImagePath);
                $image->backup();
                if ($image) {
                    $ext = mb_strrchr($fileBaseName, '.');
                    $pos = mb_strrpos($fileBaseName, '.');
                    $fileName = mb_substr($fileBaseName, 0, $pos);
                    foreach ($thumbs as $key => $value) {
                        $image->fit($value[0], $value[1])->save($newImageDir . $fileName . '-' . $key . $ext);
                        $image->reset();
                    }
                }
            }
        }
        return $model;
    }

    public static function createModelImages($imagePaths, $model, $dir, $thumbs = [])
    {
        $savedImages = [];
        foreach ($imagePaths as $imagePath) {
            $newImageDir = storage_path('app/public/') . $dir . '/' . date('FY') . '/';
            if (!is_dir($newImageDir)) {
                mkdir($newImageDir, 0755, true);
            }
            $fileBaseName = basename($imagePath);
            $newImagePath = $newImageDir . $fileBaseName;
            $result = File::move($imagePath, $newImagePath);
            if ($result) {
                $savedImages[] = [
                    'newImageDir' => $newImageDir,
                    'fileBaseName' => $fileBaseName,
                    'newImagePath' => $newImagePath,
                    'modelImage' => $dir . '/' . date('FY') . '/' . $fileBaseName,
                ];
            }
        }

        if ($savedImages) {
            $modelImages = [];
            foreach ($savedImages as $savedImage) {
                $modelImages[] = $savedImage['modelImage'];
                $newImageDir = $savedImage['newImageDir'];
                $fileBaseName = $savedImage['fileBaseName'];
                $newImagePath = $savedImage['newImagePath'];
                if ($thumbs) {
                    $image = Image::make($newImagePath);
                    $image->backup();
                    if ($image) {
                        $ext = mb_strrchr($fileBaseName, '.');
                        $pos = mb_strrpos($fileBaseName, '.');
                        $fileName = mb_substr($fileBaseName, 0, $pos);
                        foreach ($thumbs as $key => $value) {
                            $image->fit($value[0], $value[1])->save($newImageDir . $fileName . '-' . $key . $ext);
                            $image->reset();
                        }
                    }
                }
            }
            $model->images = json_encode($modelImages);
            $model->save();
        }
        return $model;
    }

    public static function createModelImageThumbs($imagePath, $model, $dir, $thumbs)
    {
    }

    public static function checkModelActive($model)
    {
        $className = get_class($model);
        if (!isset($model->status) || !defined("$className::STATUS_ACTIVE") || (int)$model->status !== $className::STATUS_ACTIVE) {
            abort(404);
        }
    }

    public static function staticText($key, $cacheTime = 21600)
    {
        $locale = app()->getLocale();
        return Cache::remember($key . '-' . $locale, $cacheTime, function () use ($key, $locale) {
            return StaticText::where('key', $key)->withTranslation($locale)->first();
        });
    }

    public static function seo($name, $field, $replacements = [])
    {
        $key = 'seo_template_' . $name . '_' . $field;
        $template = static::staticText($key, 300);
        if (!$template) {
            return '';
        }
        return static::replaceTemplates($template->getTranslatedAttribute('description'), $replacements);
    }

    public static function seoTemplate($model, $name, $replacements = [])
    {
        $texts = [
            'seo_template_' . $name . '_seo_title',
            'seo_template_' . $name . '_meta_description',
            'seo_template_' . $name . '_meta_keywords',
            'seo_template_' . $name . '_description',
            'seo_template_' . $name . '_body',
        ];
        foreach ($texts as $text) {
            $currentProperty = str_replace('seo_template_' . $name . '_', '', $text);
            if (empty($model->$currentProperty)) {
                $template = self::staticText($text);
                if ($template) {
                    $model->$currentProperty = self::replaceTemplates($template->description, $replacements);
                }
            }
        }
        return $model;
    }

    public static function replaceTemplates($text, $replacements = [])
    {
        if (!$replacements) {
            return $text;
        }
        return str_replace(
            array_map(
                function ($value) {
                    return '{' . $value . '}';
                },
                array_keys($replacements)
            ),
            array_values($replacements),
            $text
        );
    }

    public static function addRandomReview($model)
    {
        $names = collect([
            'Александр',
            'Амир',
            'Андрей',
            'Дамир',
            'Илья',
            'Максим',
            'Сергей',
            'Ulugbek',
        ]);
        $messages = collect([
            'Отлично!',
        ]);
        $data = [
            'name' => $names->random(),
            'body' => $messages->random(),
            'rating' => 5,
            'status' => Review::STATUS_ACTIVE,
        ];
        $model->reviews()->create($data);
    }

    public static function sendSMS($messageId, $phoneNumber, $message)
    {
        if (config('app.env') != 'production') {
            Log::info($message);
            return true;
        }

        // return self::sendSMSDiArt($messageId, $phoneNumber, $message);
        return self::sendSMSPlayMobile($messageId, $phoneNumber, $message);
        // return self::sendSMSEskiz($messageId, $phoneNumber, $message);
        // return true;
    }

    public static function sendSMSDiArt($messageId, $phoneNumber, $message)
    {
        $phoneNumber = preg_replace('#[^\d]#', '', $phoneNumber);
        $data = [
            ['phone' => $phoneNumber, 'text' => $message],
            // Если сообщения приходят в неправильной кодировке, используйте iconv:
            //['phone' => 'NUMBER', 'text' => utf8_encode(iconv('windows-1251', 'utf-8', 'TEXT'))],
        ];

        $client = new Client();
        $query = [
            "login" => config('services.diart.login'),
            "password" => config('services.diart.password'),
            "data" => json_encode($data)
        ];
        try {
            $client->request('POST', config('services.diart.api_url'), [
                'form_params' => $query
            ]);
        } catch (RequestException $e) {
            Log::info($e->getMessage());
        }
        return true;
    }

    public static function sendSMSPlayMobile($messageId, $phoneNumber, $message)
    {
        try {
            $client = new Client([
                'base_uri' => config('services.play_mobile.api_url'),
                'timeout'  => 5.0,
            ]);
            $response = $client->request('POST', 'send', [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(config('services.play_mobile.login') . ':' . config('services.play_mobile.password')),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'messages' => [
                        [
                            'recipient' => $phoneNumber,
                            'message-id' => $messageId,
                            'sms' => [
                                'originator' => '3700',
                                'content' => [
                                    'text' => $message,
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

            $code = $response->getStatusCode(); // 200
            $reason = $response->getReasonPhrase(); // OK
            return $code == 200 ? true : false;

        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }

        return false;
    }

    public static function sendSMSEskiz($messageId, $phoneNumber, $message)
    {
        // try {
        //     $client = new Client([
        //         'base_uri' => config('services.play_mobile.api_url'),
        //         'timeout'  => 5.0,
        //     ]);
        //     $response = $client->request('POST', 'send', [
        //         'headers' => [
        //             'Authorization' => 'Basic ' . base64_encode(config('services.play_mobile.login') . ':' . config('services.play_mobile.password')),
        //             'Accept' => 'application/json',
        //             'Content-Type' => 'application/json',
        //         ],
        //         'json' => [
        //             'messages' => [
        //                 [
        //                     'recipient' => $phoneNumber,
        //                     'message-id' => $messageId,
        //                     'sms' => [
        //                         'originator' => '3700',
        //                         'content' => [
        //                             'text' => $message,
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ],
        //     ]);

        //     $code = $response->getStatusCode(); // 200
        //     $reason = $response->getReasonPhrase(); // OK
        //     return $code == 200 ? true : false;

        // } catch (\Throwable $e) {
        //     Log::info($e->getMessage());
        // }

        return false;
    }

    public static function messagePrefix()
    {
        $name = str_replace(' ', '', Str::lower(config('app.name')));
        $prefix = config('app.env') == 'production' ? $name : 'test' . $name;
        return $prefix;
    }

    public static function getTree($collection, $parent = null, $level = 1)
    {
        $filtered = $collection->filter(function ($value) use ($parent) {
            return $value['parent_id'] == $parent;
        });
        $filtered->map(function ($item) use ($collection, $level) {
            $item['children'] = self::getTree($collection, $item->id, $level + 1);
        });
        return $filtered;
    }

    public static function activeCategories($category, $ids = [])
    {
        $ids[] = $category->id;
        if ($category->parent) {
            $ids = self::activeCategories($category->parent, $ids);
        }
        return $ids;
    }

    public static function siblingPages(Page $page)
    {
        $locale = app()->getLocale();
        if ($page->parent_id) {
            $siblingPages = Page::active()->where('parent_id', $page->parent_id)->with(['pages' => function ($q) use ($locale) {
                $q->active()->withTranslation($locale);
            }])->get();
        } else {
            $siblingPages = Page::active()->whereNull('parent_id')->with(['pages' => function ($q) use ($locale) {
                $q->active()->withTranslation($locale);
            }])->get();
        }
        return $siblingPages;
    }

    /**
     * Get file url
     */
    public static function getFileUrl($fileString)
    {
        $file = json_decode($fileString);
        return (!empty($file[0]->download_link)) ? Voyager::image($file[0]->download_link) : '';
        // return (!empty($file[0]->download_link)) ? Storage::disk(config('voyager.storage.disk'))->url($file[0]->download_link) : '';
    }

    /**
     * Get file original name
     */
    public static function getFileOriginalName($fileString)
    {
        $file = json_decode($fileString);
        return (!empty($file[0]->original_name)) ? $file[0]->original_name : '';
    }

    public static function getCurrentRegionID()
    {
        $currentRegionID = Cookie::get('region_id', '');
        if (!$currentRegionID || !is_numeric($currentRegionID)) {
            return 14; // Tashkent ID
        }
        return (int)$currentRegionID;
    }

    public static function getCurrentRegion()
    {
        $currentRegionID = self::getCurrentRegionID();
        $region = Region::find($currentRegionID);
        if (!$region) {
            $region = Region::first();
        }
        $region->load('translations');
        return $region;
    }

    public static function changeEnvironmentVariable($key, $value)
    {
        $path = base_path('.env');

        if (is_bool(env($key))) {
            $old = env($key) ? 'true' : 'false';
        } elseif (env($key) === null) {
            $old = 'null';
        } else {
            $old = env($key);
        }

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                "$key=" . $old,
                "$key=" . $value,
                file_get_contents($path)
            ));
        }
    }

    public static function setting($key, $cacheTime = 3600)
    {
        return Cache::remember($key, $cacheTime, function () use ($key) {
            return setting($key);
        });
    }

    public static function exchangeRate()
    {
        $rate = (float)self::setting('site.exchange_rate');
        if ($rate <= 0) {
            $rate = 1;
        }
        return $rate;
    }

    public static function escapeFullTextSearch($string)
    {
        $string = preg_replace('/[^\p{L}\p{N}_]+/u', ' ', $string);
        $string = preg_replace('/[+\-><\(\)~*\"@]+/', ' ', $string);
        return $string;
    }

}
