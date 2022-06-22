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

class VacancyCategory extends Model
{
    use Resizable;
    use Translatable;
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public $additional_attributes = ['full_name'];

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

    protected static function booted()
    {
        static::saving(function ($vacancyCategory) {
            if ($vacancyCategory->id == $vacancyCategory->parent_id) {
                $vacancyCategory->parent_id = null;
            }
        });
    }

    public function searches()
    {
        return $this->morphMany(Search::class, 'searchable');
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }

    /**
     * scope active
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
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
        $url = 'vacancy-categories/' . $this->id . '-' . $slug;
        return LaravelLocalization::localizeURL($url, $lang);
    }

    public function getFullNameAttribute()
    {
        $names = array_reverse($this->fullName($this));
        $name = array_pop($names);
        if (count($names)) {
            $name .= ' (' . implode(' > ', $names) . ')';
        }
        return $name;
    }

    public function getHierarchyNameAttribute()
    {
        $names = array_reverse($this->fullName($this));
        return implode(' > ', $names);
    }

    public function getNameBrowseAttribute()
    {
        return $this->full_name;
    }

    public function parentId()
    {
        return $this->belongsTo(self::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function childrenIds($vacancyCategory, $ids = [])
    {
        $ids[] = $vacancyCategory->id;
        if (!$vacancyCategory->children->isEmpty()) {
            foreach ($vacancyCategory->children as $child) {
                if (!in_array($child->id, $ids)) {
                    $ids = $this->childrenIds($child, $ids);
                }
            }
        }
        return $ids;
    }

    private function fullName($vacancyCategory)
    {
        $ids = self::parentIDs($vacancyCategory);
        $categories = VacancyCategory::whereIn('id', $ids)->withTranslation(app()->getLocale())->get();
        $names = [];
        foreach ($ids as $id) {
            $c = $categories->where('id', $id)->first();
            if ($c) {
                $names[] = $c->getTranslatedAttribute('name');
            }
        }
        return $names;
    }

    public static function parentIDs($vacancyCategory, $ids = [])
    {
        $ids[] = $vacancyCategory->id;
        if ($vacancyCategory->parent && !in_array($vacancyCategory->parent->id, $ids)) {
            $ids = self::parentIDs($vacancyCategory->parent, $ids);
        }
        return $ids;
    }
}
