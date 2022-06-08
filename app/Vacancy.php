<?php

namespace App;

use App\Events\ModelDeleted;
use App\Events\ModelSaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Resizable;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacancy extends Model
{
    use Resizable;
    use Translatable;
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static $imgSizes = [
        'medium' => [200, 200],
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
        $url = 'vacancies/' . $this->id . '-' . $slug;
        return LaravelLocalization::localizeURL($url, $lang);
    }

    /**
     * Get background image
     */
    public function getBgAttribute()
    {
        return $this->background ? Voyager::image($this->background) : asset('img/bg.jpg');
    }

    /**
     * Get main image
     */
    public function getImgAttribute()
    {
        return $this->image ? Voyager::image($this->image) : asset('images/product/no-image.jpg');
    }

    /**
     * Get micro image
     */
    public function getMicroImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'micro')) : asset('images/product/no-image-micro.jpg');
    }

    /**
     * Get small image
     */
    public function getSmallImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'small')) : asset('images/product/no-image-small.jpg');
    }

    /**
     * Get medium image
     */
    public function getMediumImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'medium')) : asset('images/product/no-image-medium.jpg');
    }

    /**
     * Get large image
     */
    public function getLargeImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'large')) : asset('images/product/no-image-large.jpg');
    }

    /**
     * Get second small image
     */
    public function getSecondSmallImgAttribute()
    {
        return $this->gallery_small_img ? $this->gallery_small_img : $this->small_img;
    }

    /**
     * Get second medium image
     */
    public function getSecondMediumImgAttribute()
    {
        return $this->gallery_medium_img ? $this->gallery_medium_img : $this->medium_img;
    }

    /**
     * Get gallery small images
     */
    public function getSmallImgsAttribute()
    {
        return $this->getImgsGroup($this->images, 'small');
    }

    /**
     * Get gallery medium images
     */
    public function getMediumImgsAttribute()
    {
        return $this->getImgsGroup($this->images, 'medium');
    }

    /**
     * Get gallery large images
     */
    public function getLargeImgsAttribute()
    {
        return $this->getImgsGroup($this->images, 'large');
    }

    /**
     * Get gallery original images
     */
    public function getImgsAttribute()
    {
        return $this->getImgsGroup($this->images);
    }

    /**
     * Get gallery small first image
     */
    public function getGallerySmallImgAttribute()
    {
        $images = $this->getImgsGroup($this->images, 'small');
        return $images[0] ?? '';
    }

    /**
     * Get gallery medium first image
     */
    public function getGalleryMediumImgAttribute()
    {
        $images = $this->getImgsGroup($this->images, 'medium');
        return $images[0] ?? '';
    }

    /**
     * get raw images
     */
    private function getImgsGroup($images, $type = '')
    {
        $group = [];
        $getImages = json_decode($images);
        if (is_array($getImages)) {
            foreach ($getImages as $value) {
                $group[] = ($type == '') ? Voyager::image($value) : Voyager::image($this->getThumbnail($value, $type));
            }
        }
        return $group;
    }

    public function getShortNameAttribute()
    {
        return Str::limit($this->name, 40, ' ...');
    }

    public function getShortDescriptionAttribute()
    {
        return Str::words($this->description, 10, ' ...');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
}
