<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class BrandCategoryText extends Model
{
    use Translatable;

    protected $translatable = ['name', 'description', 'body', 'seo_title', 'meta_description', 'meta_keywords', 'h1_name'];

    protected $guarded = [];
}
