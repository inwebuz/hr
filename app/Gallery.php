<?php

namespace App;

use App\Events\ModelDeleted;
use App\Events\ModelSaved;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Resizable;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Gallery extends Model
{
    use Translatable;
    use Resizable;
    use HasFactory;

    /**
     * Statuses.
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static $imgSizes = [
        'medium' => [369, 277],
        'large' => [369, 369],
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

    public function getImgAttribute()
    {
        return $this->image ? Voyager::image($this->image) : asset('img/no-image.jpg');
    }

    public function getMediumImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'medium')) : asset('img/no-image.jpg');
    }

    public function getLargeImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'large')) : asset('img/no-image.jpg');
    }

    public function getMediumImgsAttribute()
    {
        return $this->getImgsGroup($this->images, 'medium');
    }

    public function getLargeImgsAttribute()
    {
        return $this->getImgsGroup($this->images, 'large');
    }

    public function getImgsAttribute()
    {
        return $this->getImgsGroup($this->images);
    }

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
        $url = 'galleries/' . $this->id . '-' . $slug;
        return LaravelLocalization::localizeURL($url, $lang);
    }

    public function scopeActive($query)
    {
        return $query->where('status', static::STATUS_ACTIVE);
    }
}
