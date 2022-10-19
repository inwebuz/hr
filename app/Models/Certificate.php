<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Resizable;

class Certificate extends Model
{
    use HasFactory;
    use Resizable;

    public static $imgSizes = [
        'small' => [200, 280],
    ];

    public function getImgAttribute()
    {
        return $this->image ? Voyager::image($this->image) : asset('images/no-image.jpg');
    }

    public function getSmallImgAttribute()
    {
        return $this->image ? Voyager::image($this->getThumbnail($this->image, 'small')) : asset('images/no-image.jpg');
    }
}
