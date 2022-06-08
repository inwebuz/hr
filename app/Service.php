<?php

namespace App;

use App\Events\ModelDeleted;
use App\Events\ModelSaved;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Resizable;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use Resizable;
    use Translatable;
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const FEATURED_INACTIVE = 0;
    const FEATURED_ACTIVE = 1;

    public static $iconImgSizes = [
        'small' => [50, 50],
    ];
    public static $imgSizes = [
        'medium' => [370, 411],
    ];

    protected $appends = [
        'url',
        'img',
    ];

    protected $translatable = ['name', 'slug', 'description', 'body', 'seo_title', 'meta_description', 'meta_keywords'];

    protected $guarded = [];

    protected $dispatchesEvents = [
        'saved' => ModelSaved::class,
        'deleted' => ModelDeleted::class,
    ];

    public function searches()
    {
        return $this->morphMany(Search::class, 'searchable');
    }

    /**
     * scope active
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * scope featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', self::FEATURED_ACTIVE);
    }

    public function getIconImgAttribute()
    {
        return $this->icon ? Voyager::image($this->icon) : asset('images/no-image.jpg');
    }

    public function getIconSmallImgAttribute()
    {
        return $this->icon ? Voyager::image($this->getThumbnail($this->icon, 'small')) : asset('images/no-image.jpg');
    }

    /**
     * Get main image
     */
    public function getImgAttribute()
    {
        return $this->image ? Voyager::image($this->image) : asset('images/no-image.jpg');
    }

    /**
     * Get micro image
     */
    public function getMicroImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'micro')) : asset('images/no-image.jpg');
    }

    /**
     * Get small image
     */
    public function getSmallImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'small')) : asset('images/no-image.jpg');
    }

    /**
     * Get medium image
     */
    public function getMediumImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'medium')) : asset('images/no-image.jpg');
    }

    /**
     * Get large image
     */
    public function getLargeImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'large')) : asset('images/no-image.jpg');
    }

    /**
     * Get url
     */
    public function getURLAttribute()
    {
        return $this->getURL();
    }

    /**
     * Get url
     */
    public function getURL($lang = '')
    {
        if (!$lang) {
            $lang = app()->getLocale();
        }
        $slug = $this->getTranslatedAttribute('slug', $lang) ?: $this->slug;
        $url = 'services/' . $this->id . '-' . $slug;
        return LaravelLocalization::localizeURL($url, $lang);
    }
}
