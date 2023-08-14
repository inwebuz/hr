<?php

namespace App;

use App\Shop;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Resizable;
use App\Traits\Translatable;

class Banner extends Model
{
    use Resizable;
    use Translatable;

    protected $translatable = ['name', 'description_top', 'description', 'description_bottom', 'button_text', 'url'];

    /**
     * Statuses.
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;

    /**
     * Types.
     */
    const TYPE_SLIDE = 'slide';
    const TYPE_HOME_1 = 'home_1';
    const TYPE_HOME_2 = 'home_2';
    const TYPE_HOME_3 = 'home_3';
    const TYPE_LINE_1 = 'line_1';
    const TYPE_MIDDLE_1 = 'middle_1';
    const TYPE_MIDDLE_2 = 'middle_2';
    const TYPE_MIDDLE_3 = 'middle_3';
    const TYPE_MOBILE_MENU = 'mobile_menu';
    const TYPE_SIDEBAR_1 = 'sidebar_1';
    const TYPE_SIDEBAR_2 = 'sidebar_2';
    const TYPE_MENU_CATEGORY = 'menu_category';
    const TYPE_CATEGORY_TOP = 'category_top';
    const TYPE_CATEGORY_BOTTOM = 'category_bottom';
    const TYPE_MIDDLE_SLIDE = 'middle_slide';


    /**
     * List of statuses.
     *
     * @var array
     */
    public static $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_PENDING];

    protected $guarded = [];

    /**
     * Scope a query to only include active banners.
     *
     * @param  $query  \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', static::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include active banners.
     *
     * @param  $query  \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNowActive($query)
    {
        return $query->where([['active_from', '>=', date('Y-m-d H:i:s')], ['active_to', '<=', date('Y-m-d H:i:s')]]);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     *
     */
    public function bannerStats()
    {
        return $this->hasMany(BannerStats::class);
    }

    /**
     * Get main image
     */
    public function getImgAttribute()
    {
        $locale = app()->getLocale();
        $localeImage = 'image_' . $locale;
        $image = !empty($this->$localeImage) ? $this->$localeImage : $this->image;
        return $image ? Voyager::image($image) : asset('images/no-image.jpg');
    }

    /**
     * Get main image
     */
    public function getImgMobileAttribute()
    {
        $locale = app()->getLocale();
        $localeImage = 'image_mobile_' . $locale;
        $image = !empty($this->$localeImage) ? $this->$localeImage : $this->image_mobile;
        return $image ? Voyager::image($image) : asset('images/no-image.jpg');
    }

    /**
     * Get increment clicks url
     */
    public function getIncrementClicksUrlAttribute()
    {
        return route('banner.increment.clicks', $this->id);
    }

    /**
     * Get increment views url
     */
    public function getIncrementViewsUrlAttribute()
    {
        return route('banner.increment.views', $this->id);
    }

    public static function types()
    {
        return [
            self::TYPE_SLIDE => 'Слайд (1037x380)',
            // self::TYPE_HOME_1 => 'Главная 1',
            // self::TYPE_HOME_2 => 'Главная 2',
            // self::TYPE_HOME_3 => 'Главная 3',
            // self::TYPE_LINE_1 => 'Полоска 1 (1390x130)',
            // self::TYPE_MIDDLE_1 => 'Середина 1 (448x215)',
            // self::TYPE_MIDDLE_2 => 'Середина 2 (448x215)',
            // self::TYPE_MIDDLE_3 => 'Середина 3 (448x215)',
            // self::TYPE_MOBILE_MENU => 'Мобильное меню',
            // self::TYPE_SIDEBAR_1 => 'Левая колонка 1 (382x534)',
            // self::TYPE_SIDEBAR_2 => 'Левая колонка 2 (382x534)',
            // self::TYPE_MENU_CATEGORY => 'Категории в меню (360x440)',
            // self::TYPE_MIDDLE_SLIDE => 'Слайд акции и скидки (542x390)',
            // self::TYPE_CATEGORY_TOP => 'Категория верхняя часть (1390x225)',
            // self::TYPE_CATEGORY_BOTTOM => 'Категория нижняя часть (1390x225)',
        ];
    }

    public function scopeMenuCategory($query)
    {
        return $query->where('type', self::TYPE_MENU_CATEGORY);
    }

    public function scopeCategoryTop($query)
    {
        return $query->where('type', self::TYPE_CATEGORY_TOP);
    }

    public function scopeCategoryBottom($query)
    {
        return $query->where('type', self::TYPE_CATEGORY_BOTTOM);
    }
}
