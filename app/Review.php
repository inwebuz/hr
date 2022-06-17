<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * Statuses.
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;

    protected $guarded = [];

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
}
