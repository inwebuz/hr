<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Resizable;

class Review extends Model
{
    use HasFactory;
    use Resizable;

    /**
     * Statuses.
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;

    protected $guarded = [];

    public static $avatarSizes = [
        'micro' => [80, 80],
    ];
    public static $certificateSizes = [
        'small' => [200, 280],
    ];

    protected static function boot()
    {
        parent::boot();
        self::saving(function ($model) {
            if (!$model->reviewable_id) {
                $model->reviewable_id = 1;
            }
            if (!$model->reviewable_type) {
                $model->reviewable_type = Page::class;
            }
        });
    }

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * scope active
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeMain($query)
    {
        return $query->where('reviewable_id', 1)->where('reviewable_type', 'App\Page');
    }

    public function getAvatarImgAttribute()
    {
        return $this->avatar ? Voyager::image($this->avatar) : asset('images/no-image.jpg');
    }

    public function getAvatarMicroImgAttribute()
    {
        return $this->avatar ? Voyager::image($this->getThumbnail($this->avatar, 'micro')) : asset('images/no-image.jpg');
    }

    public function getCertificate1ImgAttribute()
    {
        return $this->certificate1 ? Voyager::image($this->certificate1) : asset('images/no-image.jpg');
    }

    public function getCertificate1SmallImgAttribute()
    {
        return $this->certificate1 ? Voyager::image($this->getThumbnail($this->certificate1, 'small')) : asset('images/no-image.jpg');
    }

    public function getCertificate2ImgAttribute()
    {
        return $this->certificate2 ? Voyager::image($this->certificate2) : asset('images/no-image.jpg');
    }

    public function getCertificate2SmallImgAttribute()
    {
        return $this->certificate2 ? Voyager::image($this->getThumbnail($this->certificate2, 'small')) : asset('images/no-image.jpg');
    }
}
