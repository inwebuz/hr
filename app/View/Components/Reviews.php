<?php

namespace App\View\Components;

use App\Helpers\Helper;
use App\Review;
use App\StaticText;
use Illuminate\View\Component;

class Reviews extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        $reviewsText = Helper::staticText('reviews', 5);
        $reviews = Review::active()->main()->latest()->take(6)->get();
        return view('components.reviews', compact('reviewsText', 'reviews'));
    }
}
